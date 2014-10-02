<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Handles errors by displaying a page to the user.
	 */
	class ErrorPage extends ErrorHandlerDecorator {
	
	
		private $render;
		
		
		/**
		 *	IPs for which error e-mails shall not be generated.
		 *
		 *	This field is for legacy support and should not be
		 *	used for new development.
		 */
		public $ip_blacklist=array();
		/**
		 *	HTTP status codes for which error e-mails should not
		 *	be generated.
		 *
		 *	This field is for legacy support and should not be used
		 *	for new development.
		 */
		public $status_blacklist=array();
		/**
		 *	The template to use to create an error page, or \em null
		 *	if no error page should be created.
		 *
		 *	This field is for legacy support and should not be used
		 *	for new development.
		 */
		public $html_template;
		/**
		 *	The template to use to create an e-mail, or \em null if
		 *	no e-mail should be sent.
		 *
		 *	This field is for legacy support and should not be used
		 *	for new development.
		 */
		public $mail_template;
		/**
		 *	The EMail item to use to send an e-mail, or \em null if no
		 *	e-mail should be sent.
		 *
		 *	This field is for legacy support and should not be used
		 *	for new development.
		 */
		public $mail;
		
		
		private function is_mail (\Exception $ex) {
		
			if (
				is_null($this->mail) ||
				is_null($this->mail_template) ||
				(count($this->mail->to)===0) ||
				in_array(
					Server::Get('REMOTE_ADDR'),
					$this->ip_blacklist,
					true
				)
			) return false;
			
			if (!($ex instanceof HTTP\Status)) $ex=new HTTP\Status(HTTP\Status::SERVER_ERROR,$ex);
			
			return !in_array(
				$ex->getCode(),
				$this->status_blacklist,
				true
			);
		
		}
		
		
		private function handle (\Exception $ex) {
		
			$stack=new ErrorHandler();
			
			if (!is_null($this->html_template)) $stack=new self($this->html_template,$stack);
			
			if ($this->is_mail($ex)) $stack=new ErrorEMail($this->mail,$this->mail_template,$stack);
			
			$stack=new ErrorHeader($stack);
			
			$stack->Panic($ex);
		
		}
		
		
		private function legacy (\Exception $ex) {
		
			try {
			
				$this->handle($ex);
			
			} catch (\Exception $e) {	}
			
			exit();
		
		}
		
		
		/**
		 *	Creates a new ErrorPage object.
		 *
		 *	If the first parameter is \em null (or defaulted), this object
		 *	will operate in legacy mode.  This behaviour should not be used
		 *	for new development.
		 *
		 *	\param [in] $render
		 *		The object to render when an error occurs.  If this
		 *		object implements \em Renderable its \em Render method
		 *		will be called, otherwise it will be converted to a string
		 *		and echoed.  If an object its \em ex property will be set to
		 *		the triggering exception before rendering/stringification.
		 *	\param [in] $inner
		 *		An inner ErrorHandler to decorate.  If \em null no ErrorHandler
		 *		will be decorated.
		 */
		public function __construct ($render=null, ErrorHandler $inner=null) {
		
			parent::__construct($inner);
		
			$this->render=$render;
		
		}
		
		
		public function Panic (\Exception $ex) {
		
			//	Shim for legacy support
			if (is_null($this->render)) {
			
				$this->legacy($ex);
			
				return;
			
			}
		
			try {
			
				if (is_object($this->render)) $this->render->ex=$ex;
				
				if ($this->render instanceof Renderable) $this->render->Render();
				else echo($this->render);
			
			} catch (\Exception $e) {	}
			
			parent::Panic($ex);
		
		}
	
	
	}


?>