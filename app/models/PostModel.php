<?php
	
	namespace App\Models;

	class PostModel {
		private $title;
		private $text;
		private $by;

		public function __construct($title=null, $text=null, $by=null){
			if($title) {
				$this->title = $title;
				$this->text = $text;
				$this->by = $by;
			}
		}

		public function subpost(DB $db, $name=null, $tmp=null, $type=null, $size=null){
			if($name!=null) {
				switch($type){
					case "image/jpeg": case "image/jpg": 
						$slika = imagecreatefromjpeg($tmp);
						break;
					case "image/png": 
						$slika = imagecreatefrompng($tmp);
						break;
					case "image/gif": 
						$slika = imagecreatefromgif($tmp);
					}
					$dim = 1000;
					$old_dims = getimagesize($tmp);
					$new_dims = $old_dims;
					if($dim<$old_dims[0]){
						$ratio = $dim/$old_dims[0];
						$new_dims[0] = $dim;
						$new_dims[1] = $old_dims[1]*$ratio;
					}
					if($dim<$old_dims[1]){
						$ratio = $dim/$old_dims[1];
						$new_dims[1] = $dim;
						$new_dims[0] = $old_dims[0]*$ratio;
					}
					$nova_slika = imagecreatetruecolor($new_dims[0], $new_dims[1]);
					imagecopyresampled($nova_slika, $slika, 0, 0, 0, 0, $new_dims[0], $new_dims[1], $old_dims[0], $old_dims[1]);
					$path = "assets/img/".time().$name;
					$split = explode(".",$name);
					switch($type){
					case "image/jpeg": case "image/jpg": 
						imagejpeg($nova_slika,"../".$path);
						break;
					case "image/png": 
						imagepng($nova_slika,"../".$path);
						break;
					case "image/gif": 
						imagegif($nova_slika,"../".$path);
					}
					$st=$db->conn->prepare("INSERT INTO posts(title,text,path,alt,IdUser) VALUES(?,?,?,?,?)");
					$st->bindValue(1,$this->title);
					$st->bindValue(2,$this->text);
					$st->bindValue(3,$path);
					$st->bindValue(4,$split[0]);
					$st->bindValue(5,$this->by);
					try {
						$st->execute();
						return intval($db->conn->lastInsertId());
						
					}
					catch(PDOException $e){
						$db->logError("PostModel",400,"..");
						return $e->getMessage();
					}
			} else {
					$st=$db->conn->prepare("INSERT INTO posts(title,text,IdUser) VALUES(?,?,?)");
					$st->bindValue(1,$this->title);
					$st->bindValue(2,$this->text);
					$st->bindValue(3,$this->by);
					try {
						$st->execute();
						return intval($db->conn->lastInsertId());
						
					}
					catch(PDOException $e){
						return $e->getMessage();
					}
			}
		}

		public function fetchPost(DB $db, $pid){
			$st = $db->conn->prepare("SELECT * FROM posts WHERE Id = ?");
			$st->bindValue(1,$pid);
			try {
				$st->execute();
				return $st->fetch();
			}
			catch(PDOException $e){
				$db->logError("PostModel",400,"..");
				return $e->getMessage();
			}
		}

		public function fetchPostsFromUser(DB $db, $uid){
			$st = $db->conn->prepare("SELECT p.*, u.username FROM posts p INNER JOIN users u ON p.IdUser = u.IdUser WHERE p.IdUser = ?");
			$st->bindValue(1,$uid);
			try {
				$st->execute();
				return $st->fetchAll();
			}
			catch(PDOException $e){
				$db->logError("PostModel",400,"..");
				return $e->getMessage();
			}
		}

		public function fetchPosts(DB $db) {
			$st = $db->conn->prepare("SELECT p.*, u.username FROM posts p INNER JOIN users u ON p.IdUser = u.IdUser");
			try {
				$st->execute();
				return $st->fetchAll();
			}
			catch(PDOException $e){
				$db->logError("PostModel",400,"..");
				return $e->getMessage();
			}
		}
	}