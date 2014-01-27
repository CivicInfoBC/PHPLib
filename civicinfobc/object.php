<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Provides functionality identical to that
	 *	of the built-in class stdClass, except
	 *	attempting to fetch a non-existent property
	 *	will return \em null rather than causing a
	 *	PHP warning.
	 */
	class Object implements \IteratorAggregate {
	
	
		private $values=array();
		
		
		public function getIterator () {
		
			return new \ArrayIterator($this->values);
		
		}
		
		
		public function __isset ($key) {
		
			return isset($this->values[$key]);
		
		}
		
		
		public function __unset ($key) {
		
			unset($this->values[$key]);
		
		}
		
		
		public function __set ($key, $value) {
		
			if (is_null($value)) unset($this->values[$key]);
			else $this->values[$key]=$value;
		
		}
		
		
		public function __get ($key) {
		
			return isset($this->values[$key]) ? $this->values[$key] : null;
		
		}
	
	
	}


?>