<?php
	$database = "if20_rinde_2";

	function storePhotoData($filename, $alttext, $privacy){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO vpphotos (userid, filename, alttext, privacy) VALUES (?, ?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("issi", $_SESSION["userid"], $filename, $alttext, $privacy);
		if($stmt->execute()){
			$notice = 1;
		} else {
			//echo $stmt->error;
			$notice = 0;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function countPublicPhotos($privacy){
		$photocount = 0;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT COUNT(vpphotos_id) FROM vpphotos WHERE privacy >= ? AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($photocountfromdb);
		$stmt->execute();
		if($stmt->fetch()){
			$photocount = $photocountfromdb;
		}
		$stmt->close();
		$conn->close();
		return $photocount;
	}
	
	function readAllPublicPhotoThumbs($privacy){
		$thumbshtml = "<p>Kahjuks fotosid ei leitud!</p> \n";
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy >= ? AND deleted IS NULL ORDER BY vpphotos_id DESC");
		echo $conn->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($filenamefromdb, $alttextfromdb);
		$stmt->execute();
		$temphtml = null;
		//<img src="failinimi.laiend" alt="tekst">
		while($stmt->fetch()){
			$temphtml .= '<img src="' .$GLOBALS["fileuploaddir_thumb"] .$filenamefromdb .'" alt="' .$alttextfromdb .'">' ."\n";
		}
		if(!empty($temphtml)){
			$thumbshtml = "<div> \n" .$temphtml ."</div> \n";
		}
		$stmt->close();
		$conn->close();
		return $thumbshtml;
	}
	
	function readAllPublicPhotoThumbsPage($privacy, $limit, $page){
		$skip = ($page - 1) * $limit;
		$thumbshtml = "<p>Kahjuks fotosid ei leitud!</p> \n";
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		//LIMIT x -> tagastab x kirjet.   LIMIT y, x  -> Jäetakse vahele y ja tagastatakse x kirjet
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy >= ? AND deleted IS NULL ORDER BY vpphotos_id DESC LIMIT ?, ?");
		echo $conn->error;
		$stmt->bind_param("iii", $privacy, $skip, $limit);
		$stmt->bind_result($filenamefromdb, $alttextfromdb);
		$stmt->execute();
		$temphtml = null;
		//<div class="thumbgallery">
		//<img src="failinimi.laiend" alt="tekst">
		//</div>
		while($stmt->fetch()){
			$temphtml .= '<div class="thumbgallery">' ."\n";
			$temphtml .= '<img src="' .$GLOBALS["fileuploaddir_thumb"] .$filenamefromdb .'" alt="' .$alttextfromdb .'" class="thumbs">' ."\n";
			$temphtml .= "</div> \n"; 
		}
		if(!empty($temphtml)){
			$thumbshtml = '<div class="galleryarea">' ."\n" .$temphtml ."</div> \n";
		}
		$stmt->close();
		$conn->close();
		return $thumbshtml;
	}