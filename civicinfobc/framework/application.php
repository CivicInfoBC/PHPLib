<?php


	namespace CivicInfoBC\Framework;
	
	
	/**
	 *	Represents a web application.
	 */
	class Application {
	
	
		private $router;
		private $error;
		
		
		/**
		 *	Creates a new application.
		 *
		 *	\param [in] $router
		 *		The router which shall be used to route
		 *		requests.
		 *	\param [in] $error
		 *		The error handler which shall be invoked when
		 *		an exception is caught.
		 */
		public function __construct (\CivicInfoBC\Router $router, \CivicInfoBC\ErrorHandler $error) {
		
			$this->router=$router;
			$this->error=$error;
		
		}
		
		
		private function execute_impl () {
		
			$route=$this->router->Get();
			$controller=$this->router->Route($route);
			
			$response=new HTTPResponse();
			$controller->Execute(new HTTPRequest($route->arguments),$response);
			
			$response->Send();
		
		}
		
		
		/**
		 *	Dispatches the current request.
		 */
		public function Execute () {
		
			$ob=new \CivicInfoBC\OutputBuffer();
			
			try {
			
				$this->execute_impl();
			
			} catch (\Exception $e) {
			
				$ob=null;
				
				$this->error->Panic($e);
			
			}
			
			$ob->Flush();
		
		}
	
	
	}


?>