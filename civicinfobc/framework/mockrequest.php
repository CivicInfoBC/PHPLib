<?php


	namespace CivicInfoBC\Framework;
	
	
	class MockRequest extends Request {
		
		
		private $args=array();
		private $body='';
		private $ip='127.0.0.1';
		private $method='GET';
		private $url='http://127.0.0.1';
		private $get=array();
		private $cookie=array();
		private $post=array();
		private $header=array();
		
		
		public function SetArguments (array $args) {
			
			$this->args=$args;
			
		}
		
		
		public function Arguments () {
			
			return $this->args;
			
		}
		
		
		public function SetBody ($str) {
			
			$this->body=$str;
			
		}
		
		
		public function Body () {
			
			return $this->body;
			
		}
		
		
		public function SetIP ($ip) {
			
			$this->ip=$ip;
			
		}
		
		
		public function IP () {
			
			return $this->ip;
			
		}
		
		
		public function SetMethod ($method) {
			
			$this->method=$method;
			
		}
		
		
		public function Method () {
			
			return $this->method;
			
		}
		
		
		public function SetURL ($url) {
			
			$this->url=$url;
			
		}
		
		
		public function URL () {
			
			return $this->url;
			
		}
		
		
		public function SetGet (array $arr) {
			
			$this->get=$arr;
			
		}
		
		
		public function Get ($key=null, $default=null) {
			
			if (is_null($key)) return new \ArrayIterator($this->get);
			
			return isset($this->get[$key]) ? $this->get[$key] : $default;
			
		}
		
		
		public function SetPost (array $arr) {
			
			$this->post=$arr;
			
		}
		
		
		public function Post ($key=null, $default=null) {
			
			if (is_null($key)) return new \ArrayIterator($this->post);
			
			return isset($this->post[$key]) ? $this->post[$key] : $default;
			
		}
		
		
		public function SetCookie (array $arr) {
			
			$this->cookie=$arr;
			
		}
		
		
		public function Cookie ($key=null, $default=null) {
			
			if (is_null($key)) return new \ArrayIterator($this->cookie);
			
			return isset($this->cookie[$key]) ? $this->cookie[$key] : $default;
			
		}
		
		
		public function SetHeader (array $arr) {
			
			$this->header=$arr;
			
		}
		
		
		public function Header ($key=null, $default=null) {
			
			if (is_null($key)) return new \ArrayIterator($this->header);
			
			return isset($this->header[$key]) ? $this->header[$key] : $default;
			
		}
		
		
	}


?>