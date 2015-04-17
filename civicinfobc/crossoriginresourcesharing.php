<?php


	namespace CivicInfoBC;
	
	
	class CrossOriginResourceSharing {
	
	
		private $allowed;
		
		
		public function __construct ($allowed=null) {
		
			$this->allowed=ArrayUtil::Coalesce($allowed);
		
		}
		
		
		public function Send () {
		
			$headers=Request::GetHeaders();
			if (!isset($headers->origin)) return;
			
			foreach ($this->allowed as $allowed) {
				
				if (
					($allowed===$headers->origin) ||
					(('http://'.$allowed)===$headers->origin) ||
					(('https://'.$allowed)===$headers->origin)
				) header('Access-Control-Allow-Origin: '.$headers->origin);
				
			}
		
		}
	
	
	};


?>