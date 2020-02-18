<?php
	
	namespace App\Models;

	class FollowModel {

		public function __construct() {

		}

		public function doIFollow(DB $db, $me, $them) {
			$st = $db->conn->prepare("SELECT * FROM follows WHERE Followed = ? AND Follows = ?");
			$st->bindValue(1, $them);
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
				$db->logError("FollowModel",400,"..");
			}
		}

		public function doTheyFollow(DB $db, $me, $them) {
			$st = $db->conn->prepare("SELECT * FROM follows WHERE Followed = ? AND Follows = ?");
			$st->bindValue(1, $me);
			$st->bindValue(2, $them);
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
				$db->logError("FollowModel",400,"..");
			}
		}

		public function countUserFollowers(DB $db, $uid) {
			$st = $db->conn->prepare("SELECT COUNT(*) AS numFol FROM follows WHERE Followed = ?");
			$st->bindValue(1, $uid);
			try {
				$st->execute();
				return $st->fetch();
			}
			catch(PDOException $e) {
				echo $e->getMessage();
				$db->logError("FollowModel",400,"..");
			}
		}

		public function follow(DB $db, $follower, $followed){
			$st = $db->conn->prepare("INSERT INTO follows(Followed,Follows) VALUES(?,?)");
			$st->bindvalue(1,$followed);
			$st->bindvalue(2,$follower);
			try {
				$st->execute();
				echo json_encode("Followed");
				http_response_code(200);
			}
			catch(PDOException $e) {
				echo $e->getMessage();
				$db->logError("FollowModel",400,"..");
			}
		}

		public function unfollow(DB $db, $follower, $followed){
			$st = $db->conn->prepare("DELETE FROM follows WHERE Followed = ? AND Follows = ?");
			$st->bindvalue(1,$followed);
			$st->bindvalue(2,$follower);
			try {
				$st->execute();
				echo json_encode("Unfollowed");
				http_response_code(200);
			}
			catch(PDOException $e) {
				echo $e->getMessage();
				$db->logError("FollowModel",400,"..");
			}
		}
	}