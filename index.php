<?php 
	session_start();
	
	require_once "app/config/autoload.php";
	require_once "app/config/database.php";

	use App\Models\DB;
	use App\Controllers\PageController;

	$db = new DB(SERVER, DATABASE, USERNAME, PASSWORD);

	$pageController = new PageController($db);

	if(isset($_GET["page"])) {
		switch ($_GET["page"]) {
			case 'contact':
				if(isset($_SESSION["user"])){
					$db->logAction("visited contact",$_SESSION["user"]->username,"app");
				}
				$pageController->contact();
				break;

			case 'feed':
				$db->logAction("visited fed",$_SESSION["user"]->username,"app");
				$pageController->feed();
				break;

			case 'admin':
				$db->logAction("visited admin",$_SESSION["user"]->username,"app");
				$pageController->admin();
				break;
			
			default:
				if(isset($_SESSION["user"])) {
					$db->logAction("visited profile",$_SESSION["user"]->username,"app");
					$pageController->profile();
				} else {
					$pageController->home();
				}
				break;
		}
	} else {
		if(isset($_SESSION["user"])) {
					$db->logAction("visited profile",$_SESSION["user"]->username,"app");
					$pageController->profile();
				} else {
					$pageController->home();
				}
	}