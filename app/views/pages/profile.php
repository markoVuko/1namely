<?php
	use App\Models\DB;
	use App\Models\AvatarModel;
	use App\Models\FollowModel;
	require_once "app/config/database.php";
	require_once "app/models/AvatarModel.php";
	require_once "app/models/FollowModel.php";
	$db = new DB(SERVER, DATABASE, USERNAME, PASSWORD);
 ?>

	<div id="profile-page">
		<div id="bio">
			<?php
			
				if($_SESSION["user"]->IdProfile!=null){
					$avatarModel = new AvatarModel();
					$avatarModel->showImg($db, $_SESSION["user"]->IdProfile,"mainProfilePic");
				} else {
					echo "<img src='app/assets/img/profile.png' alt='profile image' id='mainProfilePic'>";
				}
			 	$followModel = new FollowModel();
			 	$num = $followModel->countUserFollowers($db,$_SESSION["user"]->IdUser);
			 	echo "<div id=bio-info>";
				echo "<span id='profile-username'>".$_SESSION["user"]->username."</span><br>";
				echo "<span id='profile-gmail'>".$_SESSION["user"]->gmail."</span><br>";
				echo "<span id='profile-gender'>".$_SESSION["user"]->gender."</span>";
				echo "</div>";
				echo "<span id='profile-followers'>".$num->numFol." followers</span>";
			 ?>
			 <a href="#" id="settingslink">Settings</a>
		</div>
			 
		<div id="modal">
			<form id="settingsForm" enctype="multipart/form-data">
			<h3>User Settings</h3>
			<hr>
			<label id="username_field"><?php echo $_SESSION["user"]->username; ?></label><br>
			<input type="hidden" value='<?php echo $_SESSION["user"]->username ?>' id="setusername" >
			<input type="email" id="setmail"  name="setmail" value="<?php echo $_SESSION["user"]->gmail ?>"><br>
			<input type="password" id="setpw1"  placeholder="New password..."><br>
			<input type="password" id="setpw2"  placeholder="Confirm new password..."><hr>
			<?php
				if($_SESSION["user"]->IdProfile!=null){
					$avatarModel = new AvatarModel();
					$avatarModel->showImg($db, $_SESSION["user"]->IdProfile,"userProfile");
				} else { 
					echo "<img src='app/assets/img/profile.png' alt='profile image' id='userProfile'>";
				}
			 ?>
			<br><input type="file" id="setprofile"  name="setprofile"><br>
			<input type="submit" id="setsub" name="setsub" value="Update settings" >
		</form>
		</div>

		<div id="yourPosts">
			<form id="submitPost" enctype="multipart/form-data">
				<h3>Submit a post</h3>
				<hr>
				<br><input type="hidden" name="puid" id="puid" value='<?php echo $_SESSION["user"]->IdUser ?>'>
				<input type="text" name="title" id="title" placeholder="Title..."><br>
				<textarea id="text" placeholder="Post text..."></textarea>
				<br><input type="file" id="postpic"  name="postpic"><br>
			<input type="submit" id="subpost" name="subpost" value="Submit your post" >
			</form>
			<div id="postlist"></div>
		</div>

	</div>

