<div id="home-content">
		<div id="welcome">
			<h2>Share your life!</h2>
			<span>Sign up on namely and share your pictures and stories with your friends and family, or meet new people and gain new experiences.</span>
		</div>
		<div id="user-forms">
			<span id="form-links">
				<a href="logForm" id="logAF" class="notsel">Login</a>
				<a href="regForm" id="regAF">Register</a>
				<hr>
			</span>

			<form id="regForm" method="POST" action="app/Controllers/AJAXController.php" onsubmit="return validateReg()">
				<input type="hidden" name="action" value="register">
				<input type="text" id="regUser" name="regUser" placeholder="username..."><br>
				<input type="text" id="regGmail" name="regGmail" placeholder="email..."><br>
				<input type="password" id="regPw1" name="regPw1" placeholder="password..."><br>
				<input type="password" id="regPw2" name="regPw2" placeholder="confirm password..."><br>
				Gender: 
				<select id="regGender" name="regGender">
					<option value="1">Male</option>
					<option value="2">Female</option>
					<option value="3">Other</option>
				</select><br>
				<input type="submit" id="btnReg" value="Register" >
			</form>
			<form id="logForm" method="POST" action="app/Controllers/AJAXController.php" onsubmit="return validateLog();">
				<input type="hidden" name="action" value="login">
				<input type="text" id="logUser" name="logUser" placeholder="username..."><br>
				<input type="password" id="logPw" name="logPw" placeholder="password..."><br>
				<input type="submit" id="btnLog" value="Login" >
			</form>
		</div>
		<img src="app/assets/img/worldmap.png" id="map">
	</div>