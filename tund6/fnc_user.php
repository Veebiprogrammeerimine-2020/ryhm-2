<?php
	$database = "if20_rinde_2";

	function signup($firstname, $lastname, $email, $gender, $birthdate, $password){
		$result = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
		echo $conn->error;
		
		//krüpteerime parooli
		$options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
		$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
		
		$stmt->bind_param("sssiss", $firstname, $lastname, $birthdate, $gender, $email, $pwdhash);
		
		if($stmt->execute()){
			$result = "ok";
		} else {
			$result = $stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $result;
	}//funktsioon signup lõppeb
	
	function signin($email, $password){
		$result = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT password FROM vpusers WHERE email = ?");
		echo $conn->error;
		$stmt -> bind_param("s", $email);
		$stmt -> bind_result($passwordfromdb);
		if($stmt->execute()){
			//kui käsu täitmine õnnestus
			if($stmt->fetch()){
				//kui tuli vaste, kasutaja on olemas
				if(password_verify($password, $passwordfromdb)){
					//parool õige, sisselogimine
					$stmt->close();
					//loen sisseloginud kasutaja nime ja id
					$stmt = $conn->prepare("SELECT vpusers_id, firstname, lastname FROM vpusers WHERE email = ?");
					echo $conn->error;
					$stmt->bind_param("s", $email);
					$stmt->bind_result($idfromdb, $firstnamefromdb, $lastnamefromdb);
					$stmt->execute();
					$stmt->fetch();
					//salvestan saadud info sessioonimuutujatesse
					$_SESSION["userid"] = $idfromdb;
					$_SESSION["userfirstname"] = $firstnamefromdb;
					$_SESSION["userlastname"] = $lastnamefromdb;
					$stmt->close();
					
					//kasutajaprofiil, tausta ja tekstivärv
					//lugeda andmebaasisit kasutajaprofiili, kui saab fetch käsuga värvid, siis need, muidu mus (#000000) ja valge (#FFFFFF)
					$_SESSION["userbgcolor"] = "#CCCCCC";
					$_SESSION["usertxtcolor"] = "#000066";
					
					$conn->close();
					header("Location: home.php");
					exit();
					
				} else {
					$result = "Kahjuks vale parool!";
				}
			} else {
				$result = "Kasutajat (" .$email .") pole olemas!";
			}				
		} else {
			$result = $stmt->error;
		}
		
		$stmt->close();
		$conn->close();
		return $result;
	}
	
	function storeuserprofile($description, $bgcolor, $txtcolor){
	//SQL
	//kontrollime, kas äkki on profiil olemas
	//SELECT vpuserprofiles_id FROM vpuserprofiles WHERE userid = ?
	//küsimärk asendada väärtusega
	//$_SESSION["userid"]
	
	//kui profiil on olemas, siis uuendame
	//UPDATE vpuserprofiles SET description = ?, bgcolor = ?, txtcolor = ? WHERE userid = ?
	
	//Kui profiili pole olemas, siis loome
	//INSERT INTO vpuserprofiles (userid, description, bgcolor, txtcolor) VALUES(?,?,?,?)
	
	//execute jms võib loomisel/uuendamisel ühine olla
	
	
	}
	
	function readuserdescription(){
		
	}
	