<?php

	namespace App\Controllers;
	use App\Models\DB;
	use App\Controllers\UserController;
	require_once "../config/database.php";


	if(isset($_POST["action"])) {
		switch ($_POST["action"]) {
			case 'login':
				include "UserController.php";
				include "../models/DB.php";
				$db = new DB(SERVER, DATABASE, USERNAME, PASSWORD);
				$userCont = new UserController($db);
				$userCont->login($_POST["username"],$_POST["password"]);
				break;

			case 'register':
				include "UserController.php";
				include "../models/DB.php";
				$db = new DB(SERVER, DATABASE, USERNAME, PASSWORD);
				$userCont = new UserController($db);
				$userCont->register($_POST["username"],$_POST["pw1"],$_POST["pw2"],$_POST["gmail"],$_POST["gender"]);
				break;
			
			default:
				# code...
				break;
		}
	} else {
		header("Location: ../../index.php");
	}