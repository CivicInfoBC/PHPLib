<?php


	namespace CivicInfoBC\Framework;
	
	
	/**
	 *	Encapsulates an HTTP response.
	 */
	abstract class Response {
	
	
		/**
		 *	When overriden in a derived class, writes a string to the
		 *	response.
		 *
		 *	\param [in] $str
		 *		The string.
		 */
		abstract protected function WriteImpl ($str);
		/**
		 *	When overriden in a derived class, renders a Renderable to
		 *	the response.
		 *
		 *	\param [in] $render
		 *		The Renderable
		 */
		abstract protected function RenderImpl (\CivicInfoBC\Renderable $render);
		
		
		private function write_impl (array $arr) {
		
			foreach ($arr as $x) {
			
				if (is_array($x)) {
				
					$this->write_impl($x);
					
					continue;
				
				}
				
				if ($x instanceof \CivicInfoBC\Renderable) $this->RenderImpl($x);
				else $this->WriteImpl($x);
			
			}
		
		}
	
	
		/**
		 *	When overriden in a derived class, sets the status code for the
		 *	response.
		 *
		 *	\param [in] $status
		 *		The status code.
		 */
		abstract public function Status ($status);
	
	
		/**
		 *	When overriden in a derived class, specifies a header for the
		 *	response.
		 *
		 *	\param [in] $key
		 *		The name of the header.
		 *	\param [in] $value
		 *		The value to associate weth \em key.
		 *	\param [in] $replace
		 *		\em true to replace any existing headers with key
		 *		\em key, \em false otherwise.  Defaults to \em true.
		 */
		abstract public function Header ($key, $value, $replace=true);
		
		
		/**
		 *	When overriden in a derived class, sends a cookie.
		 *
		 *	\param [in] $key
		 *		The name of the cookie.
		 *	\param [in] $value
		 *		The value of the cookie.
		 *	\param [in] $expiry
		 *		When the cookie expires.  If null the cookie will
		 *		expire at the end of the session (i.e. when the browser
		 *		is closed).
		 *	\param [in] $path
		 *		The path under which the cookie shall be available.
		 *	\param [in] $domain
		 *		The domain under which the cookie shall be available.
		 *	\param [in] $secure
		 *		\em true if the cookie should only be transmitted over
		 *		HTTPS, \em false otherwise.
		 *	\param [in] $httponly
		 *		\em true if the cookie should only be available over
		 *		HTTP, rather than also being available to JavaScript,
		 *		\em false otherwise.
		 */
		abstract public function Cookie ($key, $value, \DateTime $expiry=null, $path=null, $domain=null, $secure=false, $httponly=false);
		
		
		/**
		 *	When overriden in a derived class, stringifies all arguments
		 *	and writes them to the response.
		 *
		 *	If any of the arguments (with arrays expanded recursively) is
		 *	Renderable, it will be rendered.
		 */
		public function Write () {
		
			$this->write_impl(func_get_args());
		
		}
	
	
	}


?>