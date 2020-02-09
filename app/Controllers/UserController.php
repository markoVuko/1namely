<?php 
namespace App\Controllers;
use App\Models\UserModel;
include "../models/UserModel.php";

	class UserController {
		private $db;
		public function __construct($db) {
			$this->db = $db;
		}

		public function register($username, $pw1, $pw2, $email, $gender){
			if(!isset($username)||!isset($pw1)||!isset($pw2)||!isset($email)||!isset($gender)||$pw1!=$pw2) {
				echo json_encode("Popunite sve podatke!");
				http_response_code(403);
			} else {
				$userModel = new UserModel($username);
				$genderText = "";
				switch ($gender) {
					case 1:
						$genderText = "Male";
						break;

					case 2:
						$genderText = "Female";
						break;

					case 3:
						$genderText = "Other";
						break;
					
					default:
						$genderText = "Other";
						break;
				}
				$userModel->insertUser($this->db,$pw1,$email,$genderText);
			}

		}

		public function login($username, $password) {
			if($this->authenticate($username,$password)) {

				session_start();
				$userModel = new UserModel($username);
				$user = $userModel->fetchUser($this->db);
				$_SESSION['user'] = $user;
				echo json_encode("Uspesno ste ulogovani, ".$user->username."!");
				http_response_code(200);
			} 
			else {
				return false;
			}
		}

		 function authenticate($username, $password) {
			$a = false;
			$userModel = new UserModel($username,$this->db);
			$user = $userModel->fetchUser($this->db);
			if($user!=null||$user->password==md5($password)){
				$a = true;
			}
			return $a;
		}

		function logout() {
			session_start();
			session_destroy();
		}
	}