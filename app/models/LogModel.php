<?php 

	namespace App\Models;

	class LogModel {
		public function __construct() {

		}

		public function readLogs($p) {
			$log = file($p);
					foreach($log as $l){
						$red = explode("\t", $l);
						echo "<tr>";
						foreach($red as $r){
							echo "<td>".$r."</td>";
						}
						echo "</tr>";
					}
		}
	}