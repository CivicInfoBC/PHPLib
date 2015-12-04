<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains utilities for formatting strings.
	 */
	class Format {
	
	
		/**
		 *	Formats/normalizes a name.
		 *
		 *	Removes spurious whitespace.
		 *
		 *	Replaces all whitespace that isn't
		 *	the space character with the space
		 *	character.
		 *
		 *	Corrects capitalization.
		 *
		 *	\param [in] $name
		 *		A name.
		 *
		 *	\return
		 *		\em name after formatting/normalization.
		 */
		public static function Name ($name) {
		
			//	Perform a few initial clean up
			//	steps:
			//
			//	1.	Lower case the name (proper
			//		capitalization will be re-added
			//	2.	Trim leading/trailing whitespace
			//	3.	Replace all sequences of whitespace
			//		with single spaces.
			$name=StringUtil::ToLower(
				Regex::Replace(
					'/(?<=^|\\S)\\s+(?=\\S|$)/u',
					' ',
					StringUtil::Trim($name)
				)
			);
			
			//	Filter the name to correct casing
			//	et cetera
			foreach (array(
				//	First letter of each word
				//	is upper cased
				'/\\b(\\w)/u' => function ($matches) {
				
					return StringUtil::ToUpper($matches[1]);
					
				},
				//	Transform names like "O'donnel"
				//	to "O'Donnel"
				'/(?<=\\bO\')(\\w)/u' => function ($matches) {
				
					return StringUtil::ToUpper($matches[1]);
				
				},
				//	Transform names like "Mcdonald"
				//	and "Macwilliam" to "McDonald" and
				//	"MacWilliam", respectively
				'/\\b(Ma?c)(\\w)/u' => function ($matches) {
				
					return $matches[1].StringUtil::ToUpper($matches[2]);
				
				},
				//	Transform "van", "der", etc. to lower
				//	case
				'/\\b(v[ao]n|der?)\\b/ui' => function ($matches) {
				
					return StringUtil::ToLower($matches[1]);
				
				}
			) as $p=>$s) $name=($s instanceof \Closure) ? Regex::ReplaceCallback(
				$p,
				$s,
				$name
			) : Regex::Replace(
				$p,
				$s,
				$name
			);
			
			return $name;
		
		}
		
		
		/**
		 *	Formats a number as money.
		 *
		 *	\param [in] amount
		 *		The number to format.
		 *
		 *	\return
		 *		\em amount formatted as money.
		 */
		public static function Money ($amount) {
		
			return sprintf('$%.2f',round(floatval($amount),2));
		
		}
	
	
	}


?>