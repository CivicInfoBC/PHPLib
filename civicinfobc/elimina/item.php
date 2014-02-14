<?php


	namespace CivicInfoBC\EliMina;
	
	
	class Item {
	
	
		public $name;
		public $weight;
		public $height;
		
		
		public function __construct ($name, \CivicInfoBC\Measure $weight, \CivicInfoBC\Measure $height) {
		
			$this->name=$name;
			$this->weight=$weight;
			$this->height=$height;
		
		}
	
	
	}


?>