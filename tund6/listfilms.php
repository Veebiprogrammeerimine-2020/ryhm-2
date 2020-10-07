<?php
  require("usesession.php");
  require("../../../../config_vp2020.php");
  //$database = "if20_rinde_2";
  require("fnc_film.php");
  
  //loen andmebaasist filmide info
  //$filmhtml = readfilms();
    
  //$username = "Andrus Rinde";
  require("header.php");
?>
  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse logo">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursuse raames <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <ul>
   <li><a href="home.php">Avalehele</a></li>
   <li><a href="?logout=1">Logi välja</a>!</li>
  </ul>
  <?php //echo $filmhtml;
    echo readfilms(0);
  ?>
</body>
</html>


