<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Encapsulates a related pair of values.
	 */
	class KeyValuePair {
	
	
		public $key;
		public $value;
		
		
		public function __construct ($key, $value) {
		
			$this->key=$key;
			$this->value=$value;
		
		}
	
	
	}


?>