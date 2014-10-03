<?php


	namespace CivicInfoBC\Framework;
	
	
	class HTTPResponse extends Response {
	
	
		private $headers;
		
		
		public function __construct () {
		
			$this->headers=new \CivicInfoBC\HTTP\Headers();
		
		}
		
		
		protected function WriteImpl ($str) {
		
			echo($str);
		
		}
		
		
		protected function RenderImpl (\CivicInfoBC\Renderable $render) {
		
			$render->Render();
		
		}
		
		
		public function Status ($status) {
		
			$s=new \CivicInfoBC\HTTP\Status($status);
			$s->Send();
		
		}
		
		
		public function Header ($key, $value, $replace=true) {
		
			$this->headers->Add($key,$value,$replace);
		
		}
		
		
		public function Cookie ($key, $value, \DateTime $expiry=null, $path=null, $domain=null, $secure=false, $httponly=false) {
		
			setcookie($key,$value,is_null($expiry) ? 0 : $expiry->getTimestamp(),$path,$domain,$secure,$httponly);
		
		}
		
		
		private static function send_impl ($key, $value) {
		
			header(sprintf('%s:%s',$key,$value));
		
		}
		
		
		public function Send () {
		
			foreach ($this->headers as $key=>$value) {
			
				if (is_array($value)) foreach ($value as $x) self::send_impl($key,$x);
				else self::send_impl($key,$value);
			
			}
		
		}
	
	
	}


?>