<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Provides an interface for objects which may be output as
	 *	HTML.
	 */
	interface Renderable {
	
	
		/**
		 *	When implemented in a derived class, renders the
		 *	object as HTML.
		 */
		public function Render ();
		
		
		/**
		 *	When implemented in a derived class, retrieves the
		 *	rendered HTML as a string.
		 *
		 *	\return
		 *		A string.
		 */
		public function Get ();
	
	
	};


?>