<?php


	namespace CivicInfoBC\MySQL;
	
	
	/**
	 *	Specifies the endpoint to which a Connection
	 *	should connect.
	 */
	class Endpoint {
	
	
		/**
		 *	The username to use.
		 */
		public $username;
		/**
		 *	The password to use.
		 */
		public $password;
		/**
		 *	The host to which to connect.
		 */
		public $host;
		/**
		 *	The port on which to connect to
		 *	\em host.
		 */
		public $port;
		/**
		 *	The default database to be set for
		 *	the connection.
		 */
		public $database='';
	
	
		public function __construct () {
		
			$this->username=ini_get('mysqli.default_user');
			$this->password=ini_get('mysqli.default_pw');
			$this->host=ini_get('mysqli.default_host');
			$this->port=ini_get('mysqli.default_port');
		
		}
	
	
	};


?>