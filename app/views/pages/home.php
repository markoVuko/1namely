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

			<form id="regForm">
				<input type="text" id="regUser" v-model="regUser" placeholder="username..."><br>
				<input type="email" id="regGmail" v-model="regGmail" placeholder="email..."><br>
				<input type="password" id="regPw1" v-model="regPw1" placeholder="password..."><br>
				<input type="password" id="regPw2" v-model="regPw2" placeholder="confirm password..."><br>
				Gender: 
				<select id="regGender" v-model="regGender">
					<option value="1">Male</option>
					<option value="2">Female</option>
					<option value="3">Other</option>
				</select><br>
				<input type="submit" id="btnReg" value="Register" v-on:click="checkReg">
			</form>
			<form id="logForm">
				<input type="text" id="logUser" v-model="logUser" placeholder="username..."><br>
				<input type="password" id="logPw" v-model="logPw" placeholder="password..."><br>
				<input type="submit" id="btnLog" value="Login" v-on:click="checkLog">
			</form>
		</div>
		<img src="app/assets/img/worldmap.png" id="map">
	</div>