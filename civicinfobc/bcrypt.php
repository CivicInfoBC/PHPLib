<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Implements the bcrypt password hashing scheme.
	 */
	class bcrypt {
	
	
		//	Number of rounds that will be performed.
		//
		//	The higher, the better the strength.
		private $rounds;
		
		
		/**
		 *	Creates a new bcrypt hasher.
		 *
		 *	\param [in] $rounds
		 *		The number of bcrypt rounds this
		 *		hasher will perform on passwords.
		 *		The higher the number of rounds,
		 *		the longer the operation takes, and
		 *		therefore the more resistant it is
		 *		to attack.
		 */
		public function __construct ($rounds=12) {
		
			if (CRYPT_BLOWFISH!==1) throw new \Exception('bcrypt not supported');
			
			$this->rounds=$rounds;
		
		}
		
		
		/**
		 *	Checks to see if a plain text password
		 *	matches some bcrypt hash.
		 *
		 *	\param [in] $plain_text
		 *		The password to check.
		 *	\param [in] $hash
		 *		The hash to check.
		 *
		 *	\return
		 *		\em true if \em plain_text hashes to
		 *		\em hash, \em false otherwise.
		 */
		public function Verify ($plain_text, $hash) {
		
			return crypt($plain_text,$hash)===$hash;
		
		}
		
		
		private function encode ($input) {
		
			// The following is code from the PHP Password Hashing Framework
			$itoa64='./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

			$output='';
			for ($i=0;;) {
			
				$c1=ord($input[$i++]);
				$output.=$itoa64[$c1>>2];
				$c1=($c1&0x03)<<4;
				if ($i>=16) {
				
					$output.=$itoa64[$c1];
					
					break;
				
				}

				$c2 = ord($input[$i++]);
				$c1|=$c2>>4;
				$output.=$itoa64[$c1];
				$c1=($c2&0x0f)<<2;

				$c2=ord($input[$i++]);
				$c1|=$c2>>6;
				$output.=$itoa64[$c1];
				$output.=$itoa64[$c2&0x3f];
			}

			return $output;
		
		}
		
		
		private function get_salt () {
		
			$retr=sprintf('$2a$%02d$',$this->rounds);
			$retr.=$this->encode(Crypto::Random(16,true));
			
			return $retr;
		
		}
		
		
		/**
		 *	Obtains a hash for a plain text password.
		 *
		 *	\param [in] $plain_text
		 *		The plain text password to hash.
		 *
		 *	\return
		 *		A bcrypt hash of \em plain_text.
		 */
		public function Hash ($plain_text) {
		
			return crypt($plain_text,$this->get_salt());
		
		}
	
	
	}


?>