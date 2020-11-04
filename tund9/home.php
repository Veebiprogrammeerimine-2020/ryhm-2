<?php
  //var_dump($_POST);
  require("usesession.php");
  require("classes/Generic_class.php");

  //testime klassi kasutamiset
  //$myfirstclass = new Generic(8);
  //echo " Saladus on: " .$myfirstclass->mysecret;
  //echo " Oluliselt avalikum saladus on: " .$myfirstclass->yoursecret;
  //$myfirstclass->showValue();
  //unset($myfirstclass);
  //echo " Oluliselt avalikum saladus on: " .$myfirstclass->yoursecret;
  
  require("header.php");
?>

  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursuse raames <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p><a href="?logout=1">Logi välja</a>!</p>
  <ul>
    <li><a href="addideas.php">Oma mõtete salvestamine</a></li>
	<li><a href="listideas.php">Mõtete vaatamine</a></li>
	<li><a href="listfilms.php">Filmide nimekirja vaatamine</a></li>
	<li><a href="addfilms.php">Filmiinfo lisamine</a></li>
	<li><a href="addfilmrelations.php">Filmiinfo seoste lisamine</a></li>
	<li><a href="listfilmpersons.php">Filmitegelaste loend</a></li>
	<li><a href="userprofile.php">Minu kasutajaprofiil</a></li>
	<li><a href="photoupload.php">Galeriipiltide üleslaadimine</a></li>
  </ul>
  
  <hr>

</body>
</html>


