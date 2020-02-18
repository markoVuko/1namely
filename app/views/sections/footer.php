	<footer>
		<span id="copyright">&copy; Copyright Marko Vukojević 204/17, 2020</span>
		<div class="footer-block">
			
			<h4>Pages</h4>
			<hr>
			<?php
				if(isset($_SESSION["user"])) {
					if($_SESSION["user"]->Role==1){
						echo '<ul>
								<li><a href="index.php">Home</a></li>
								<li><a href="?page=feed">Feed</a></li>
								<li><a href="?page=contact">Contact</a></li>
								<li><a href="?page=admin">Admin</a></li>
							</ul>';
					} else {
						echo '<ul>
								<li><a href="index.php">Home</a></li>
								<li><a href="?page=feed">Feed</a></li>
								<li><a href="?page=contact">Contact</a></li>
							</ul>';
					}
				} else {
					echo '<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="?page=contact">Contact</a></li>
			</ul>';
				}
			 ?>
		</div>
		<div class="footer-block">
			<h4>Utilities</h4>
			<hr>
			<ul>
				<li><a href="documentation.pdf">Documentation</a></li>
				<li><a href="">Linkedin</a></li>
				<li><a href="">Github</a></li>
				<li><a href="sitemap.xml">Sitemap</a></li>
			</ul>
		</div>
	</footer>
</body>
</html>