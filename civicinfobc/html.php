<?php


	namespace CivicInfoBC;
	
	
	class HTML {
	
	
		private static function escape_array ($arr) {
		
			$retr='';
			foreach ($arr as $str) $retr.=is_array($str) ? self::escape_array($str) : htmlspecialchars($str);
			
			return $retr;
		
		}
	
	
		public static function Escape () {
		
			return self::escape_array(func_get_args());
		
		}
		
		
		public static function Write () {
		
			echo(self::escape_array(func_get_args()));
		
		}
		
		
		public static function Parse ($html, $strict=false) {
		
			$retr=new \DOMDocument();
		
			$prev=libxml_use_internal_errors(true);
			libxml_clear_errors();
			
			$retr->loadHTML($html);
			
			$error=null;
			foreach (libxml_get_errors() as $err) {
			
				if (!$strict && (
					($err->level===LIBXML_ERR_WARNING) ||
					($err->level===LIBXML_ERR_ERROR)
				)) continue;
				
				$error=$err;
				
				break;
			
			}
			
			libxml_clear_errors();
			libxml_use_internal_errors($prev);
			
			if (!is_null($error)) throw new \Exception($error->message,$error->code);
			
			return $retr;
		
		}
	
	
	}


?>