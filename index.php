<?php 
	require_once "app/config/autoload.php";
	require_once "app/config/database.php";

	use App\Models\DB;
	use App\Controllers\PageController;

	$db = new DB(SERVER, DATABASE, USERNAME, PASSWORD);

	$pageController = new PageController($db);

	if(isset($_GET["page"])) {
		switch ($_GET["page"]) {
			case 'contact':
				# code...
				break;
			case 'author':
				# code...
				break;
			
			default:
				$pageController->home();
				break;
		}
	} else {
		$pageController->home();
	}