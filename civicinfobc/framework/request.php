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
		 *		Passing \em null will cause a Traversable object to
		 *		be returned which traverses all query string parameters.
		 *		Defaults to \em null.
		 *	\param [in] $default
		 *		The default value to retrieve if no value is associated
		 *		with \em key.  Defaults to \em null.
		 *
		 *	\return
		 *		The retrieved value, or a Traversable if \em null was
		 *		passed as \em key.
		 */
		abstract public function Get ($key=null, $default=null);
		
		
		/**
		 *	Retrieves a cookie or some default if the cookie-in-question
		 *	does not exist.
		 *
		 *	\param [in] $key
		 *		The name of the cookie to retrieve.  Passing \em null
		 *		will cause a Traversable object to be returned which
		 *		traverses all cookies.  Defaults to \em null.
		 *	\param [in] $default
		 *		The default value to retrieve if no value is associated
		 *		with \em key.  Defaults to \em null.
		 *
		 *	\return
		 *		The retrieved value, or a Traversable if \em null was
		 *		passed as \em key.
		 */
		abstract public function Cookie ($key=null, $default=null);
		
		
		/**
		 *	Retrieves a form value or some default if the form value-in-question
		 *	does not exist.
		 *
		 *	\param [in] $key
		 *		The name of the value to retrieve.  Passing \em null
		 *		will cause a Traversable object to be returned which
		 *		traverses all form values.  Defaults to \em null.
		 *	\param [in] $default
		 *		The default value to retrieve if no value is associated
		 *		with \em key.  Defaults to \em null.
		 *
		 *	\return
		 *		The retrieved value, or a Traversable if \em null was passed
		 *		as \em key.
		 */
		abstract public function Post ($key=null, $default=null);
		
		
		/**
		 *	Retrieves an HTTP header's values or some default if the HTTP
		 *	header-in-question is not set.
		 *
		 *	\param [in] $key
		 *		The name of the HTTP header-in-question.  Passing \em null
		 *		will cause a Traversable object to be returned which
		 *		traverses all headers.  Defaults to \em null.
		 *	\param [in] $default
		 *		The default value to retrieve if no HTTP header \em key
		 *		was sent.  Defaults to \em null.
		 *
		 *	\return
		 *		The retrieved value, or a Traversable if \em null was passed
		 *		as \em key.
		 */
		abstract public function Header ($key=null, $default=null);
	
	
	}


?>