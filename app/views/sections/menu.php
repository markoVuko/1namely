<body>
	<div id="menu">
		<header><a href="index.php" id="logo"><h3>namely</h3></a></header>
		<nav>
			<?php
				if(isset($_SESSION["user"])) {
					if($_SESSION["user"]->Role==1){
						echo '<ul>
								<li><a href="index.php">Home</a></li>
								<li><a href="?page=feed">Feed</a></li>
								<li><a href="?page=contact">Contact</a></li>
								<li><a href="?page=admin">Admin</a></li>
								<li><a href="#">Docs</a></li>
								<li><a href="app/models/logout.php">Logout</a></li>
							</ul>';
					} else {
						echo '<ul>
								<li><a href="index.php">Home</a></li>
								<li><a href="?page=feed">Feed</a></li>
								<li><a href="?page=contact">Contact</a></li>
								<li><a href="#">Docs</a></li>
								<li><a href="app/models/logout.php">Logout</a></li>
							</ul>';
					}
				} else {
					echo '<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="?page=contact">Contact</a></li>
				<li><a href="#">Docs</a></li>
			</ul>';
				}
			 ?>
			
		</nav>
	</div>