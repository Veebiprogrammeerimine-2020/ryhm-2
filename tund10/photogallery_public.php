<?php
  require("usesession.php");
  require("../../../../config_vp2020.php");
  require("fnc_photo.php");
  
  $notice = "";
  $fileuploaddir_orig = "../photoupload_orig/";
  $fileuploaddir_normal = "../photoupload_normal/";
  $fileuploaddir_thumb = "../photoupload_thumb/";
  
  $gallerypagelimit = 3;
  $page = 1;
  $photocount = countPublicPhotos(2);
  
  if(!isset($_GET["page"]) or $_GET["page"] < 1){
	  $page = 1;
  } elseif((intval($_GET["page"]) - 1) * $gallerypagelimit >= $photocount){
	  $page = ceil($photocount/$gallerypagelimit);
  } else {	  
	  $page = intval($_GET["page"]);
  }
  
  //$publicphotothumbshtml = readAllPublicPhotoThumbs(2);
  $publicphotothumbshtml = readAllPublicPhotoThumbsPage(2, $gallerypagelimit, $page);
    
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
  <h2>Fotogalerii</h2>
  <p>
	<?php
		if($page > 1){
			echo '<span><a href="?page=' .($page - 1) .'">Eelmine leht</a></span> | ' ."\n";
		} else {
			echo '<span>Eelmine leht</span> | ' ."\n";
		}
		if($page * $gallerypagelimit < $photocount){
			echo '<span><a href="?page=' .($page + 1) .'">Järgmine leht</a></span>' ."\n";
		} else {
			echo '<span>Järgmine leht</span>' ."\n";
		}
	?>
  </p>
  <?php
	echo $publicphotothumbshtml;
  ?>
  
  <hr>  
</body>
</html>


