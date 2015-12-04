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
		
		
		/**
		 *	Gets all HTTP headers sent with this
		 *	request.
		 *
		 *	As HTTP headers are case insensitive,
		 *	they will all be transformed to lower
		 *	case before being returned.
		 *
		 *	\return
		 *		A StrictObject representing the
		 *		HTTP headers for this request.
		 */
		public static function GetHeaders () {
			
			$retr=array();
			foreach (self::$server as $key=>$value) {
			
				if (is_null($match=Regex::Match(
					'/^HTTP_(.*)$/u',
					$key
				))) continue;
				
				$retr[StringUtil::ToLower(
					Regex::Replace(
						'/_/u',
						'-',
						$match[1]
					)
				)]=$value;
			
			}
			
			return new StrictObject($retr);
		
		}
		
		
		/**
		 *	Gets the body of this request.
		 *
		 *	\return
		 *		A string containing the body of this
		 *		request.
		 */
		public static function GetBody () {
		
			//	Get the body of the request as a string,
			//	but what encoding is it in?
			if (($retr=Error::Wrap(function () {	return file_get_contents('php://input');	}))===false) Error::Raise();
			
			//	Convert to UTF-8
			$content_type=new HTTP\ContentType(null,null,'utf-8');
			return StringUtil::ConvertFrom($retr,$content_type->charset);
		
		}
	
	
	}
	
	
	Request::$get=new InputObject($_GET);
	Request::$post=new InputObject($_POST);
	Request::$server=new StrictObject($_SERVER);
	Request::$cookie=new InputObject($_COOKIE);


?>