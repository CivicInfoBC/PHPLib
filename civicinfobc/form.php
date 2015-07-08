<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains utilities for interacting with HTML forms.
	 */
	class Form {
		
		
		/**
		 *	Decodes a string containing URL form encoded key/value
		 *	pairs into an object.
		 *
		 *	Unlike built in PHP form decoding duplicate keys will be
		 *	collapsed into an array of all associated values.
		 *
		 *	\return
		 *		An object with the keys of the form as its keys and
		 *		the values associated with those keys in the encoded
		 *		form as the values.
		 */
		public static function Decode ($str) {
			
			$retr=new \stdClass();
			$kvps=explode('&',$str);
			foreach ($kvps as $str) {
				
				$pair=explode('=',$str,2);
				if (count($pair)!==2) throw new \InvalidArgumentException(
					sprintf(
						'"%s" does not contain "="',
						$str
					)
				);
				
				$key=urldecode($pair[0]);
				$value=urldecode($pair[1]);
				
				if (!isset($retr->$key)) {
					
					$retr->$key=$value;
					
					continue;
					
				}
				
				if (!is_array($retr->$key)) $retr->$key=array($retr->$key);
				
				$arr=$retr->$key;
				$arr[]=$value;
				$retr->$key=$arr;
			
			}
			
			return $retr;
			
		}
		
		
		private static function encode_impl ($key, $value) {
			
			return sprintf(
				'%s=%s',
				rawurlencode($key),
				rawurlencode($value)
			);
			
		}
		
		
		/**
		 *	Encodes anything which may be iterator to yield key/value
		 *	pairs into an HTML form.
		 *
		 *	\param [in] $obj
		 *		An object which may be iterated yielding key/value pairs.
		 *
		 *	\return
		 *		A string containing the HTML form representation of
		 *		\em obj.
		 */
		public static function Encode ($obj) {
			
			$str='';
			foreach ($obj as $key=>$value) {
				
				if ($str!=='') $str.='&';
				
				if (is_array($value)) foreach ($value as $v) $str.=self::encode_impl($key,$v);
				else $str.=self::encode_impl($key,$value);
				
			}
			
			return $str;
			
		}
		
		
	}


?>