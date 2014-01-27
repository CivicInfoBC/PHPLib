<?php


	namespace CivicInfoBC;
	

	class ObjectAggregator {
	
	
		private $arr;
		
		
		public function __construct () {
		
			$this->arr=func_get_args();
		
		}
		
		
		private function retrieve ($key) {
		
			foreach ($this->arr as $x) if (isset($x->$key)) return $x->$key;
			
			return null;
		
		}
		
		
		public function Get ($key, $default=null) {
		
			$retr=$this->retrieve($key);
			
			if (is_null($retr)) return $default;
			
			return $retr;
		
		}
		
		
		public function __isset ($key) {
		
			foreach ($this->arr as $x) if (isset($x->$key)) return true;
			
			return false;
		
		}
		
		
		private function unset_impl ($key) {
		
			foreach ($this->arr as $x) if (isset($x->$key)) unset($x->$key);
		
		}
		
		
		public function __unset ($key) {
		
			unset_impl($key);
		
		}
		
		
		public function __get ($key) {
		
			$retr=$this->retrieve($key);
			
			if (is_null($retr)) throw new \Exception(
				sprintf(
					'Request for unknown setting "%s"',
					$key
				)
			);
			
			return $retr;
		
		}
		
		
		public function __set ($key, $value) {
		
			if (is_null($value)) {
			
				unset_impl($key);
				
				return;
			
			}
		
			if (count($this->arr)===0) return;
			
			$this->arr[0]->$key=$value;
		
		}
	
	
	}


?>