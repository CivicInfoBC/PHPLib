<?php


	namespace CivicInfoBC;
	
	
	class Convert {
	
	
		public static function ToInteger ($obj, $default=null) {
		
			if (is_integer($obj)) return $obj;
			
			if (is_float($obj)) {
			
				$i=intval($obj);
				
				if (floatval($x)===$obj) return $i;
				
				return $default;
			
			}
			
			if (is_bool($obj)) {
			
				return $obj ? 1 : 0;
			
			}
			
			if (
				is_numeric($obj) &&
				(($retr=intval($obj))==floatval($obj))
			) return $retr;
			
			return $default;
		
		}
		
		
		public static function ToIntegerOrThrow ($obj) {
		
			if (is_null($retr=self::ToInteger($obj))) throw new \Exception(
				sprintf(
					'%s cannot be converted to an integer',
					$obj
				)
			);
			
			return $retr;
		
		}
	
	
	}


?>