<?php


	namespace CivicInfoBC;
	
	
	class InputObject implements \IteratorAggregate {
	
	
		private $kv;
		
		
		public function __construct ($obj) {
		
			$this->kv=new KeyValueWrapper($obj);
		
		}
		
		
		private function get_impl ($key) {
		
			if (!isset($this->kv->$key)) return null;
			
			$retr=StringUtil::Trim($this->kv->$key);
			
			return ($retr==='') ? null : $retr;
		
		}
		
		
		public function Get ($key, $default=null) {
		
			return is_null($retr=$this->get_impl($key)) ? $default : $retr;
		
		}
		
		
		public function __isset ($key) {
		
			return !is_null($this->get_impl($key));
		
		}
		
		
		public function __get ($key) {
		
			$retr=$this->get_impl($key);
			
			if (is_null($retr)) throw new \Exception(
				sprintf(
					'"%s" does not exist',
					$key
				)
			);
			
			return $retr;
		
		}
		
		
		public function getIterator () {
		
			return $this->kv->getIterator();
		
		}
	
	
	}


?>