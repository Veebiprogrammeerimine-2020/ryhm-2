<?php
  require("usesession.php");
  require("../../../../config_vp2020.php");
  require("fnc_photo.php");
  require("fnc_common.php");
    
  $inputerror = "";
  $notice = "";
  $fileuploadsizelimit = 2097152;//1048576;
  $fileuploaddir_orig = "../photoupload_orig/";
  $fileuploaddir_normal = "../photoupload_normal/";
  $fileuploaddir_thumb = "../photoupload_thumb/";
  $filename = "";
  $filenameprefix = "vp_";
  $photomaxw = 600;
  $photomaxh = 400;
  $thumbsize = 100;
  $privacy = 1;
  $alttext = null;
  
  //kas vajutati salvestusnuppu
  if(isset($_POST["photosubmit"])){
	//var_dump($_POST);
	//var_dump($_FILES);
	$privacy = intval($_POST["privinput"]);
	$alttext = test_input($_POST["altinput"]);
	
	//kas on üldse pilt
	$check = getimagesize($_FILES["photoinput"]["tmp_name"]);
	if($check !== false){
		//var_dump($check);
		if($check["mime"] == "image/jpeg"){
			$filetype = "jpg";
		}
		if($check["mime"] == "image/png"){
			$filetype = "png";
		}
		if($check["mime"] == "image/gif"){
			$filetype = "gif";
		}
	} else {
		$inputerror = "Valitud fail ei ole pilt!";
	}
	
	//ega pole liiga suur fail
	if($_FILES["photoinput"]["size"] > $fileuploadsizelimit){
		$inputerror .= " Valitud fail on liiga suur!";
	}
	
	//genereerime failinime
	$timestamp = microtime(1) * 10000;
	$filename = $filenameprefix .$timestamp ."." .$filetype;
	
	//kas fail on olemas
	if(file_exists($fileuploaddir_orig .$filename)){
		$inputerror .= " Sellise nimega fail on juba olemas!";
	}
	
	if(empty($inputerror)){
		//teen väiksemaks
		//loome image objekti ehk pikslikogumi
		if($filetype == "jpg"){
			$mytempimage = imagecreatefromjpeg($_FILES["photoinput"]["tmp_name"]);
		}
		if($filetype == "png"){
			$mytempimage = imagecreatefrompng($_FILES["photoinput"]["tmp_name"]);
		}
		if($filetype == "gif"){
			$mytempimage = imagecreatefromgif($_FILES["photoinput"]["tmp_name"]);
		}
		//muudame suurust
		$mynewimage = resizePhoto($mytempimage, $photomaxw, $photomaxh, true);
		//salvestame vähendatud pildi faili
		$result = savePhotoFile($mynewimage, $filetype, $fileuploaddir_normal .$filename);
		if($result == 1){
			$notice .= "Vähendatud pildi salvestamine õnnestus!";
		} else {
			$inputerror .= "Vähendatud pildi salvestamisel tekkis tõrge!";
		}
		imagedestroy($mynewimage);
		
		//pisipilt
		$mynewimage = resizePhoto($mytempimage, $thumbsize, $thumbsize);
		$result = savePhotoFile($mynewimage, $filetype, $fileuploaddir_thumb .$filename);
		if($result == 1){
			$notice .= "Pisipildi salvestamine õnnestus!";
		} else {
			$inputerror .= "Pisipildi salvestamisel tekkis tõrge!";
		}
		imagedestroy($mynewimage);
		
		imagedestroy($mytempimage);
		
		//kui vigu pole, salvestame originaalpildi
		if(empty($inputerror)){
			if(move_uploaded_file($_FILES["photoinput"]["tmp_name"], $fileuploaddir_orig .$filename)){
				$notice .= " Originaalpildi salvestamine õnnestus!";
			} else {
				$inputerror .= " Originaalpildi salvestamisel tekkis viga!";
			}
		}
		
		//kui vigu pole, salvestame info andmebaasi
		if(empty($inputerror)){
			$result = storePhotoData($filename, $alttext, $privacy);
			if($result == 1){
				$notice .= " Pildi info lisati andmebaasi!";
				$privacy = 1;
				$alttext = null;
			} else {
				$inputerror .= " Pildi info andmebaasi salvestamisel tekkis tõrge!";
			}
		} else {
			$inputerror .= " Tekkinud vigade tõttu pildi andmeid ei salvestatud!";
		}
	}
  }
  
  require("header.php");
?>
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursuse raames <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <ul>
   <li><a href="home.php">Avalehele</a></li>
   <li><a href="?logout=1">Logi välja</a>!</li>
  </ul>
  <hr>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
    <label for="photoinput">Vali pildifail!</label>
	<input id="photoinput" name="photoinput" type="file" required>
	<br>
	<label for="altinput">Lisa pildi lühikirjeldus (alternatiivtekst)</label>
	<input id="altinput" name="altinput" type="text" placeholder="Pildi lühikirjeldus ..." value="<?php echo $alttext; ?>">
	<br>
	<label>Määra privaatsustase</label>
	<br>
	<input id="privinput1" name="privinput" type="radio" value="1" <?php if($privacy == 1){echo " checked";} ?>>
	<label for="privinput1">Privaatne (ise näed)</label>
	<input id="privinput2" name="privinput" type="radio" value="2" <?php if($privacy == 2){echo " checked";} ?>>
	<label for="privinput2">Sisseloginud kasutajatele</label>
	<input id="privinput3" name="privinput" type="radio" value="3" <?php if($privacy == 3){echo " checked";} ?>>
	<label for="privinput3">Avalik</label>
	
	<br>
	<input type="submit" name="photosubmit" value="Lae pilt üles">
  </form>
  <p>
  <?php
	echo $inputerror;
	echo $notice;
  ?>
	</p>
  
  <hr>  
</body>
</html>


