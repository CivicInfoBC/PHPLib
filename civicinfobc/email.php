<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Sends e-mail messages.
	 */
	class EMail {
	
	
		/**
		 *	Either the recipient of the e-mail, or
		 *	an array of recipients.
		 */
		public $to;
		/**
		 *	The sender of the e-mail.
		 */
		public $from;
		/**
		 *	\em true if the e-mail will be HTML.
		 *	Defaults to \em false.
		 */
		public $is_html=false;
		/**
		 *	The subject of the e-mail.
		 */
		public $subject;
		/**
		 *	Any additional e-mail headers as an
		 *	associative array.
		 */
		public $headers=array();
		
		
		private function get_to ($message) {
		
			if (is_array($this->to)) {
			
				$retr='';
				foreach ($this->to as $x) {
				
					if ($retr!=='') $retr.=',';
					
					$retr.=$x;
				
				}
				
				return $retr;
			
			}
			
			return $this->to;
		
		}
		
		
		private static function get_header ($key, $value) {
		
			return sprintf("%s:%s\r\n",$key,$value);
		
		}
		
		
		private static function cmp ($a, $b) {
		
			return String::Equals(
				String::ToLower($a),
				String::ToLower($b)
			);
		
		}
		
		
		private function get_headers () {
		
			$found_from=false;
			$found_content_type=false;
			$headers='';
			foreach ($this->headers as $key=>$value) {
			
				$headers.=self::get_header($key,$value);
				
				if (self::cmp($key,'from')) $found_from=true;
				else if (self::cmp($key,'content-type')) $found_content_type=true;
			
			}
			
			if (!($found_from || is_null($this->from))) $headers.=self::get_header(
				'From',
				$this->from
			);
			
			if (!$found_content_type && $this->is_html) $headers.=self::get_header(
				'Content-Type',
				'text/html; charset=utf-8'
			);
			
			return $headers;
		
		}
		
		
		/**
		 *	Sends an e-mail message.
		 *
		 *	\param [in] $message
		 *		The message to be sent.  May be
		 *		a template in which case it will be
		 *		rendered and the result of rendering
		 *		the template will be the body of the
		 *		message.  Any further arguments will be
		 *		passed through to the template.
		 */
		public function Send ($message) {
		
			//	Get the message body
			if ($message instanceof Template) {
			
				$args=func_get_args();
				unset($args[0]);
				$message=$message->Get($args);
			
			}
			
			//	Try and send mail
			if (@mb_send_mail(
				$this->get_to(),
				$this->subject,
				$message,
				$this->get_headers()
			)===false) Error::Raise();
		
		}
	
	
	}


?>