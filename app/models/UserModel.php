<?php

namespace App\Models;

class UserModel {
	private $username;

	public function __construct($username=null){
		if($username){
			$this->username = $username;
		}
	}

	public function fetchUser(DB $db){
		$st = $db->conn->prepare("SELECT u.*, ui.Path, ui.Alt FROM users u INNER JOIN userimages ui ON u.IdProfile = ui.Id WHERE username = ?");
		$st->bindValue(1,$this->username);
		$st->execute();
		$row = $st->fetch();
		if($row){
			return $row;
		} else {
			$st = $db->conn->prepare("SELECT * FROM users WHERE username = ?");
			$st->bindValue(1,$this->username);
			$st->execute();
			return $st->fetch();
		}
	}

	public function insertUser(DB $db, $password, $gmail, $gender,$role=null) {
		$st = $db->conn->prepare("SELECT * FROM users WHERE username = ?");
		$st->bindValue(1,$this->username);
		$st->execute();
		$user = $st->fetch();
		if($user){
			echo "<h1>This username is already taken!</h1><br>";
			echo "<a href='../../index.php'>go back</a>";
			die();
		}
		if($role){
			$st = $db->conn->prepare("INSERT INTO users(username, password, gmail, gender,Role) VALUES(?,?,?,?,?)");
		} else {
			$st = $db->conn->prepare("INSERT INTO users(username, password, gmail, gender,Role) VALUES(?,?,?,?,2)");
		}
		$st->bindValue(1,$this->username);
		$st->bindValue(2,md5($password));
		$st->bindValue(3,$gmail);
		$st->bindValue(4,$gender);
		if($role) {
			$st->bindValue(5,$role);
		}
		try {
			$st->execute();
			$db->logAction("registered",$this->username,"..");
			echo json_encode("Successful registration!");
			http_response_code(200);
		}
		catch (PDOException $e) {
			echo $e->getMessage();
			$db->logError("UserModel",400,"..");
		}
	}

	public function updatePw(DB $db, $password) {
		$st = $db->conn->prepare("UPDATE users SET password = ? WHERE username = ?");
		$st->bindValue(1, md5($password));
		$st->bindValue(2, $this->username);
		try {
			$st->execute();
			return null;
		} catch(PDOException $e) {
			return $e->getMessage();
			$db->logError("UserModel",400,"..");
		}
	}

	public function updateRole(DB $db, $role) {
		$st = $db->conn->prepare("UPDATE users SET Role = ? WHERE username = ?");
		$st->bindValue(1, $role);
		$st->bindValue(2, $this->username);
		try {
			$st->execute();
			return null;
		} catch(PDOException $e) {
			return $e->getMessage();
			$db->logError("UserModel",400,"..");
		}
	}

	public function updateGender(DB $db, $gender) {
		$st = $db->conn->prepare("UPDATE users SET gender = ? WHERE username = ?");
		$st->bindValue(1, $gender);
		$st->bindValue(2, $this->username);
		try {
			$st->execute();
			return null;
		} catch(PDOException $e) {
			return $e->getMessage();
			$db->logError("UserModel",400,"..");
		}
	}

	public function updateGmail(DB $db, $gmail) {
		$st = $db->conn->prepare("UPDATE users SET gmail = ? WHERE username = ?");
		$st->bindValue(1, $gmail);
		$st->bindValue(2, $this->username);
		try {
			$st->execute();
			return null;
		} catch(PDOException $e) {
			return $e->getMessage();
			$db->logError("UserModel",400,"..");
		}
	}

	public function updatePic(DB $db, $imgid) {
		$st = $db->conn->prepare("UPDATE users SET IdProfile = ? WHERE username = ?");
		$st->bindValue(1, $imgid);
		$st->bindValue(2, $this->username);
		try {
			$st->execute();
			return null;
		} catch(PDOException $e) {
			return $e->getMessage();
			$db->logError("UserModel",400,"..");
		}
	}

	public function fetchUsers(DB $db) {
		$st = $db->conn->prepare("SELECT IdUser, username FROM users");
		try {
			$st->execute();
			return $st->fetchAll();
		} catch(PDOException $e) {
			$e->getMessage();
			$db->logError("UserModel",400,"..");
		}
	}

	public function get_username() {
		return $this->username;
	}

	public function set_username($username) {
		$this->username = $username;
	}
}
