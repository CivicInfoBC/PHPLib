<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Encapsulates an SI prefix.
	 */
	class SIPrefix {
	
	
		private static $prefixes=array(
			'yotta' => 1000000000000000000000000.0,
			'zetta' => 1000000000000000000000.0,
			'exa' => 1000000000000000000.0,
			'peta' => 1000000000000000.0,
			'tera' => 1000000000000.0,
			'giga' => 1000000000.0,
			'mega' => 1000000.0,
			'kilo' => 1000.0,
			'hecto' => 100.0,
			'deca' => 10,
			//	10^1
			'deci' => 0.1,
			'centi' => 0.01,
			'milli' => 0.001,
			'micro' => 0.000001,
			'nano' => 0.000000001,
			'pico' => 0.000000000001,
			'femto' => 0.000000000000001,
			'atto' => 0.000000000000000001,
			'zepto' => 0.000000000000000000001,
			'yocto' => 0.000000000000000000000001
		);
		
		
		private static $symbols=array(
			'yotta' => 'Y',
			'zetta' => 'Z',
			'exa' => 'E',
			'peta' => 'P',
			'tera' => 'T',
			'giga' => 'G',
			'mega' => 'M',
			'kilo' => 'k',
			'hecto' => 'h',
			'deca' => 'da',
			//	10^1
			'deci' => 'd',
			'centi' => 'c',
			'milli' => 'm',
			'micro' => array('µ','u'),
			'nano' => 'n',
			'pico' => 'p',
			'femto' => 'f',
			'atta' => 'a',
			'zepto' => 'z',
			'yocto' => 'y'
		);
		
		
		private $prefix;
		
		
		private static function get_regex ($str, $insensitive=false) {
		
			$retr='/^\\s*';
			
			if (!is_array($str)) $str=array($str);
			$first=true;
			foreach ($str as $x) {
			
				if ($first) $first=false;
				else $retr.='|';
				
				$retr.=Regex::Escape($x);
			
			}
			
			$retr.='/u';
			
			if ($insensitive) $retr.='i';
			
			return $retr;
		
		}
		
		
		private static function is_match ($str, $subject, $insensitive=false) {
		
			return Regex::IsMatch(
				self::get_regex($str,$insensitive),
				$subject
			);
		
		}
		
		
		private function get_prefix ($str) {
		
			//	See if the string has a prefix
			//	directly
			foreach (array_keys(self::$prefixes) as $prefix) {
			
				if (self::is_match($prefix,$str,true)) {
				
					$this->prefix=$prefix;
					
					return $prefix;
					
				}
			
			}
			
			//	See if the string has a prefix through
			//	a symbol
			foreach (self::$symbols as $prefix=>$symbol) {
			
				if (self::is_match($symbol,$str)) {
				
					$this->prefix=$prefix;
					
					return $symbol;
					
				}
			
			}
			
			//	No prefix
		
		}
		
		
		/**
		 *	Obtains an SI prefix from a string.
		 *
		 *	\param [in] $str
		 *		A string.
		 */
		public function __construct ($str=null) {
		
			if (!is_null($str)) $this->get_prefix($str);
		
		}
		
		
		public static function Get (&$str) {
		
			$retr=new self();
			
			$substring=$retr->get_prefix($str);
			
			//	Remove substring
			$str=Regex::Replace(
				self::get_regex($substring,true),
				'',
				$str
			);
			
			return $retr;
		
		}
		
		
		/**
		 *	Determines whether this object is
		 *	encapsulating a prefix, or merely
		 *	a multiplier of 1.0.
		 *
		 *	\return
		 *		\em true if this object is
		 *		encapsulating the multiplier
		 *		1.0, \em false otherwise.
		 */
		public function IsEmpty () {
		
			return is_null($this->prefix);
		
		}
		
		
		/**
		 *	Obtains the prefix.
		 *
		 *	\return
		 *		A string containing the prefix.
		 */
		public function __toString () {
		
			return $this->IsEmpty() ? '' : $this->prefix;
		
		}
		
		
		/**
		 *	Gets the multiplier which can be used to
		 *	turn a numeric quantity of units into a
		 *	prefixed value.
		 *
		 *	To convert a prefixed value back to a
		 *	numeric quantity of units, you must
		 *	use the reciprocal of the returned value.
		 *
		 *	\return
		 *		A floating point value.
		 */
		public function GetMultiplier () {
		
			return $this->IsEmpty() ? 1.0 : self::$prefixes[$this->prefix];
		
		}
		
		
		/**
		 *	Gets the symbol for this prefix.
		 *
		 *	\return
		 *		The symbol for this prefix.
		 */
		public function GetSymbol () {
		
			if ($this->IsEmpty()) return '';
			
			return is_array($symbol=self::$symbols[$this->prefix]) ? $symbol[0] : $symbol;
		
		}
	
	
	}


?>