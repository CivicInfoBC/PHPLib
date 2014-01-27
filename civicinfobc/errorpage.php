<?php


	namespace CivicInfoBC;
	
	
	class ErrorPage {
	
	
		public $ip_blacklist=array();
		public $status_blacklist=array();
		public $html_template;
		public $mail_template;
		public $mail;
		
		
		private function mail ($ex) {
		
			if (
				//	If there's no mail template, we
				//	can't send mail
				is_null($this->mail_template) ||
				//	If there's no mail object, we can't
				//	send mail
				is_null($this->mail) ||
				//	If there's no one to send to, we don't
				//	send
				(count($this->mail->to)===0) ||
				//	If we've been told not to send e-mails
				//	for this IP, don't
				in_array(
					Server::Get('REMOTE_ADDR'),
					$this->ip_blacklist,
					true
				) ||
				//	If we've been told not to send e-mails for
				//	this particular HTTP status code, don't
				in_array(
					$ex->getCode(),
					$this->status_blacklist,
					true
				)
			) return;
			
			//	Load the exception into the mail template
			$this->mail_template->ex=$ex;
			
			//	Generate a subject if one does not already-
			//	exist
			if (is_null($this->mail->subject)) $this->mail->subject=sprintf(
				'%s: Error in script %s',
				Server::Get('COMPUTERNAME'),
				Server::Get('SCRIPT_FILENAME')
			);
			
			//	Send email and ignore exceptions
			try {
			
				$this->mail->Send($this->mail_template);
				
			} catch (\Exception $e) {	}
		
		}
		
		
		private function render ($ex) {
		
			//	If there's no HTML template, we can't render
			if (is_null($this->html_template)) return;
			
			//	Load the exception into the HTML template
			$this->html_template->ex=$ex;
			
			//	Render
			$this->html_template->Render();
		
		}
		
		
		private function handle ($ex) {
		
			//	If what we were passed wasn't an exception,
			//	make it one
			if (!($ex instanceof \Exception)) $ex=new \Exception($ex);
		
			//	If the thrown exception was not an HTTP
			//	status exception, wrap it in one
			if (!($ex instanceof HTTPStatus)) $ex=new HTTPStatus(
				HTTPStatus::SERVER_ERROR,
				$ex
			);
			
			//	Send the headers
			$ex->Send();
			
			//	If the thrown exception was just a redirect,
			//	that's not actually an error, so skip further
			//	processing
			if ($ex instanceof Redirect) return;
			
			//	Send mail if appropriate
			$this->mail($ex);
			
			//	Output HTML
			$this->render($ex);
		
		}
		
		
		public function Panic ($ex) {
		
			//	Just make sure we don't throw
			try {
			
				$this->handle($ex);
			
			} catch (\Exception $e) {	}
			
			//	END
			exit();
		
		}
		
		
		public function Guard ($callback) {
		
			ob_start();
		
			try {
			
				$callback();
				
			} catch (\Exception $e) {
			
				ob_end_clean();
			
				$this->Panic($e);
			
			}
			
			ob_end_flush();
		
		}
	
	
	}


?>