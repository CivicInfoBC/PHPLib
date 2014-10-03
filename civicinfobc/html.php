<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Encapsulates HTML text.
	 */
	class HTML {
	
	
		private $arr;
		
		
		/**
		 *	Constructs a new HTML object.
		 *
		 *	When this object is converted to a string, all
		 *	arguments passed to this construtor will be
		 *	stringified, HTML escaped, and concatenated to
		 *	form the HTML.
		 */
		public function __construct () {
		
			$arr=func_get_args();
		
		}
	
	
		private static function escape_array ($arr) {
		
			$retr='';
			foreach ($arr as $str) $retr.=is_array($str) ? self::escape_array($str) : htmlspecialchars($str);
			
			return $retr;
		
		}
	
	
		/**
		 *	Stringifies, HTML escapes, and concatenates all
		 *	arguments.
		 *
		 *	\return
		 *		An HTML string.
		 */
		public static function Escape () {
		
			return self::escape_array(func_get_args());
		
		}
		
		
		/**
		 *	Stringifies, HTML escapes, concatenates, and echoes
		 *	all arguments.
		 */
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
		
		
		/**
		 *	Obtains an HTML string which represents the object or
		 *	objects stored in this object.
		 *
		 *	\return
		 *		A string.
		 */
		public function __toString () {
		
			return self::Escape($this->arr);
		
		}
	
	
	}


?>