<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains functions for cryptography.
	 */
	class Crypto {
		
		
		private static function get_capi () {
		
			if (class_exists('COM')) {
			
				//	If CAPICOM doesn't exist, the constructor
				//	throws, but that's okay so we just
				//	coalesce that to null
				try {
				
					return new \COM('CAPICOM.Utilities.1');
				
				} catch (\Exception $e) {	}
			
			}
			
			return null;
		
		}
	
	
		/**
		 *	Retrieves random bytes generated using a method
		 *	which makes them suitable for use in cryptography.
		 *
		 *	\param [in] $count
		 *		The number of bytes to generate.
		 *	\param [in] $raw
		 *		\em true if a raw string of bytes should be
		 *		returned.  \em false if a hexadecimal string
		 *		representation of the raw generated bytes
		 *		should be returned.  If \em false the returned
		 *		string will be twice \em count.  Defaults to
		 *		\em false.
		 *
		 *	\return
		 *		A string representing the random bytes.
		 */
		public static function Random ($count, $raw=false) {
		
			//	If no bytes were requested, return
			//	nothing
			if ($count===0) return '';
		
			//	Attempt to open /dev/urandom for
			//	Linux
			if (($file=@fopen('/dev/urandom','rb'))!==false) {
			
				//	Succeeded in opening /dev/urandom,
				//	read bytes
				
				$retr=@fread($file,$count);
				
				@fclose($file);
			
			//	Couldn't open /dev/urandom, maybe
			//	it's Windows?
			} else if (!is_null($capi=self::get_capi())) {
			
				$retr=$capi->GetRandom($count,0);
				$retr=base64_decode($retr);
			
			//	No CAPI, no /dev/urandom, is there at least
			//	OpenSSL?
			} else if (function_exists('openssl_random_pseudo_bytes')) {
			
				$retr=openssl_random_pseudo_bytes($count,$crypto_strong);
				if (!$crypto_strong) throw new \Exception('OpenSSL did not provide bytes suitable for use in cryptography');
			
			//	No cryptographically secure random number
			//	generator is available, throw
			} else {
			
				throw new \Exception('No cryptographically secure random number generator available');
			
			}
			
			//	Check to make sure we actually got
			//	bytes, and that we got enough
			if (!is_string($retr)) throw new \Exception('Failed to generate random bytes');
			if (($len=strlen($retr))!==$count) throw new \Exception(
				sprintf(
					'Generated incorrect number of random bytes (requested: %s, generated: %s)',
					$count,
					$len
				)
			);
			
			//	Convert to a string unless we're
			//	returning raw
			if (!$raw) {
			
				$retr=unpack('H*',$retr);
				$retr=$retr[1];
				
			}
			
			return $retr;
		
		}
	
	
	}


?>