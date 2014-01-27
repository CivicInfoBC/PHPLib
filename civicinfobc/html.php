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
	
	
	}


?>