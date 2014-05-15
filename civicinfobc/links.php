<?php


	namespace CivicInfoBC;


	class Links {
	
	
		private $root;
		
		
		public function __construct ($root=null) {
		
			$this->root=Regex::Replace(
				'/\\/$/u',
				'',
				is_null($root) ? Server::GetRoot() : $root
			);
		
		}
		
		
		private static function component ($str) {
		
			if (is_null($str)) return '';
		
			$retr='';
			if (is_array($str)) foreach ($str as $x) $retr.=self::component($x);
			else $retr.='/'.rawurlencode($str);
			
			return $retr;
		
		}
		
		
		private function get_root () {
		
			return self::ToSSL($this->root);
		
		}
		
		
		public function Get ($controller=null, $args=null, $get=null) {
		
			$args=ArrayUtil::Coalesce($args);
			$get=ArrayUtil::Coalesce($get);
		
			return $this->get_root().self::component($controller).self::component($args).URL::MakeQueryString($get);
		
		}
		
		
		public function GetFile ($components, $get=array()) {
		
			return $this->get_root().self::component($components).URL::MakeQueryString($get);
		
		}
		
		
		public static function GetSelf () {
		
			$arr=array();
			foreach (Request::$get as $key=>$value) $arr[$key]=$value;
			return Server::GetRoot().URL::MakeQueryString($arr);
		
		}
		
		
		public static function ToSSL ($url, $always=false) {
		
			return ($always || Server::IsSSL()) ? Regex::Replace(
				'/^http(?=\\:)/ui',
				'https',
				$url
			) : $url;
		
		}
	
	
	}


?>