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
		
		
		public static function ToFloat ($obj, $default=null) {
		
			if (is_float($obj)) return $obj;
		
			if (is_integer($obj)) return floatval($obj);
			
			if (is_bool($obj)) return floatval($obj ? 1 : 0);
			
			if (is_numeric($obj)) return floatval($obj);
			
			return $default;
		
		}
		
		
		public static function ToFloatOrThrow ($obj) {
		
			if (is_null($retr=self::ToFloat($obj))) throw new \Exception(
				sprintf(
					'%s cannot be converted to a floating point value',
					$obj
				)
			);
			
			return $retr;
		
		}
		
		
		public static function ToBoolean ($obj, $default=null) {
		
			if (is_bool($obj)) return $obj;
		
			if (is_float($obj)) {
			
				if ($obj===0.0) return false;
				if ($obj===1.0) return true;
				
				return null;
			
			}
			
			if (is_integer($obj)) {
			
				if ($obj===0) return false;
				if ($obj===1) return true;
				
				return null;
			
			}
			
			if (Regex::IsMatch(
				'/^\\s*(?:t(?:rue)?|y(?:es)?)\\s*$/ui',
				$obj
			)) return true;
			
			if (Regex::IsMatch(
				'/^\\s*(?:f(?:alse)?|no?)\\s*$/ui',
				$obj
			)) return false;
			
			return null;
		
		}
		
		
		public static function ToBooleanOrThrow ($obj) {
		
			if (is_null($retr=self::ToBoolean($obj))) throw new \Exception(
				sprintf(
					'%s cannot be converted to a boolean value',
					$obj
				)
			);
			
			return $retr;
		
		}
		
		
		private static function date_time_is_error (array $arr) {
		
			return !(($arr['warning_count']===0) && ($arr['error_count']===0));
		
		}
		
		
		public static function ToDateTime ($str, $format, $default=null) {
		
			return (
				(($retr=\DateTime::createFromFormat($format,$str))===false) ||
				self::date_time_is_error(\DateTime::getLastErrors())
			) ? $default : $retr;
		
		}
		
		
		private static function get_date_time_error ($prefix, array $arr, $curr='') {
		
			foreach ($arr as $char=>$msg) {
			
				if ($curr!=='') $curr.='; ';
				$curr.=sprintf(
					'%s: %s at offset %s',
					$prefix,
					$msg,
					$char
				);
			
			}
			
			return $curr;
		
		}
		
		
		public static function ToDateTimeOrThrow ($str, $format) {
		
			$retr=\DateTime::createFromFormat($format,$str);
			
			$arr=\DateTime::getLastErrors();
			
			if (!(
				($retr===false) ||
				self::date_time_is_error($arr)
			)) return $retr;
			
			//	ERROR
			
			$str=sprintf(
				'"%s" could not be converted to a DateTime with format string "%s"',
				$str,
				$format
			);
			$errors=self::get_date_time_error(
				'ERROR',
				$arr['errors'],
				self::get_date_time_error(
					'WARNING',
					$arr['warnings']
				)
			);
			if ($errors!=='') $str.=': '.$errors;
			
			throw new \Exception($str);
		
		}
	
	
	}


?>