<?php
	namespace App\Controllers;

	class PageController extends Controller {
		private $db;

	    public function __construct($db) {
	        $this->db = $db;
	    }
	    public function home() {
	    	$this->view("home");
	    }
	    public function contact() {
	    	$this->view("contact");
	    }
	    public function author() {
	    	$this->view("author");
	    }
	    public function profile() {
	    	$this->view("profile");
	    }
	    public function feed() {
	    	$this->view("feed");
	    }
	    public function admin() {
	    	$this->view("admin");
	    }
	}