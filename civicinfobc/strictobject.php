<?php


	namespace CivicInfoBC;
	
	
	class StrictObject implements \IteratorAggregate {
	
	
		private $arr;
		
		
		public function __construct (array $arr) {
		
			$this->arr=$arr;
		
		}
		
		
		public function getIterator () {
		
			return new \ArrayIterator($this->arr);
		
		}
		
		
		public function ToArray () {
		
			return $this->arr;
		
		}
		
		
		private function retrieve ($key) {
		
			return isset($this->arr[$key]) ? $this->arr[$key] : null;
		
		}
		
		
		public function Get ($key, $default=null) {
		
			$retr=$this->retrieve($key);
			
			if (is_null($retr)) return $default;
			
			return $retr;
		
		}
		
		
		public function __isset ($key) {
		
			return isset($this->arr[$key]);
		
		}
		
		
		public function __unset ($key) {
		
			unset($this->arr[$key]);
		
		}
		
		
		public function __get ($key) {
		
			$retr=$this->retrieve($key);
			
			if (is_null($retr)) throw new \Exception(
				sprintf(
					'Request for unknown configuration "%s"',
					$key
				)
			);
			
			return $retr;
		
		}
		
		
		public function __set ($key, $value) {
		
			if (is_null($value)) unset($this->arr[$key]);
			else $this->arr[$key]=$value;
		
		}
	
	
	}


?>