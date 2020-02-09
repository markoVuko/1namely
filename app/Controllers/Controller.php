<?php 
	namespace App\Controllers;

class Controller {

    protected function view($fileName){    
        include "app/views/sections/head.php";
        include "app/views/sections/menu.php";
        include "app/views/pages/$fileName.php";
        include "app/views/sections/footer.php";
    }
}