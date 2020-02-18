<?php 
namespace App\Controllers;
use App\Models\UserModel;
use App\Models\AvatarModel;
use App\Models\PostModel;
use App\Models\FollowModel;
use App\Models\LikeModel;
include "../models/UserModel.php";
include "../models/AvatarModel.php";
include "../models/PostModel.php";
include "../models/FollowModel.php";
include "../models/LikeModel.php";

	class UserController {
		private $db;
		public function __construct($db) {
			$this->db = $db;
		}

		public function register($username, $pw1, $pw2, $email, $gender){
			if(!isset($username)||!isset($pw1)||!isset($pw2)||!isset($email)||!isset($gender)||$pw1!=$pw2) {
				echo json_encode("Popunite sve podatke!");
				$this->db->logError("UserController",412,"..");
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

		public function insert($username, $pw, $email, $gender, $role){
			if(!isset($username)||!isset($pw)||!isset($email)||!isset($gender)||!isset($role)) {
				echo json_encode("Popunite sve podatke!");
				$this->db->logError("UserController",412,"..");
			} else {
				$userModel = new UserModel($username);
				$genderText = "";
				switch ($gender) {
					case 1:
						$genderText = "male";
						break;

					case 2:
						$genderText = "female";
						break;

					case 3:
						$genderText = "other";
						break;
					
					default:
						$genderText = "other";
						break;
				}
				$userModel->insertUser($this->db,$pw,$email,$genderText,$role);
			}

		}

		public function login($username, $password) {
			if($this->authenticate($username,$password)) {

				session_start();
				$userModel = new UserModel($username);
				$user = $userModel->fetchUser($this->db);
				$_SESSION['user'] = $user;
				$this->db->logAction("logged in",$username,"..");
				echo json_encode("Uspesno ste ulogovani, ".$user->username."!");
				http_response_code(200);
			} 
			else {
				return false;
			}
		}

		 function authenticate($username, $password) {
			$a = false;
			$userModel = new UserModel($username);
			$user = $userModel->fetchUser($this->db);
			if($user!=null||$user->password==md5($password)){
				$a = true;
			}
			return $a;
		}

		public function editUser($username, $pw1, $pw2, $gmail, $name, $tmp, $type, $size, $role=null, $gender=null, $pw=null){
			if(isset($pw1)&&isset($pw2)||isset($gmail)||isset($name)) { 
				$userModel = new UserModel($username);
				$user = $userModel->fetchUser($this->db);
				$suc = null;
				if(isset($gmail)&&$gmail!=$user->gmail){
					$suc .= $userModel->updateGmail($this->db,$gmail);
				}
				if(isset($pw1)&&isset($pw2)&&$pw1==$pw2) {
					$suc .= $userModel->updatePw($this->db, $pw1);
				}
				if($pw){
					$suc .= $userModel->updatePw($this->db, $pw);
				}
				if(isset($name)){
					if($size<=5*1024*1024){
						$avModel = new AvatarModel($name,$tmp,$type,$size);
						$imgid = $avModel->uploadImg($this->db);
						if(is_int($imgid)) {
							$suc .= $userModel->updatePic($this->db, $imgid);
						} else { $suc .= "Image upload failed.";}
					} 
					else {
						$suc .= "Image cannot exceed 5MB.";
					}
				}
				if(isset($role)){
					$suc .= $userModel->updateRole($this->db,$role);
				}
				if($gender){
					$gen = null;
					switch ($gender) {
						case 1: $gen="male"; break;
						case 2: $gen="female"; break;
						case 3: $gen="other"; break;
					}
					$suc .= $userModel->updateGender($this->db,$gen);
				}
				if($suc==null) {
					$user = $userModel->fetchUser($this->db);
					if($role==null){
						session_start();
						$_SESSION["user"]=$user;
						$this->db->logAction("edited profile",$user->username,"..");
					}
					echo json_encode($user);
					http_response_code(200);
				} else {
					echo json_encode($suc);
					$this->db->logError("UserController",400,"..");
				}
			}
			else {
				echo json_encode("Popunite sve podatke!");
				$this->db->logError("UserController",412,"..");
			}
		}

		public function submitPost($puid, $ptitle, $ptext, $name, $tmp, $type, $size){
			if(isset($puid)&&isset($ptitle)&&isset($ptext)){
				$postModel = new PostModel($ptitle, $ptext, $puid);
				$postId = $postModel->subpost($this->db, $name, $tmp, $type, $size);
				if(is_int($postId)) {
					$post = $postModel->fetchPost($this->db, $postId);
					echo json_encode($post);
					http_response_code(200);
				} else {
					echo json_encode("Neuspesno postavljanje.");
				$this->db->logError("UserController",400,"..");
				}
			} 
			else {
				echo json_encode("Popunite sve podatke!");
				$this->db->logError("UserController",412,"..");
			}
		}

		public function showUserPosts($puid,$username) {
			$postModel = new PostModel();
			$posts = $postModel->fetchPostsFromUser($this->db, $puid);
			$likeModel = new LikeModel();
			$userModel = new UserModel($username);
			$user = $userModel->fetchUser($this->db);
			$likes = [];
			$likeNums = [];
			foreach ($posts as $p) {
				if($likeModel->didILike($this->db,$user->IdUser,$p->Id)) {
						array_push($likes, true);
				} else {array_push($likes, false);}
				array_push($likeNums, $likeModel->countPostLikes($this->db,$p->Id));

			}
			$res = [];
			array_push($res, $posts);
			array_push($res, $likes);
			array_push($res, $likeNums);
			echo json_encode($res);
		}

		public function showGlobalPosts($username) {
			$postModel = new PostModel();
			$posts = $postModel->fetchPosts($this->db);
			$likeModel = new LikeModel();
			$userModel = new UserModel($username);
			$user = $userModel->fetchUser($this->db);
			$likes = [];
			$likeNums = [];
			foreach ($posts as $p) {
				if($likeModel->didILike($this->db,$user->IdUser,$p->Id)) {
						array_push($likes, true);
				} else {array_push($likes, false);}
				array_push($likeNums, $likeModel->countPostLikes($this->db,$p->Id));

			}
			$res = [];
			array_push($res, $posts);
			array_push($res, $likes);
			array_push($res, $likeNums);
			echo json_encode($res);
		}

		public function userStats($their, $mine) {
			$theirModel = new UserModel($their);
			$myModel = new UserModel($mine);
			$them = $theirModel->fetchUser($this->db);
			$me = $myModel->fetchUser($this->db);
			$res["them"] = $them;
			$followModel = new FollowModel();
			$res["doIFollow"] = $followModel->doIFollow($this->db,$me->IdUser, $them->IdUser);
			$res["followCount"] = $followModel->countUserFollowers($this->db, $them->IdUser);
			$avatarModel = new AvatarModel();
			$res["img"] = $avatarModel->showImg($this->db,$them->IdProfile);
			echo json_encode($res);
		}

		public function followUser($mine, $their) {
			$theirModel = new UserModel($their);
			$myModel = new UserModel($mine);
			$them = $theirModel->fetchUser($this->db);
			$me = $myModel->fetchUser($this->db);
			$followModel = new FollowModel();
			$followModel->follow($this->db, $me->IdUser, $them->IdUser);
		}

		public function unfollowUser($mine, $their) {
			$theirModel = new UserModel($their);
			$myModel = new UserModel($mine);
			$them = $theirModel->fetchUser($this->db);
			$me = $myModel->fetchUser($this->db);
			$followModel = new FollowModel();
			$followModel->unfollow($this->db, $me->IdUser, $them->IdUser);
		}

		public function showFollowedPosts($username){
			$userModel = new UserModel($username);
			$user = $userModel->fetchUser($this->db);
			$postModel = new PostModel();
			$posts = $postModel->fetchPosts($this->db);
			$followModel = new FollowModel();
			$likeModel = new LikeModel();
			$fp = [];
			$likes = [];
			$likeNums = [];
			foreach ($posts as $p) {
				if($followModel->doIFollow($this->db,$user->IdUser, $p->IdUser)){
					array_push($fp, $p);
					if($likeModel->didILike($this->db,$user->IdUser,$p->Id)) {
						array_push($likes, true);
					} else {array_push($likes, false);}
					array_push($likeNums, $likeModel->countPostLikes($this->db,$p->Id));
				}
			}
			$res = [];
			array_push($res, $fp);
			array_push($res, $likes);
			array_push($res, $likeNums);
			echo json_encode($res);
		}

		public function returnUser($username){
			$userModel = new UserModel($username);
			try {
				$user = $userModel->fetchUser($this->db);
				echo json_encode($user);
				http_response_code(200);
			}
			catch(PDOException $e){
				echo json_encode($e->getMessage());
				$this->db->logError("UserController",400,"..");
			}
		}

		public function likePost($post,$username){
			$userModel = new UserModel($username);
			$user = $userModel->fetchUser($this->db);
			$likeModel = new LikeModel();
			$likeModel->like($this->db,$user->IdUser,$post);
			$num = $likeModel->countPostLikes($this->db,$post);
			echo json_encode($num);
			http_response_code(200);
		}

		public function unlikePost($post,$username){
			$userModel = new UserModel($username);
			$user = $userModel->fetchUser($this->db);
			$likeModel = new LikeModel();
			$likeModel->unlike($this->db,$user->IdUser,$post);
			$num = $likeModel->countPostLikes($this->db,$post);
			echo json_encode($num);
			http_response_code(200);
		}

		function logout() {
			session_start();
			unset($_SESSION["user"]);
		}
	}