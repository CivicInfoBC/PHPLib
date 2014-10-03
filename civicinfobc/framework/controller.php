<?php


	namespace CivicInfoBC\Framework;
	
	
	/**
	 *	An interface which controllers which handle requests to a
	 *	web application shall implement.
	 */
	interface Controller {
		
		
		/**
		 *	When implemented in a derived class, handles a request.
		 *
		 *	\param [in] $request
		 *		A request object which encapsulates this request.
		 *	\param [in] $response
		 *		A response object which this controller may use to
		 *		manipulate the response.
		 */
		function Execute (Request $request, Response $response);
	
	
	}


?>