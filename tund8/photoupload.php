<?php
  require("usesession.php");
  require("../../../../config_vp2020.php");
    
  $inputerror = "";
  $notice = "";
  $fileuploadsizelimit = 1048576;
  $fileuploaddir_orig = "../photoupload_orig/";
  //kas vajutati salvestusnuppu
  if(isset($_POST["photosubmit"])){
	//var_dump($_POST);
	//var_dump($_FILES);
	
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
	
	//kas fail on olemas
	if(file_exists($fileuploaddir_orig .$_FILES["photoinput"]["name"])){
		$inputerror .= " Sellise nimega fail on juba olemas!";
	}
	
	if(empty($inputerror)){
		if(move_uploaded_file($_FILES["photoinput"]["tmp_name"], $fileuploaddir_orig .$_FILES["photoinput"]["name"])){
			$notice .= " Originaalpildi üleslaadimine õnnestus!";
		} else {
			$notice .= "Originaalpildi üleslaadimisel tekkis viga!";
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
	<input id="altinput" name="altinput" type="text" placeholder="Pildi lühikirjeldus ...">
	<br>
	<label>Määra privaatsustase</label>
	<br>
	<input id="privinput1" name="privinput" type="radio" value="1">
	<label for="privinput1">Privaatne (ise näed)</label>
	<input id="privinput2" name="privinput" type="radio" value="2">
	<label for="privinput2">Sisseloginud kasutajatele</label>
	<input id="privinput3" name="privinput" type="radio" value="3">
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


