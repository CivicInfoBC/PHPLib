<?php


	namespace CivicInfoBC\Framework;
	
	
	class HTTPRequest extends Request {
	
	
		private $args;
		
		
		public function __construct (array $args) {
		
			$this->args=$args;
		
		}
		
		
		public function Arguments () {
		
			return $this->args;
		
		}
		
		
		public function Body () {
		
			return \CivicInfoBC\Request::GetBody();
		
		}
		
		
		public function IP () {
		
			return \CivicInfoBC\Request::$server->REMOTE_ADDR;
		
		}
		
		
		public function Method () {
		
			return \CivicInfoBC\Request::$server->REQUEST_METHOD;
		
		}
		
		
		public function URL () {
		
			return \CivicInfoBC\Server::GetURL();
		
		}
		
		
		public function Get ($key, $default=null) {
		
			return \CivicInfoBC\Request::$get->Get($key,$default);
		
		}
		
		
		public function Cookie ($key, $default=null) {
		
			return \CivicInfoBC\Request::$cookie->Get($key,$default);
		
		}
		
		
		public function Post ($key, $default=null) {
		
			return \CivicInfoBC\Request::$post->Get($key,$default);
		
		}
	
	
	}


?>