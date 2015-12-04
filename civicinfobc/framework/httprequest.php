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
		
		
		private function get_impl ($obj) {
			
			foreach ($obj as $key=>$value) if (!is_null($value)) yield $key=>$value;
			
		}
		
		
		private function get_gen () {
			
			return $this->get_impl(\CivicInfoBC\Request::$get);
			
		}
		
		
		public function Get ($key=null, $default=null) {
			
			return is_null($key) ? $this->get_gen() : \CivicInfoBC\Request::$get->Get($key,$default);
		
		}
		
		
		private function get_cookie () {
			
			return $this->get_impl(\CivicInfoBC\Request::$cookie);
			
		}
		
		
		public function Cookie ($key=null, $default=null) {
			
			return is_null($key) ? $this->get_cookie() : \CivicInfoBC\Request::$cookie->Get($key,$default);
		
		}
		
		
		private function get_post () {
			
			return $this->get_impl(\CivicInfoBC\Request::$post);
			
		}
		
		
		public function Post ($key=null, $default=null) {
		
			return is_null($key) ? $this->get_post() : \CivicInfoBC\Request::$post->Get($key,$default);
		
		}
		
		
		private function get_header () {
			
			$pattern='/^HTTP_/u';
			foreach ($this->get_impl(\CivicInfoBC\Request::$server) as $key=>$value) {
				
				if (!\CivicInfoBC\Regex::IsMatch($pattern,$key)) continue;
				
				$key=\CivicInfoBC\Regex::Replace($pattern,'',$key);
				$key=\CivicInfoBC\StringUtil::ToLower($key);
				yield $key=>$value;
				
			}
			
		}
		
		
		public function Header ($key=null, $default=null) {
			
			if (is_null($key)) return $this->get_header();
			
			$key='HTTP_'.\CivicInfoBC\StringUtil::ToUpper($key);
			if (isset(\CivicInfoBC\Request::$server->$key)) return \CivicInfoBC\Request::$server->$key;
			
			return $default;
			
		}
	
	
	}


?>