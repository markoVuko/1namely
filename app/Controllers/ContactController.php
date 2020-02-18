<?php
	namespace App\Controllers;
	use App\Models\ContactModel;
	include "../models/ContactModel.php";

	class ContactController {
		private $db;
		public function __construct($db) {
			$this->db = $db;
		}

		public function sendContact($first, $last, $email, $num, $gender, $text){
			$firstNameRx = "/^[A-Z][a-z]{2,11}$/";
			$lastNameRx = "/^[A-Z][a-z]{2,19}$/";
			$numRX = "/^06[1-9](\s|-|\/)?[0-9]{3}(\s|-|\/)?[0-9]{3,4}$/";
			$greske = [];
			if(!preg_match($firstNameRx, $first)){
				array_push($greske, "Invalid first name.");
			}
			if(!preg_match($lastNameRx, $last)){
				array_push($greske, "Invalid last name.");
			}
			if(!preg_match($numRX, $num)){
				array_push($greske, "Invalid number.");
			}
			if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
				array_push($greske, "Invalid email.");
			}
			if(empty($gender)){
				array_push($greske, "Pick a gender.");
			}
			if(empty($text)){
				array_push($greske, "Write your feedback.");
			}
			if(count($greske)>0){
				echo json_encode($greske);
				http_response_code(412);
				$this->db->logError(412,"..");
			}
			if(count($greske)==0){
				$contactModel = new ContactModel();
				$contactModel->insertContact($this->db, $first, $last, $email, $num, $gender, $text);
			}
		}
	}