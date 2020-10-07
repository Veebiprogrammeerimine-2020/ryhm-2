<?php
  //var_dump($_POST);
  require("usesession.php");

  
  //$username = "Andrus Rinde";
  
  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse logo">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursuse raames <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p><a href="?logout=1">Logi välja</a>!</p>
  <ul>
    <li><a href="addideas.php">Oma mõtete salvestamine</a></li>
	<li><a href="listideas.php">Mõtete vaatamine</a></li>
	<li><a href="listfilms.php">Filmide nimekirja vaatamine</a></li>
	<li><a href="addfilms.php">Filmiinfo lisamine</a></li>
  </ul>
  
  <hr>

</body>
</html>


