<?php
	use App\Models\DB;
	use App\Models\AvatarModel;
	use App\Models\UserModel;
	use App\Models\ContactModel;
	use App\Models\LogModel;
	use App\Models\FollowModel;
	require_once "app/config/database.php";
	require_once "app/models/AvatarModel.php";
	require_once "app/models/UserModel.php";
	require_once "app/models/ContactModel.php";
	require_once "app/models/LogModel.php";
	require_once "app/models/FollowModel.php";
	$db = new DB(SERVER, DATABASE, USERNAME, PASSWORD);
 ?>

 <div id="admin">
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
		</div>
	
		<div id="admin-panel">
			<div class="admin-ctrl" id="insert-user">
				<form id="insusform">
					<h3>Insert User</h3>
					<input type="text" id="iuname" placeholder="Username..."><br>
					<input type="text" id="iuemail" placeholder="Email..."><br>
					<input type="password" id="iupass" placeholder="Password..."><br>
					<input type="radio" class="iurole" name="role" value="1"> <label class="ulabel">Admin</label>
					<input type="radio" class="iurole" name="role" value="2"> <label class="ulabel">User</label>
					<select id="iugender">
						<option value="1">Male</option>
						<option value="2">Female</option>
						<option value="3">Other</option>
					</select><br>
					<input type="submit" value="Insert" id="iusub">
				</form>
			</div>
			<div class="admin-ctrl" id="edit-users">
				<form id="editusform">
					<h3>Edit User</h3>
					<?php
						$userModel = new UserModel();
						$users = $userModel->fetchUsers($db);
						echo "<select id='euname'><option value='0'>Choose user</option>";
						foreach ($users as $u) {
							echo "<option value='".$u->username."'>".$u->username."</option>";
						}
						echo "</select><br>"
					 ?>
					<input type="text" id="euemail" name="euemail" placeholder="Email..."><br>
					<input type="password" id="eupass" name="eupass" placeholder="Password..."><br>
					<input type="radio" class="eurole" id="eurole1" name="eurole" value="1"> <label class="ulabel">Admin</label>
					<input type="radio" class="eurole" id="eurole2" name="eurole" value="2"> <label class="ulabel">User</label>
					<select id="eugender">
						<option value="1">Male</option>
						<option value="2">Female</option>
						<option value="3">Other</option>
					</select><br>
					<img src="app/assets/img/profile.png" alt="profile picture" id="eupic"><br>
					<input type="file" id="euimg" name="euimg"><br>
					<input type="submit" value="Save" id="saveUser" name="saveUser">
				</form>
			</div>
			</div>
			
			<div class="admin-ctrl" id="contact-feed">
				<?php
					$contactModel = new ContactModel();
					$feed = $contactModel->fetchContact($db);
					foreach ($feed as $f) {
						echo '<div class="feed-block">
							 	<span>Feedback#'.$f->Id.'</span>
							 	<span class="feedName">From: '.$f->Name.' '.$f->Surname.'</span>
							 	<a href="feed-'.$f->Id.'" class="notsel">Open</a>
							 	<div id="feed-'.$f->Id.'" class="feed-content">
							 		<span>Number: '.$f->Num.'</span><br>
							 		<span>Email: '.$f->Email.'</span><br>
							 		<span>'.$f->Gender.'</span><br>
							 		<span class="feedText">'.$f->Text.'</span>
							 	</div>
							 </div>';
							}
					
				 ?>

			</div>
			<div class="admin-ctrl" id="log-stats">
				<table id="log-table">
					<th>Activity</th>
					<th>Time</th>
					<th>Done By</th>
				<?php
					$logModel = new LogModel();
					$logModel->readLogs("app/data/log.txt");
				 ?>
				</table>
			</div>
			<div class="admin-ctrl" id="errors">
				<table id="error-table">
					<th>Page</th>
					<th>Time</th>
					<th>Error Code</th>
				<?php
					$logModel = new LogModel();
					$logModel->readLogs("app/data/dberrors.txt");
				 ?>
				</table>
			</div>
		</div>
	</div>