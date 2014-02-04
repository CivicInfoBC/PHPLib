<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Routes requests to controllers based on the
	 *	URI of the request.
	 */
	class Router {
	
	
		private $root;
		private $default;
		private $base;
		private $namespace;
		
		
		/**
		 *	Creates a new router.
		 *
		 *	\param [in] $root
		 *		The URI of the root of the application
		 *		or site.  The components any incoming
		 *		URI shared with this URI will not be
		 *		considered in routing.
		 *	\param [in] $default
		 *		The name of a default controller to
		 *		use in case an incoming URI does not
		 *		specify a controller, or the controller
		 *		an incoming URI specifies does not exist.
		 *	\param [in] $base
		 *		The base class controller objects must
		 *		subclass to be valid controllers.  If \em null
		 *		any class will be acceptable.  Note that leaving
		 *		this \em null can expose you to security
		 *		vulnerabilities and random crashes.
		 *	\param [in] $namespace
		 *		The namespace the router should look in for
		 *		controllers.
		 */
		public function __construct ($root='', $default='', $base=null, $namespace='\\') {
		
			$this->root=$root;
			$this->default=$default;
			$this->base=$base;
			$this->namespace=Regex::Replace(
				'/(?<!\\\\)$/u',
				'\\',
				$namespace
			);
		
		}
		
		
		private static function get_components ($uri) {
		
			$arr=Regex::Split(
				'/\\//u',
				Regex::Replace(
					'/^\\//u',
					'',
					Regex::Replace(
						'/\\/$/u',
						'',
						is_null($uri) ? Server::GetPath() : $uri
					)
				)
			);
			
			foreach ($arr as $x=>$y) if ($y==='') unset($arr[$x]);
			
			return $arr;
		
		}
		
		
		/**
		 *	Gets a route for a URI.
		 *
		 *	\param [in] $uri
		 *		The URI to route.
		 *
		 *	\return
		 *		A RouteInfo object containing
		 *		information about the chosen
		 *		route.
		 */
		public function Get ($uri=null) {
		
			//	Count the components of the base,
			//	they'll be skipped
			$skip=count(self::get_components($this->root));
			
			//	Get the components of the url
			$components=self::get_components($uri);
			
			//	Parse out the components
			$retr=new RouteInfo();
			for ($i=$skip;$i<count($components);++$i) {
			
				if (is_null($retr->controller)) $retr->controller=$components[$i];
				else $retr->arguments[]=$components[$i];
			
			}
			
			return $retr;
		
		}
		
		
		/**
		 *	Gets a controller for a route.
		 *
		 *	Any extra arguments passed to this function
		 *	will be passed through to the constructor
		 *	of the chosen controller.
		 *
		 *	\param [in] $info
		 *		A RouteInfo to use to find the
		 *		controller.
		 *
		 *	\return
		 *		An instance of the controller chosen
		 *		based on the route.
		 */
		public function Route (RouteInfo $info=null) {
		
			if (is_null($info)) $info=new RouteInfo();
		
			//	Loop until either we conclude that
			//	there's no available controller,
			//	or we find one
			$tried_default=false;
			while (
				is_null($info->controller) ||
				!class_exists($info->controller=$this->namespace.$info->controller)
			) {
			
				//	Can we try the default?
				if ($tried_default) throw new HTTP\Status(HTTP\Status::NOT_FOUND);
				
				//	YES
				
				//	Make the controller one of the arguments
				array_unshift(
					$info->arguments,
					$info->controller
				);
				$info->controller=$this->default;
				$tried_default=true;
			
			}
			
			//	We have a controller
			
			//	Does the controller class properly
			//	inherit from base, if a base is
			//	given?
			if (!(
				is_null($this->base) ||
				is_subclass_of(
					$info->controller,
					$this->base
				)
			)) throw new HTTP\Status(HTTP\Status::NOT_FOUND);
			
			//	The controller is good, create
			//	one
			$args=func_get_args();
			unset($args[0]);
			$ref=new \ReflectionClass($info->controller);
			return $ref->newInstanceArgs($args);
		
		}
	
	
	}


?>