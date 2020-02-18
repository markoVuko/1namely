<?php

	namespace App\Controllers;
	use App\Models\DB;
	use App\Controllers\UserController;
	use App\Controllers\ContactController;
	require_once "../config/database.php";



	if(isset($_POST["action"])) {
		include "UserController.php";
		include "ContactController.php";
		include "../models/DB.php";
		$db = new DB(SERVER, DATABASE, USERNAME, PASSWORD);
		switch ($_POST["action"]) {
			case 'login':
				$userCont = new UserController($db);
				$userCont->login($_POST["logUser"],$_POST["logPw"]);
				header("Location: ../../index.php");
				break;

			case 'register':
				$userCont = new UserController($db);
				$userCont->register($_POST["regUser"],$_POST["regPw1"],$_POST["regPw2"],$_POST["regGmail"],$_POST["regGender"]);
				$userCont->login($_POST["regUser"],$_POST["regPw1"]);
				header("Location: ../../index.php");
				break;
			case 'insertuser':
				$userCont = new UserController($db);
				$userCont->insert($_POST["username"],$_POST["pw"],$_POST["gmail"],$_POST["gender"],$_POST["role"]);
				break;

			case 'edituser':
				$userCont = new UserController($db);
				$name = null;
				$tmp = null;
				$type = null;
				$size = null;
				if(isset($_FILES["image"])) {
					$name = $_FILES["image"]["name"];
					$tmp = $_FILES["image"]["tmp_name"];
					$type = $_FILES["image"]["type"];
					$size = $_FILES["image"]["size"];
				}
				$userCont->editUser($_POST["username"],$_POST["pw1"],$_POST["pw2"],$_POST["gmail"], $name, $tmp, $type, $size);
				break;

			case 'subpost':
				$userCont = new UserController($db);
				$name = null;
				$tmp = null;
				$type = null;
				$size = null;
				if(isset($_FILES["pimage"])) {
					$name = $_FILES["pimage"]["name"];
					$tmp = $_FILES["pimage"]["tmp_name"];
					$type = $_FILES["pimage"]["type"];
					$size = $_FILES["pimage"]["size"];
				}
				$userCont->submitPost($_POST["puid"],$_POST["ptitle"],$_POST["ptext"], $name, $tmp, $type, $size);
				break;

			case 'showuserposts':
				$userCont = new UserController($db);
				$userCont->showUserPosts($_POST["puid"],$_POST["username"]);
				break;

			case 'showglobalposts':
				$userCont = new UserController($db);
				$userCont->showGlobalPosts($_POST["username"]);
				break;

			case 'showuserstats':
				$userCont = new UserController($db);
				$userCont->userStats($_POST["their_username"], $_POST["my_username"]);
				break;

			case 'followuser':
				$userCont = new UserController($db);
				$userCont->followUser($_POST["my_username"],$_POST["their_username"]);
				break;

			case 'unfollowuser':
				$userCont = new UserController($db);
				$userCont->unfollowUser($_POST["my_username"],$_POST["their_username"]);
				break;

			case 'showfollowedposts':
				$userCont = new UserController($db);
				$userCont->showFollowedPosts($_POST["username"]);
				break;

			case 'fetchuser':
				$userCont = new UserController($db);
				$userCont->returnUser($_POST["username"]);
				break;

			case 'adminedit':
				$userCont = new UserController($db);
				$name = null;
				$tmp = null;
				$type = null;
				$size = null;
				if(isset($_FILES["image"])) {
					$name = $_FILES["image"]["name"];
					$tmp = $_FILES["image"]["tmp_name"];
					$type = $_FILES["image"]["type"];
					$size = $_FILES["image"]["size"];
				}
				$userCont->editUser($_POST["username"],null,null,$_POST["gmail"], $name, $tmp, $type, $size, $_POST["role"],$_POST["gender"],$_POST["pw"]);
				break;

			case 'contact':
				$contactController = new ContactController($db);
				$contactController->sendContact($_POST["firstName"],$_POST["lastName"],$_POST["email"],$_POST["num"],$_POST["gender"],$_POST["text"]);
				break;

			case 'like':
				$userCont = new UserController($db);
				$userCont->likePost($_POST['post'],$_POST['username']);
				break;
			case 'unlike':
				$userCont = new UserController($db);
				$userCont->unlikePost($_POST['post'],$_POST['username']);
				break;
		}
	} else {
		header("Location: ../../index.php");
	}