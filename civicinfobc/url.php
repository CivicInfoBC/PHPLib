<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains utilities for manipulating
	 *	uniform resource locators.
	 */
	class URL {
	
	
		private static function escape_array ($arr) {
		
			$retr='';
			foreach ($arr as $str) $retr.=is_array($str) ? self::escape_array($str) : rawurlencode($str);
			
			return $retr;
		
		}
		
		
		/**
		 *	Enscapes an arbitrary number of strings,
		 *	making them safe for insertion into a URL.
		 *
		 *	An arbitrary number of arguments may be
		 *	passed, they will be escaped and concatenated.
		 *
		 *	\return
		 *		The escaped string.
		 */
		public static function Escape () {
		
			return self::escape_array(func_get_args());
		
		}
	
	
		/**
		 *	Transforms an associative array into a query
		 *	string.
		 *
		 *	\param [in] $args
		 *		The associative array.
		 *
		 *	\return
		 *		A query string, beginning with the question
		 *		mark, which contains all keys and values
		 *		of \em args properly escaped and formatted.
		 */
		public static function MakeQueryString ($args) {
		
			$retr='';
			$first=true;
			foreach ($args as $key=>$value) {
			
				if ($first) {
				
					$retr.='?';
					
					$first=false;
				
				} else {
				
					$retr.='&';
				
				}
				
				$retr.=self::Escape($key).'='.self::Escape($value);
			
			}
			
			return $retr;
		
		}
		
		
		private static function combine_array ($arr) {
			
			$retr='';
			foreach ($arr as $x) {
			
				if (is_array($x)) $x=self::combine_array($x);
				
				$retr=($retr==='') ? $x : Regex::Replace(
					'/\\/$/u',
					'',
					$retr
				).Regex::Replace(
					'/^(?!\\/)/u',
					'/',
					$x
				);
			
			}
			
			return $retr;
		
		}
		
		
		/**
		 *	Combines URL components to form a new URL
		 *	or URL component.
		 *
		 *	An arbitrary number of arguments may be passed,
		 *	they will all be joined.
		 *
		 *	\return
		 *		The result of joining all components.
		 */
		public static function Combine () {
		
			return self::combine_array(func_get_args());
		
		}
	
	
	}


?>