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
		public static $get;
		/**
		 *	A StrictObject containing all POST
		 *	variables.
		 */
		public static $post;
		/**
		 *	A StrictObject containing all server
		 *	variables.
		 */
		public static $server;
		/**
		 *	A StrictObject containirg all cookie
		 *	variables.
		 */
		public static $cookie;
		
		
		/**
		 *	Determines whether or not the current
		 *	request is a POST.
		 *
		 *	\return
		 *		\em true if this request is a POST,
		 *		\em false otherwise.
		 */
		public static function IsPost () {
		
			return self::$server->Get('REQUEST_METHOD')==='POST';
		
		}
	
	
	}
	
	
	Request::$get=new StrictObject($_GET);
	Request::$post=new StrictObject($_POST);
	Request::$server=new StrictObject($_SERVER);
	Request::$cookie=new StrictObject($_COOKIE);


?>