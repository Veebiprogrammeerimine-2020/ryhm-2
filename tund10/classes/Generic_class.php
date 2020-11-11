<?php
	class Generic{
		//muutujad, klassis omadused (properties)
		private $mysecret;
		public $yoursecret;
		
		function __construct($secretlimit){
			$this->mysecret = mt_rand(0, $secretlimit);
			$this->yoursecret = mt_rand(0, 100);
			echo "Loositud arvude korrutis on: " .$this->mysecret * $this->yoursecret;
			$this->tellSecret();
		}//construct lõppeb
		
		function __destruct(){
			echo " Ongi selleks korraks kõik!";
		}
		
		//funktsioonid, klassis meetodid (methods)
		private function tellSecret(){
			echo " Näidisklass on mõttetu!";
		}
		
		public function showValue(){
			echo " Väga salajane arv on: " .$this->mysecret;
		}
		
	}//class lõppeb