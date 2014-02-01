<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains utilities for working with base
	 *	64 encoded data.
	 */
	class Base64 {
	
	
		/**
		 *	Base64 encodes a given binary string.
		 *
		 *	\param [in] $data
		 *		The binary string to base64 encode.
		 *
		 *	\return
		 *		The base64 encoding of \em data.
		 */
		public static function Encode ($data) {
		
			if (($retr=base64_encode($data))===false) throw new \Exception('base64_encode returned error');
			
			return $retr;
		
		}
		
		
		/**
		 *	Decodes a base64 string, returning the
		 *	corresponding binary string.
		 *
		 *	\param [in] $data
		 *		The base64 string to decode.
		 *
		 *	\return
		 *		The binary string which results from
		 *		base64 decoding \em data.
		 */
		public static function Decode ($data) {
		
			//	Make sure there aren't invalid
			//	characters that PHP doesn't pick
			//	up in the base64 string
			if (Regex::IsMatch('/\\s/u',$data)) throw new \Exception('Invalid character in base64 string');
		
			if (($retr=base64_decode($data,true))===false) throw new \Exception('base64_decode returned error');
			
			return $retr;
		
		}
	
	
	}


?>