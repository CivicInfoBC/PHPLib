<?php


	namespace Tests;


	use \CivicInfoBC\String as S;
	use \CivicInfoBC\Testing\Test as T;
	
	
	class String extends \CivicInfoBC\Testing\TestSuite {
	
	
		private static function ordered_same ($a, $b) {
		
			$asc=S::GetSorter();
			$desc=S::GetSorter(false);
		
			return (
				($asc($a,$b)===$desc($a,$b)) &&
				(S::Compare($a,$b)===0) &&
				S::OrderedSame($a,$b) &&
				!S::Less($a,$b) &&
				!S::Greater($a,$b) &&
				S::LessOrEquals($a,$b) &&
				S::GreaterOrEquals($a,$b)
			);
		
		}
	
	
		public static function OrderedSame ($a, $b) {
		
			return self::ordered_same($a,$b) && self::ordered_same($b,$a);

		}
		
		
		public static function Greater ($a, $b) {
		
			$asc=S::GetSorter();
			$desc=S::GetSorter(false);
			
			return (
				($asc($a,$b)>0) &&
				($desc($a,$b)<0) &&
				(S::Compare($a,$b)>0) &&
				!S::OrderedSame($a,$b) &&
				!S::Less($a,$b) &&
				S::Greater($a,$b) &&
				!S::LessOrEquals($a,$b) &&
				S::GreaterOrEquals($a,$b)
			);
		
		}
		
		
		public static function Lesser ($a, $b) {
		
			$asc=S::GetSorter();
			$desc=S::GetSorter(false);
			
			return (
				($asc($a,$b)<0) &&
				($desc($a,$b)>0) &&
				(S::Compare($a,$b)<0) &&
				!S::OrderedSame($a,$b) &&
				S::Less($a,$b) &&
				!S::Greater($a,$b) &&
				S::LessOrEquals($a,$b) &&
				!S::GreaterOrEquals($a,$b)
			);
		
		}
	
	
		public function __construct () {
		
			parent::__construct('Multi-Byte String Utilities');
			
			$this->tester->tests=array(
				new T(
					'Multi-Byte',
					'This platform is multi-byte capable',
					function () {	return S::IsMultiByte();	}
				),
				new T(
					'ToUpper (ASCII)',
					'ToUpper method works for ASCII strings',
					function () {	return S::ToUpper('hello?')==='HELLO?';	}
				),
				new T(
					'ToUpper (Unicode)',
					'ToUpper method works for Unicode strings',
					function () {	return S::ToUpper('naïveté façade')==='NAÏVETÉ FAÇADE';	}
				),
				new T(
					'ToLower (ASCII)',
					'ToLower method works for ASCII strings',
					function () {	return S::ToLower('HELLO?')==='hello?';	}
				),
				new T(
					'ToLower (Unicode)',
					'ToLower method works for Unicode strings',
					function () {	return S::ToLower('NAÏVETÉ FAÇADE')==='naïveté façade';	}
				),
				new T(
					'Normalize (identity)',
					'Normalize method leaves strings already normalized untouched',
					function () {
					
						$str='hello world!';
						return S::Normalize($str)===$str;
					
					}
				),
				//	For all all tests on Unicode equivalence and normalization,
				//	be aware that two versions of the Unicode string "naïveté"
				//	are being used:
				//
				//	The first is in Normal Form Canonical Composition:
				//
				//	naïveté
				//
				//	U+006E ==> LATIN SMALL LETTER N               
				//	U+0061 ==> LATIN SMALL LETTER A               
				//	U+00EF ==> LATIN SMALL LETTER I WITH DIAERESIS
				//	U+0076 ==> LATIN SMALL LETTER V               
				//	U+0065 ==> LATIN SMALL LETTER E               
				//	U+0074 ==> LATIN SMALL LETTER T               
				//	U+00E9 ==> LATIN SMALL LETTER E WITH ACUTE
				//
				//	The second is in Normal Form Canonical Decomposition:
				//
				//	naïveté
				//
				//	U+006E ==> LATIN SMALL LETTER N  
				//	U+0061 ==> LATIN SMALL LETTER A  
				//	U+0069 ==> LATIN SMALL LETTER I  
				//	U+0308 ==> COMBINING DIAERESIS   
				//	U+0076 ==> LATIN SMALL LETTER V  
				//	U+0065 ==> LATIN SMALL LETTER E  
				//	U+0074 ==> LATIN SMALL LETTER T  
				//	U+0065 ==> LATIN SMALL LETTER E  
				//	U+0301 ==> COMBINING ACUTE ACCENT
				//
				//	If you are using a text editor which automatically highlights
				//	other occurrences of a word when you highlight it, you can
				//	see where each one is being used by highlighting the strings
				//	above (notice that they are not the same string, where "string"
				//	is understood to mean the same sequence of bits.  They are,
				//	however, equivalent strings).
				new T(
					'Normalize (decomposition)',
					'Normalize method properly decomposes combining marks',
					function () {	return S::Normalize('naïveté',\Normalizer::FORM_D)==='naïveté';	}
				),
				new T(
					'Normalize (composition)',
					'Normalize method properly composes combining marks',
					function () {	return S::Normalize('naïveté',\Normalizer::FORM_C)==='naïveté';	}
				),
				new T(
					'Equals (ASCII, equality)',
					'Equals method properly determines that identical ASCII strings are equivalent',
					function () {
					
						$str='hello world';
						return S::Equals($str,$str);
						
					}
				),
				new T(
					'Equals (ASCII, inequality)',
					'Equals method properly determines that different ASCII strings are not equivalent',
					function () {	return !S::Equals('hello world','hello');	}
				),
				new T(
					'Equals (Unicode, equality)',
					'Equals method properly determines that identical Unicode strings are equivalent',
					function () {
					
						$str='naïveté';
						return S::Equals($str,$str);
						
					}
				),
				new T(
					'Equals (Unicode, inequality)',
					'Equals method properly determines that different Unicode strings which are not equivalent are not equivalent',
					function () {	return !S::Equals('naïveté','façade');	}
				),
				new T(
					'Equals (Unicode, equality, different normalization)',
					'Equals method properly finds equivalent Unicode strings to be equivalent regardless of normalization',
					function () {	return S::Equals('naïveté','naïveté');	}
				),
				new T(
					'Length (single-byte code points)',
					'Length method agrees with strlen for single-byte code points',
					function () {
					
						$str='hello world';
						$len=S::Length($str);
						return ($len===strlen($str)) && ($len===11);
					
					}
				),
				new T(
					'Length (multi-byte code points)',
					'Length method disagrees with strlen for multi-byte code points and counts them as one',
					function () {
					
						$str='naïveté';
						$len=S::Length($str);
						return ($len!==strlen($str)) && ($len===7);
						
					}
				),
				new T(
					'Length (empty string)',
					'Length method properly returns zero as the length of the empty string',
					function () {	return S::Length('')===0;	}
				),
				new T(
					'Length (differently normalized Unicode strings)',
					'Length method properly returns different values for equivalent strings normalized differently',
					function () {	return S::Length('naïveté')!==S::Length('naïveté');	}
				),
				new T(
					'Compare (ordered same, ASCII, identical)',
					'Identical ASCII strings are ordered the same',
					function () {
					
						$str='hello world';
						return String::OrderedSame($str,$str);
					
					}
				),
				new T(
					'Compare (ordered same, Unicode, identical)',
					'Identical Unicode strings are ordered the same',
					function () {
					
						$str='naïveté';
						return String::OrderedSame($str,$str);
					
					}
				),
				new T(
					'Compare (ordered same, Unicode, differently normalized)',
					'Differently normalized, equivalent Unicode strings are ordered the same',
					function () {	return String::OrderedSame('naïveté','naïveté');	}
				),
				new T(
					'Compare (greater, ASCII)',
					'An ASCII string which alphabetically succeeds another ASCII string is ordered greater',
					function () {	return String::Greater('bets','aardvark');	}
				),
				new T(
					'Compare (greater, Unicode)',
					'A Unicode string which alphabetically succeeds another Unicode string is ordered greater',
					function () {	return String::Greater('naïveté','façade') && String::Greater('ñ','ç');	}
				),
				new T(
					'Compare (lesser, ASCII)',
					'An ASCII string which alphabetically precedes another ASCII string is ordered lesser',
					function () {	return String::Lesser('aardvark','bets');	}
				),
				new T(
					'Compare (lesser, Unicode)',
					'A Unicode string which alphabetically precedes another Unicode string is ordered lesser',
					function () {	return String::Lesser('façade','naïveté') && String::Lesser('ç','ñ');	}
				),
				new T(
					'Trim (identity)',
					'Trim method leaves strings without trailing or leading whitespace untouched',
					function () {
					
						$str='hello world';
						return S::Trim($str)===$str;
					
					}
				),
				new T(
					'Trim (empty string)',
					'Trim method works correctly on the empty string',
					function () {	return S::Trim('')==='';	}
				),
				new T(
					'Trim (ASCII)',
					'Trim method strips ASCII leading and trailing whitespace',
					function () {
					
						$str="    hello world     \n";
						$trimmed=S::Trim($str);
						return ($trimmed==='hello world') && ($trimmed===trim($str));
					
					}
				),
				new T(
					'Trim (Unicode)',
					'Trim method strips Unicode leading and trailing whitespace',
					function () {
					
						//	The string being put into the Trim method
						//	has a NBSP (U+00A0) at the beginning and end,
						//	the string it's being compared to does not
						return S::Trim(' Margaret ')==='Margaret';
					
					}
				),
				new T(
					'Convert (ASCII)',
					'Converting an ASCII string to ASCII leaves it untouched',
					function () {
					
						$str='hello world';
						return S::ConvertTo($str,'ascii')===$str;
					
					}
				),
				new T(
					'Convert (ASCII, lossy)',
					'Converting a Unicode string to ASCII results in a different string',
					function () {
					
						$str='naïveté';
						return S::ConvertTo($str,'ascii')!==$str;
					
					}
				),
				new T(
					'Convert (Unicode, UTF-16, round trip)',
					'Converter can round-trip a string losslessly',
					function () {
					
						$str='naïveté';
						$utf16=S::ConvertTo($str,'utf-16');
						return (
							(strlen($utf16)===(2*S::Length($str))) &&
							(S::ConvertFrom($utf16,'utf-16')===$str)
						);
					
					}
				),
				new T(
					'Convert (Unicode, UTF-16 to UTF-32)',
					'Converter can directly convert from one non-UTF-8 encoding to another',
					function () {
					
						$str='naïveté';
						$utf32=S::Convert(
							$utf16=S::ConvertTo($str,'utf-16'),
							'utf-32',
							'utf-16'
						);
						return (
							(strlen($utf32)===(2*strlen($utf16))) &&
							(S::ConvertFrom($utf32,'utf-32')===$str)
						);
					
					}
				)
			);
		
		}
	
	
	}


?>