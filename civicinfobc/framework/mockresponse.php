<?php


	namespace CivicInfoBC\Framework;
	

	class MockResponse extends Response {
		
		
		private $status;
		private $written=array();
	
	
		protected function WriteImpl ($str) {	$this->written[]=$str;	}
		protected function RenderImpl (\CivicInfoBC\Renderable $render) {	$this->written[]=$render;	}
	
	
		public function Status ($status) {
			
			$this->status=$status;
			
		}
	
	
		public function Header ($key, $value, $replace=true) {	}
		
		
		public function Cookie ($key, $value, \DateTime $expiry=null, $path=null, $domain=null, $secure=false, $httponly=false) {	}
		
		
		public function Written () {
			
			return $this->written;
			
		}
	
	
	}


?>