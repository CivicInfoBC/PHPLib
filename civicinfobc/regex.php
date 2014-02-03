<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Wraps PHP's built-in PCRE functions and
	 *	provides simplifications for common tasks,
	 *	in addition to return code-to-exception
	 *	conversions.
	 */
	class Regex {
	
	
		public static function Escape ($str, $delimiter=null) {
		
			return preg_quote($str,$delimiter);
		
		}
		
		
		private static function check () {
		
			//	If there was no error, do nothing
			if (($errno=preg_last_error())===PREG_NO_ERROR) return;
			
			//	Decide which error message to use
			switch ($errno) {
			
				case PREG_INTERNAL_ERROR:
					$msg='Internal PCRE error';
					break;
				case PREG_BACKTRACK_LIMIT_ERROR:
					$msg='Backtrack limit reached';
					break;
				case PREG_RECURSION_LIMIT_ERROR:
					$msg='Recursion limit reached';
					break;
				case PREG_BAD_UTF8_ERROR:
					$msg='Malformed UTF-8 data';
					break;
				case PREG_BAD_UTF8_OFFSET_ERROR:
					$msg='Offset did not correspond to the beginning of a valid UTF-8 code point';
					break;
				default:
					$msg='Unknown PCRE error occurred';
					break;
			
			}
			
			throw new \Exception(
				$msg,
				$errno
			);
		
		}
		
		
		private static function replace_impl ($pattern, $replacement, $subject, $callback) {
		
			$retr=Error::Wrap(function () use ($pattern, $replacement, $subject, $callback) {
			
				return $callback ? preg_replace_callback(
					$pattern,
					$replacement,
					$subject
				) : preg_replace(
					$pattern,
					$replacement,
					$subject
				);
				
			});
			
			self::check();
			
			return $retr;
		
		}
		
		
		public static function Replace ($pattern, $replacement, $subject) {
		
			return self::replace_impl($pattern,$replacement,$subject,false);
		
		}
		
		
		public static function ReplaceCallback ($pattern, $callback, $subject) {
		
			return self::replace_impl($pattern,$callback,$subject,true);
		
		}
		
		
		public static function IsMatch ($pattern, $subject) {
		
			$num=Error::Wrap(function () use ($pattern, $subject) {
			
				return preg_match($pattern,$subject);
			
			});
			
			self::check();
			
			return $num===1;
		
		}
		
		
		public static function Match ($pattern, $subject) {
		
			$match=null;
			$num=Error::Wrap(function () use ($pattern, $subject, &$match) {
			
				return preg_match($pattern,$subject,$match);
			
			});
			
			self::check();
			
			return ($num===0) ? null : $match;
		
		}
		
		
		public static function Count ($pattern, $subject) {
		
			$num=Error::Wrap(function () use ($pattern, $subject) {
			
				return preg_match_all($pattern,$subject,$ignored,PREG_SET_ORDER);
			
			});
			
			self::check();
			
			return $num;
		
		}
		
		
		public static function Matches ($pattern, $subject) {
		
			$matches=null;
			$num=Error::Wrap(function () use ($pattern, $subject, &$matches) {
			
				return preg_match_all($pattern,$subject,$matches,PREG_SET_ORDER);
			
			});
			
			self::check();
			
			return ($num===0) ? null : $matches;
		
		}
		
		
		public static function Split ($pattern, $subject) {
		
			$retr=Error::Wrap(function () use ($pattern, $subject) {
			
				return preg_split($pattern,$subject);
			
			});
			
			self::check();
			
			return $retr;
		
		}
	
	
	}


?>