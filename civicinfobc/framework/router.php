<?php


	namespace CivicInfoBC\Framework;
	
	
	/**
	 *	Provides table-based routing.
	 */
	class Router extends \CivicInfoBC\Router {
	
	
		private $args;
		private $default;
		private $table;
		
		
		/**
		 *	Creates a new Router.
		 *
		 *	\param [in] $root
		 *		The URI of the root of the application.
		 *	\param [in] $table
		 *		An associative array which maps route names to
		 *		callable objects which return controllers associated
		 *		with those names.
		 *	\param [in] $default
		 *		A callable object which returns a default controller,
		 *		which will be used where no route is specified or found.
		 *		If \em null no default route will be used.  Defaults to
		 *		\em null.
		 *	\param [in] $args
		 *		An array of arguments which will be passed through to all
		 *		callable objects this object invokes.  Defaults to an empty
		 *		array.
		 *		
		 */
		public function __construct ($root='', array $table, $default=null, array $args=array()) {
		
			parent::__construct($root);
		
			$this->default=$default;
			$this->table=$table;
			$this->args=$args;
		
		}
		
		
		private function invoke ($callable) {
		
			return call_user_func_array($callable,$this->args);
		
		}
		
		
		private function lookup ($controller) {
		
			if (
				is_null($controller) ||
				!isset($this->table[$controller])
			) return null;
			
			return $this->invoke($this->table[$controller]);
		
		}
		
		
		private static function not_found () {
		
			throw new \CivicInfoBC\HTTP\Status(\CivicInfoBC\HTTP\Status::NOT_FOUND);
		
		}
		
		
		public function Route (\CivicInfoBC\RouteInfo $info=null) {
		
			$controller=$this->lookup($info->controller);
			if (!is_null($controller)) return $controller;
			
			if (!is_null($info->controller)) {
			
				array_unshift($info->arguments,$info->controller);
				
				$info->controller=null;
			
			}
			
			if (is_null($this->default)) self::not_found();
			
			$controller=$this->invoke($this->default);
			
			if (is_null($controller)) self::not_found();
			
			return $controller;
		
		}
	
	
	}


?>