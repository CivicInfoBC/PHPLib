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
		 *	Either the carbon copied recipient of the
		 *	e-mail, or an array of recipients.
		 */
		public $cc;
		/**
		 *	Either the blind carbon copied recipient of
		 *	the e-mail, or an array of recipients.
		 */
		public $bcc;
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
		
		
		private function get_array ($str, $arr) {
			
			foreach (ArrayUtil::Coalesce($arr) as $x) {
			
				if ($str!=='') $str.=',';
				
				$str.=$x;
			
			}
			
			return $str;
		
		}
		
		
		private function get_to ($message) {
		
			$retr='';
			
			$retr=self::get_array($retr,$this->to);
			$retr=self::get_array($retr,$this->cc);
			$retr=self::get_array($retr,$this->bcc);
			
			return $retr;
		
		}
		
		
		private static function get_header ($key, $value) {
		
			$value=ArrayUtil::Coalesce($value);
			
			if (count($value)===0) return '';
			
			$retr=$key.':';
			
			$first=true;
			foreach ($value as $x) {
			
				if ($first) $first=false;
				else $retr.=',';
				
				$retr.=$x;
			
			}
			
			$retr.="\r\n";
			
			return $retr;
		
		}
		
		
		private static function cmp ($a, $b) {
		
			return StringUtil::Equals(
				StringUtil::ToLower($a),
				StringUtil::ToLower($b)
			);
		
		}
		
		
		private function get_headers () {
		
			$headers='';
			foreach ($this->headers as $key=>$value) $headers.=self::get_header($key,$value);
			
			$k=array_keys($this->headers);
			
			if (!ArrayUtil::In($k,'From')) $headers.=self::get_header('From',$this->from);
			
			if (!ArrayUtil::In($k,'To')) $headers.=self::get_header('To',$this->to);
			
			if (!ArrayUtil::In($k,'CC')) $headers.=self::get_header('CC',$this->cc);
			
			if (!ArrayUtil::In($k,'BCC')) $headers.=self::get_header('BCC',$this->bcc);
			
			if (!ArrayUtil::In($k,'Content-Type')) $headers.=self::get_header(
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