<?php
  //session_start();
  require("classes/SessionManager.class.php");
  //sessioonihaldus
  SessionManager::sessionStart("vp", 0, "/~rinde/", "greeny.cs.tlu.ee");
  
    //logime välja
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: page.php");
	  exit();
  }
  
  //kas on sisseloginud, kui pole, saadame sisselogimise lehele
  if(!isset($_SESSION["userid"])){
	  header("Location: page.php");
	  exit();
  }