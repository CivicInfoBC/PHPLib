<?php


	namespace CivicInfoBC\EliMina;
	
	
	class Item {
	
	
		public $name;
		public $height;
		public $weight;
		
		
		public function __construct ($name, $height, $weight) {
		
			$this->name=$name;
			$this->height=$height;
			$this->weight=$weight;
		
		}
	
	
	}


?>