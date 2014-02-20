<?php


	namespace CivicInfoBC\EXact;
	
	
	/**
	 *	An E-Xact hosted checkout.
	 */
	class HostedCheckout {
	
	
		/**
		 *	The login terminal associated with this
		 *	hosted checkout.
		 */
		public $login_terminal;
		/**
		 *	The transaction key associated with this
		 *	hosted checkout.
		 */
		public $transaction_key;
		/**
		 *	The response key associated with this
		 *	hosted checkout.
		 */
		public $response_key;
		/**
		 *	The URL to which forms based on this
		 *	hosted checkout shall send their requests.
		 *
		 *	Defaults to \"https://checkout.e-xact.com/payment\".
		 */
		public $form_url='https://checkout.e-xact.com/payment';
		/**
		 *	The method forms based on this hosted chekcout
		 *	shall use to send their requests.
		 *
		 *	Defaults to \"POST\".
		 */
		public $form_method='POST';
		
		
		/**
		 *	Creates a new hosted checkout.
		 *
		 *	\param [in] $login_terminal
		 *		The login terminal.
		 *	\param [in] $transaction_key
		 *		The transaction key.
		 *	\param [in] $response_key
		 *		The response key.  Optional.
		 *		If not provided this object will
		 *		not be able to be used to verify.
		 */
		public function __construct ($login_terminal, $transaction_key, $response_key=null) {
		
			$this->login_terminal=$login_terminal;
			$this->transaction_key=$transaction_key;
			$this->response_key=$response_key;
		
		}
		
		
		/**
		 *	Verifies a hash.
		 *
		 *	\param [in] $hash
		 *		The hash to verify.
		 *	\param [in] $amount
		 *		The amount the transaction identified
		 *		by \em hash should be for.
		 *	\param [in] $id
		 *		The transaction ID.
		 *
		 *	\return
		 *		\em true if \em hash is verified,
		 *		\em false otherwise.
		 */
		public function Verify ($hash, $amount, $id) {
		
			if (is_null($this->response_key)) throw new \InvalidArgumentException('No response key');
		
			return md5($this->response_key.$this->login_terminal.$id.sprintf('%.2f',$amount))===$hash;
		
		}
	
	
	}


?>