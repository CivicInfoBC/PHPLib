<?php


	namespace CivicInfoBC;
	
	
	class CrossOriginResourceSharing {
	
	
		private $allowed;
		
		
		public function __construct ($allowed=null) {
		
			$this->allowed=ArrayUtil::Coalesce($allowed);
		
		}
		
		
		public function Send () {
		
			$headers=Request::GetHeaders();
			if (
				isset($headers->origin) &&
				ArrayUtil::In($this->allowed,$headers->origin)
			) header('Access-Control-Allow-Origin: '.$headers->origin);
		
		}
	
	
	};


?>