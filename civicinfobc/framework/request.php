<?php


	namespace CivicInfoBC\Framework;
	
	
	/**
	 *	Encapsulates a request to a controller.
	 */
	abstract class Request {
	
	
		/**
		 *	Retrieves an array of arguments associated with this
		 *	request.
		 *
		 *	\return
		 *		An array of arguments.
		 */
		abstract public function Arguments ();
		
		
		/**
		 *	Retrieves the raw body of the request.
		 *
		 *	\return
		 *		The body of the request as a string.
		 */
		abstract public function Body ();
		
		
		/**
		 *	Retrieves the IP from which the request is being made.
		 *
		 *	\return
		 *		A string containing the IP address from which the
		 *		request is being made.
		 */
		abstract public function IP ();
		
		
		/**
		 *	Retrieves a string giving the type of method this
		 *	object represents.
		 *
		 *	\return
		 *		An all upper case string giving the HTTP method
		 *		used to make this request.
		 */
		abstract public function Method ();
		
		
		/**
		 *	Retrieves the URL for which this request was made.
		 *
		 *	\return
		 *		The URL.
		 */
		abstract public function URL ();
		
		
		/**
		 *	Retrieves a query string parameter or some default if
		 *	the query string parameter-in-question does not exist.
		 *
		 *	\param [in] $key
		 *		The key of the query string parameter to retrieve.
		 *	\param [in] $default
		 *		The default value to retrieve if no value is associated
		 *		with \em key.  Defaults to \em null.
		 *
		 *	\return
		 *		The retrieved value.
		 */
		abstract public function Get ($key, $default=null);
		
		
		/**
		 *	Retrieves a cookie or some default if the cookie-in-question
		 *	does not exist.
		 *
		 *	\param [in] $key
		 *		The name of the cookie to retrieve.
		 *	\param [in] $default
		 *		The default value to retrieve if no value is associated
		 *		with \em key.  Defaults to \em null.
		 *
		 *	\return
		 *		The retrieved value.
		 */
		abstract public function Cookie ($key, $default=null);
		
		
		/**
		 *	Retrieves a form value or some default if the form value-in-question
		 *	does not exist.
		 *
		 *	\param [in] $key
		 *		The name of the value to retrieve.
		 *	\param [in] $default
		 *		The default value to retrieve if no value is associated
		 *		with \em key.  Defaults to \em null.
		 *
		 *	\return
		 *		The retrieved value.
		 */
		abstract public function Post ($key, $default=null);
	
	
	}


?>