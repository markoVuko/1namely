<?php

namespace App\Models;

class UserModel {
	private $username;

	public function __construct($username){
		$this->username = $username;
	}

	public function fetchUser(DB $db){
		$st = $db->conn->prepare("SELECT * FROM users WHERE username = ?");
		$st->bindValue(1,$this->username);
		$st->execute();
		return $st->fetch();
	}

	public function insertUser(DB $db, $password, $gmail, $gender) {
		$st = $db->conn->prepare("INSERT INTO users(username, password, gmail, gender) VALUES(?,?,?,?)");
		$st->bindValue(1,$this->username);
		$st->bindValue(2,md5($password));
		$st->bindValue(3,$gmail);
		$st->bindValue(4,$gender);
		try {
			$st->execute();
			echo json_encode("Successful registration!");
			http_response_code(200);
		}
		catch (PDOException $e) {
			echo $e->getMessage();
			http_response_code(400);
		}
	}

	public function get_username() {
		return $this->username;
	}

	public function set_username($username) {
		$this->username = $username;
	}
}
