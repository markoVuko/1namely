<?php

	namespace App\Models;

	class LikeModel {
		public function __construct() {

		}

		public function didILike(db $db, $me, $post) {
			$st = $db->conn->prepare("SELECT * FROM likes WHERE IdPost = ? AND IdUser = ?");
			$st->bindValue(1, $post);
			$st->bindValue(2, $me);
			try {
				$st->execute();
				$row = $st->fetch();
				if($row){
					return true;
				} else {
					return false;
				}
			}
			catch(PDOException $e) {
				echo $e->getMessage();
				$db->logError("LikeModel",400,"..");
			}
		}

		public function countPostLikes(DB $db, $pid) {
			$st = $db->conn->prepare("SELECT COUNT(*) AS numLikes FROM likes WHERE IdPost = ?");
			$st->bindValue(1, $pid);
			try {
				$st->execute();
				return $st->fetch();
			}
			catch(PDOException $e) {
				echo $e->getMessage();
				$db->logError("LikeModel",400,"..");
			}
		}

		public function like(DB $db, $me, $post){
			$st = $db->conn->prepare("INSERT INTO likes(IdPost,IdUser) VALUES(?,?)");
			$st->bindvalue(1,$post);
			$st->bindvalue(2,$me);
			try {
				$st->execute();
			}
			catch(PDOException $e) {
				echo $e->getMessage();
				$db->logError("LikeModel",400,"..");
			}
		}

		public function unlike(DB $db, $me, $post){
			$st = $db->conn->prepare("DELETE FROM likes WHERE IdPost = ? AND IdUser = ?");
			$st->bindvalue(1,$post);
			$st->bindvalue(2,$me);
			try {
				$st->execute();
			}
			catch(PDOException $e) {
				echo $e->getMessage();
				$db->logError("LikeModel",400,"..");
			}
		}
	}