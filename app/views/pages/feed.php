<?php
	use App\Models\DB;
	use App\Models\AvatarModel;
	use App\Models\UserModel;
	use App\Models\FollowModel;
	require_once "app/models/AvatarModel.php";
	require_once "app/models/FollowModel.php";
	require_once "app/models/UserModel.php";
	require_once "app/config/database.php";
	$db = new DB(SERVER, DATABASE, USERNAME, PASSWORD);
 ?>

<div id="feed-page">
	<div id="feed-sidebar">
			<?php
			
				if($_SESSION["user"]->IdProfile!=null){
					$avatarModel = new AvatarModel();
					$avatarModel->showImg($db, $_SESSION["user"]->IdProfile,"mainProfilePic");
				} else {
					echo "<img src='app/assets/img/profile.png' alt='profile image' id='mainProfilePic'>";
				}
			 	
			 	$followModel = new FollowModel();
			 	$num = $followModel->countUserFollowers($db,$_SESSION["user"]->IdUser);
			 	echo "<div id='sidebar-info'>";
				echo "<span id='profile-username'>".$_SESSION["user"]->username."</span>";
				echo "<span id='profile-followers'>".$num->numFol." followers</span>";
				echo "</div>";
			 ?>
			 
			 <span id="sidebar-links">
			 	<a href="#" id="fl-global">View global feed</a><br>
			 	<a href="#" id="fl-followed">View your follows' feed</a>
			 </span>
	</div>
	<div id="feed-posts">
		
	</div>
	<div id="modal">
		<div id="user-modal">
			<h3>User Profile</h3>
			<hr>
			<img src="" alt="" id="modal-pic">
			 <div id="modal-info">
			 	<span id="modal-username"></span><br>
			 	<span id="modal-gmail"></span><br>
			 	<span id="modal-gender"></span><br>
			 	<a href="#" data-id="" id="follow-link"></a><br>
			 	<span id="modal-followers"></span>
			 </div>
		</div>
	</div>
</div>