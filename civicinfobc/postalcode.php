<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains utilities for working with postal
	 *	codes, and may be instantiated to wrap and
	 *	acquire information about a particular
	 *	postal code.
	 */
	class PostalCode {
	
	
		private $str;
		
		
		private static function normalize_impl ($str) {
		
			//	Get rid of leading/trailing whitespace
			$str=String::Trim($str);
			
			//	Make sure the postal code begins and
			//	ends with a permissible character
			if (!(
				//	Make sure the postal code begins
				//	with a permissible character
				Regex::IsMatch(
					'/^\\s*[0-9a-zA-Z]/u',
					$str
				) &&
				//	Make sure the postal code ends
				//	with a permissible character
				Regex::IsMatch(
					'/[0-9a-zA-Z]\\s*$/u',
					$str
				) &&
				//	Make sure the postal code is comprised
				//	entirely of permissible characters
				Regex::IsMatch(
					'/^[\\s0-9a-zA-Z\\-]*$/u',
					$str
				)
			)) return null;
			
			//	Strip all characters that are not permitted
			$str=Regex::Replace(
				'/[^0-9a-zA-Z]/u',
				'',
				$str
			);
			
			//	The resulting string must not be more than
			//	10 characters, or less than 3 characters
			//	in length
			if (
				(($len=String::Length($str))>10) ||
				($len<3)
			) return null;
			
			//	Upper case and return
			return String::ToUpper($str);
		
		}
		
		
		/**
		 *	Normalizes a postal code, stripping all characters
		 *	which are not part of the ISO standard alphabet
		 *	or an arabic numberal, and then converting what
		 *	remains to upper case.
		 *
		 *	If the provided string does not contain a valid
		 *	postal code, an exception is thrown.
		 *
		 *	\param [in] $str
		 *		A string.
		 *
		 *	\return
		 *		A normalized postal code derived from \em str.
		 */
		public static function Normalize ($str) {
		
			if (is_null($retr=self::normalize_impl($str))) throw new \Exception(
				sprintf(
					'"%s" is not a valid postal code',
					$str
				)
			);
			
			return $retr;
		
		}
		
		
		/**
		 *	Verifies that a string contains a valid postal
		 *	code.
		 *
		 *	\param [in] $str
		 *		A string.
		 *
		 *	\return
		 *		\em true if \em str represents a valid postal
		 *		code, \em false otherwise.
		 */
		public static function Verify ($str) {
		
			return !is_null(self::normalize_impl($str));
		
		}
		
		
		/**
		 *	Creates a new postal code object.
		 *
		 *	\param [in] $str
		 *		A string containing the postal code.
		 */
		public function __construct ($str) {
		
			$this->str=self::Normalize($str);
		
		}
		
		
		/**
		 *	Checks to see if this postal code matches
		 *	a given Perl compatible regular expression.
		 *
		 *	\param [in] $regex
		 *		The regular expression to match against.
		 *
		 *	\return
		 *		\em true if the postal code matches
		 *		\em regex, \em false otherwise.
		 */
		public function IsMatch ($regex) {
		
			return Regex::IsMatch(
				$regex,
				$this->str
			);
		
		}
		
		
		/**
		 *	Checks to see if this postal code is
		 *	alphanumeric.
		 *
		 *	\"Alphanumeric\" postal codes contain
		 *	letters from the ISO basic Latin
		 *	alphabet, in addition to arabic
		 *	numerals.
		 *
		 *	\return
		 *		\em true if this postal code is
		 *		alphanumeric, \em false otherwise.
		 */
		public function IsAlphanumeric () {
		
			return $this->IsMatch('/[A-Z]/u');
		
		}
		
		
		/**
		 *	Checks to see if this postal code is
		 *	numeric.
		 *
		 *	\"Numeric\" postal codes contain only
		 *	arabic numerals.
		 *
		 *	\return
		 *		\em true if this postal code is
		 *		numeric, \em false otherwise.
		 */
		public function IsNumeric () {
		
			return $this->IsMatch('^[0-9]+$/u');
		
		}
		
		
		/**
		 *	Checks to see if this instance contains
		 *	a valid Canadian postal code.
		 *
		 *	\return
		 *		\em true if this instance contains
		 *		a valid Canadian postal code, \em false
		 *		otherwise.
		 */
		public function IsCanadian () {
		
			return (
				//	Canadian postal codes contain alternating
				//	letters and numbers, starting with a
				//	letter
				$this->IsMatch('/^(?:[A-Z][0-9]){3}$/u') &&
				//	Canadian postal codes do not contain the
				//	letters D, F, I, O, Q, or U
				!$this->IsMatch('/[DFIOQU]/u') &&
				//	Canadian postal codes do not begin with
				//	W or Z
				!$this->IsMatch('/^[WZ]/u')
			);
		
		}
		
		
		/**
		 *	Checks to see if this instance contains
		 *	a valid United States of America zip
		 *	code.
		 *
		 *	\return
		 *		\em true if this instance contains
		 *		a valid United States of America zip
		 *		code, \em false otherwise.
		 */
		public function IsAmerican () {
		
			//	US zip codes are 5 digits
			return $this->IsMatch('/[0-9]{5}/u');
		
		}
		
		
		/**
		 *	Checks to see if this instance contains
		 *	a valid Australian postal code.
		 *
		 *	\return
		 *		\em true if this instance contains a
		 *		valid Australian postal code, \em false
		 *		otherwise.
		 */
		public function IsAustralian () {
		
			//	Australian postal codes are 4 digits
			return $this->IsMatch('/[0-9]{4}/u');
		
		}
		
		
		/**
		 *	Retrieves a string representation of
		 *	this postal code.
		 *
		 *	\return
		 *		A string which represents this
		 *		postal code.
		 */
		public function __toString () {
		
			return $this->str;
		
		}
	
	
	}


?>