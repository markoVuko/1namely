<?php 

	namespace App\Models;

	class AvatarModel {
		private $name;
		private $tmp;
		private $type;
		private $size;

		public function __construct($name=null,$tmp=null,$type=null,$size=null){
			if($name) {
				$this->name = $name;
				$this->tmp = $tmp;
				$this->type = $type;
				$this->size = $size;
			}
		}

		public function uploadImg(DB $db){
			switch($this->type){
					case "image/jpeg": case "image/jpg": 
						$slika = imagecreatefromjpeg($this->tmp);
						break;
					case "image/png": 
						$slika = imagecreatefrompng($this->tmp);
						break;
					case "image/gif": 
						$slika = imagecreatefromgif($this->tmp);
					}
					$dim = 200;
					$old_dims = getimagesize($this->tmp);
					$new_dims = $old_dims;
					if($dim<$old_dims[0]){
						$ratio = $dim/$old_dims[0];
						$new_dims[0] = $dim;
						$new_dims[1] = $old_dims[1]*$ratio;
					}
					if($dim<$old_dims[1]){
						$ratio = $dim/$old_dims[1];
						$new_dims[1] = $dim;
						$new_dims[0] = $old_dims[0]*$ratio;
					}
					$nova_slika = imagecreatetruecolor($new_dims[0], $new_dims[1]);
					imagecopyresampled($nova_slika, $slika, 0, 0, 0, 0, $new_dims[0], $new_dims[1], $old_dims[0], $old_dims[1]);
					$path = "assets/img/".time().$this->name;
					$split = explode(".",$this->name);
					switch($this->type){
					case "image/jpeg": case "image/jpg": 
						imagejpeg($nova_slika,"../".$path);
						break;
					case "image/png": 
						imagepng($nova_slika,"../".$path);
						break;
					case "image/gif": 
						imagegif($nova_slika,"../".$path);
					}
					$st=$db->conn->prepare("INSERT INTO userimages(Path,Alt) VALUES(:p,:a)");
					$st->bindParam(":p",$path);
					$st->bindParam(":a",$split[0]);
					try {
						$st->execute();
						return intval($db->conn->lastInsertId());
						
					}
					catch(PDOException $e){
						$db->logError("AvatarModel",400,"..");
						return $e->getMessage();
					}
		}

		public function showImg(DB $db, $id, $div=null) {
			$st=$db->conn->prepare("SELECT * FROM userimages WHERE Id=:id");
					$st->bindParaM(":id",$id);
					try {
						$st->execute();
						$img = $st->fetch();
						if($div==null){
							return $img;
						} else {
							echo "<img src='app/".$img->Path."' alt='".$img->Alt."' id='".$div."'>";
						}
					}
					catch(PDOEXCEPTION $e){
						echo $e->getMessage();
						$db->logError("AvatarModel",400,"..");
					}
		}
	}