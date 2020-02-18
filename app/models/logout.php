<?php
	session_start();
	require_once "../config/database.php";
	use App\Models\DB;
	include "DB.php";
	$db = new DB(SERVER, DATABASE, USERNAME, PASSWORD);
	$db->logAction("logged out",$_SESSION["user"]->username,"..");
	unset($_SESSION["user"]);
	header("Location: ../../index.php");