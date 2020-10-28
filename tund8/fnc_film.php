<?php
  $database = "if20_Karl_reim_1";
  
  //andmebaasisit filmide lugemise funktsioon
  function readfilms($choice) {
	  $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	  //$stmt = $conn->prepare("SELECT pealkiri, aasta, kestus, zanr, tootja, lavastaja FROM film");
	  if($choice == 0){
	    $stmt = $conn->prepare("SELECT * FROM film");
	  } else {
        $stmt = $conn->prepare("SELECT * FROM film");
	  }		  
	  //seon tulemuse muutujaga
	  $stmt->bind_result($titlefromdb, $yearfromdb, $durationfromdb, $genrefromdb, $studiofromdb, $directorfromdb);
	  $stmt->execute();
	  $filmhtml = "\t <ol> \n";
	  while($stmt->fetch()){
		  $filmhtml .= "\t \t <li>" .$titlefromdb ."\n";
		  $filmhtml .= "\t \t \t  <ul> \n";
		  $filmhtml .= "\t \t \t \t <li>Aasta: " .$yearfromdb ."</li> \n";
		  $filmhtml .= "\t \t \t \t <li>Kestus: " .$durationfromdb ." minutit</li> \n";
		  $filmhtml .= "\t \t \t \t <li>Žanr: " .$genrefromdb ."</li> \n";
		  $filmhtml .= "\t \t \t \t <li>Tootja: " .$studiofromdb ."</li> \n";
		  $filmhtml .= "\t \t \t \t <li>Lavastaja: " .$directorfromdb ."</li> \n";
		  $filmhtml .= "\t \t \t  </ul> \n";
		  $filmhtml .= "\t \t</li> \n";
	  }
	  $filmhtml .= "\t </ol> \n";
	  $stmt->close();
	  $conn->close();
	  return $filmhtml;
  }//readfilms lõppeb
  
  //Salvestan sisestatud filimiinfo andmebaasisit
  function storefilminfo($title, $year, $duration, $genre, $studio, $director){
	  $success = 0;
	  $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	  $stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES(?,?,?,?,?,?)");
	  echo $conn->error;
	  $stmt->bind_param("siisss", $title, $year, $duration, $genre, $studio, $director);
	  if($stmt->execute()){
		  $success = 1;
	  }
	  
	  $stmt->close();
	  $conn->close();
	  return $success;
  } //storefilminfo lõppeb
  
  
  
  