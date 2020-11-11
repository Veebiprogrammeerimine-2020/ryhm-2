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
	
	function readAllPublicPhotoThumbs($privacy){
		$thumbshtml = "<p>Kahjuks fotosid ei leitud!</p> \n";
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy >= ? AND deleted IS NULL");
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