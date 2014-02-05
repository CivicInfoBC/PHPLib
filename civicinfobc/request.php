<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains information about the current
	 *	request.
	 */
	class Request {
	
	
		/**
		 *	A StrictObject containing all query
		 *	string keys.
		 */
		static $get;
		/**
		 *	A StrictObject containing all POST
		 *	variables.
		 */
		static $post;
		/**
		 *	A StrictObject containirg all cookie
		 *	variables.
		 */
		static $cookie;
		
		
		/**
		 *	Determines whether or not the current
		 *	request is a POST.
		 *
		 *	\return
		 *		\em true if this request is a POST,
		 *		\em false otherwise.
		 */
		public static function IsPost () {
		
			return Server::Get('REQUEST_METHOD')==='POST';
		
		}
	
	
	}
	
	
	Request::$get=new StrictObject($_GET);
	Request::$post=new StrictObject($_POST);
	Request::$cookie=new StrictObject($_COOKIE);


?>