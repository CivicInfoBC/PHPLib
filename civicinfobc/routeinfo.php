<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Information about a route.
	 */
	class RouteInfo {
	
	
		/**
		 *	The controller this request should be
		 *	dispatched to.
		 */
		public $controller=null;
		/**
		 *	The arguments that should be passed to
		 *	that controller.
		 */
		public $arguments=array();
	
	
	}


?>