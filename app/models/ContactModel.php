<?php
	namespace App\Models;

	class ContactModel {

		public function __construct() {

		}

		public function insertContact(DB $db, $first, $last, $email, $num, $gender, $text){
			$st = $db->conn->prepare("INSERT INTO sent(Name,Surname,Num,Email,Gender,Text) VALUES(?,?,?,?,?,?)");
			$st->bindValue(1,$first);
			$st->bindValue(2,$last);
			$st->bindValue(3,$num);
			$st->bindValue(4,$email);
			$st->bindValue(5,$gender);
			$st->bindValue(6,$text);
			try {
				$st->execute();
				http_response_code(204);
			}
			catch(PDOEXCEPTION $e){
				echo $e->getMessage();
				$db->logError("ContactModel",409,"..");
			}
		}

		public function fetchContact(DB $db) {
			$st = $db->conn->prepare("SELECT * FROM sent");
			$st->execute();
			return $st->fetchAll();
		}
	}