<?php


	namespace CivicInfoBC;
	
	
	if (function_exists('mb_internal_encoding')) mb_internal_encoding('utf-8');
	
	
	/**
	 *	Contains utilities for safely working
	 *	with strings.
	 *
	 *	In all cases Unicode-aware functions will
	 *	be used (with the assumption of UTF-8 unless
	 *	otherwise specified) if they are available.
	 */
	class String {
	
	
		/**
		 *	Transforms a string to uppercase.
		 *
		 *	\param [in] $string
		 *		The string.
		 *
		 *	\return
		 *		\em string with all its characters
		 *		transformed to uppercase.
		 */
		public static function ToUpper ($string) {
		
			return function_exists('mb_strtoupper') ? mb_strtoupper($string) : strtoupper($string);
		
		}
		
		
		/**
		 *	Transforms a string to lowercase.
		 *
		 *	\param [in] $string
		 *		The string.
		 *
		 *	\return
		 *		\em string with all its characters
		 *		transformed to lowercase.
		 */
		public static function ToLower ($string) {
		
			return function_exists('mb_strtolower') ? mb_strtolower($string) : strtolower($string);
		
		}
		
		
		/**
		 *	Normalizes a string to a certain Unicode
		 *	canonical form.  If Unicode-aware functions
		 *	are unavailable, does nothing.
		 *
		 *	\param [in] $string
		 *		The string to normalize.
		 *	\param [in] $normal_form
		 *		A constant from the Normalizer class
		 *		specifying the normal form to use.
		 *		If not provided uses the Normalizer
		 *		class' default.
		 *
		 *	\return
		 *		The equivalent of \em string in the
		 *		specified normal form.
		 */
		public static function Normalize ($string, $normal_form=null) {
		
			return (
				class_exists('Normalizer')
					?	(
							is_null($normal_form)
								?	\Normalizer::normalize($string)
								:	\Nomralizer::normalize($string,$normal_form)
						)
					:	(string)$string
			);
		
		}
		
		
		/**
		 *	Tests to see if two strings are equivalent.
		 *
		 *	\param [in] $a
		 *		A string.
		 *	\param [in] $b
		 *		A string.
		 *
		 *	\return
		 *		\em true if \em a and \em b should be
		 *		treated as equal, \em false otherwise.
		 */
		public static function Equals ($a, $b) {
		
			return self::Normalize($a)===self::Normalize($b);
		
		}
		
		
		/**
		 *	Determines the number of code points in
		 *	a string.
		 *
		 *	\param [in] $string
		 *		A string.
		 *
		 *	\return
		 *		The number of code points in \em string.
		 */
		public static function Length ($string) {
		
			return function_exists('mb_strlen') ? mb_strlen($string) : strlen($string);
		
		}
		
		
		/**
		 *	Compares two strings.
		 *
		 *	\param [in] $a
		 *		A string.
		 *	\param [in] $b
		 *		A string.
		 *	\param [in] $collation
		 *		A constant from the Collator class
		 *		specifying the Unicode collation to
		 *		use.  If not provided uses the
		 *		Collator class' default.
		 *
		 *	\return
		 *		A negative number if \em a less than \em b,
		 *		zero if \em a is ordered the same as \em b,
		 *		a positive number if \em a greater than \em b.
		 */
		public static function Compare ($a, $b, $collation=null) {
		
			if (class_exists('Collator')) {
			
				$c=new \Collator($collation);
				$c->setAttribute(
					\Collator::NORMALIZATION_MODE,
					\Collator::ON
				);
				
				return $c->compare($a,$b);
			
			}
			
			return strcmp($a,$b);
		
		}
		
		
		/**
		 *	Compares two strings.
		 *
		 *	\param [in] $a
		 *		A string.
		 *	\param [in] $b
		 *		A string.
		 *	\param [in] $collation
		 *		A constant from the Collator class
		 *		specifying the Unicode collation to
		 *		use.  If not provided uses the
		 *		Collator class' default.
		 *
		 *	\return
		 *		\em true if \em a is greater than \em b,
		 *		\em false otherwise.
		 */
		public static function Greater ($a, $b, $collation=null) {
		
			return self::Compare($a,$b,$collation)>0;
		
		}
		
		
		/**
		 *	Compares two strings.
		 *
		 *	\param [in] $a
		 *		A string.
		 *	\param [in] $b
		 *		A string.
		 *	\param [in] $collation
		 *		A constant from the Collator class
		 *		specifying the Unicode collation to
		 *		use.  If not provided uses the
		 *		Collator class' default.
		 *
		 *	\return
		 *		\em true if \em a is less than \em b,
		 *		\em false otherwise.
		 */
		public static function Less ($a, $b, $collation=null) {
		
			return self::Compare($a,$b,$collation)<0;
		
		}
		
		
		/**
		 *	Compares two strings.
		 *
		 *	\param [in] $a
		 *		A string.
		 *	\param [in] $b
		 *		A string.
		 *	\param [in] $collation
		 *		A constant from the Collator class
		 *		specifying the Unicode collation to
		 *		use.  If not provided uses the
		 *		Collator class' default.
		 *
		 *	\return
		 *		\em true if \em a and \em b should be
		 *		ordered the same.  Note that this does
		 *		not imply that \em a and \em b are
		 *		equivalent.
		 */
		public static function OrderedSame ($a, $b, $collation=null) {
		
			return self::Compare($a,$b,$collation)===0;
		
		}
		
		
		/**
		 *	Compares two strings.
		 *
		 *	\param [in] $a
		 *		A string.
		 *	\param [in] $b
		 *		A string.
		 *	\param [in] $collation
		 *		A constant from the Collator class
		 *		specifying the Unicode collation to
		 *		use.  If not provided uses the
		 *		Collator class' default.
		 *
		 *	\return
		 *		\em true if \em a is greater than or
		 *		ordered the same as \em b.
		 */
		public static function GreaterOrEquals ($a, $b, $collation=null) {
		
			return self::Compare($a,$b,$collation)>=0;
		
		}
		
		
		/**
		 *	Compares two strings.
		 *
		 *	\param [in] $a
		 *		A string.
		 *	\param [in] $b
		 *		A string.
		 *	\param [in] $collation
		 *		A constant from the Collator class
		 *		specifying the Unicode collation to
		 *		use.  If not provided uses the
		 *		Collator class' default.
		 *
		 *	\return
		 *		\em true if \em a is less than or
		 *		ordered the same as \em b.
		 */
		public static function LessOrEquals ($a, $b, $collation=null) {
		
			return self::Compare($a,$b,$collation)<=0;
		
		}
		
		
		/**
		 *	Fetches a callback which may be passed
		 *	to usort and other such functions to
		 *	sort strings.
		 *
		 *	\param [in] $asc
		 *		Whether the return callback should
		 *		sort in ascending order or not.
		 *		Defaults to \em true.
		 *	\param [in] $collation
		 *		The collation to use.  Defaults to
		 * 		the default collation.
		 *
		 *	\return
		 *		A callback which orders strings as
		 *		specified.
		 */
		public static function GetSorter ($asc=true, $collation=null) {
		
			return function ($a, $b) use ($asc, $collation) {
			
				$val=String::Compare($a,$b,$collation);
				
				if (!$asc) $val*=-1;
				
				return $val;
			
			};
		
		}
		
		
		/**
		 *	Removes all whitespace from the beginning
		 *	and end of a string.
		 *
		 *	\param [in] $string
		 *		A string.
		 *
		 *	\return
		 *		\em string with all trailing and leading
		 *		whitespace removed.
		 */
		public static function Trim ($string) {
		
			return Regex::Replace(
				'/^\\s+|\\s+$/u',
				'',
				$string
			);
		
		}
	
	
	}


?>