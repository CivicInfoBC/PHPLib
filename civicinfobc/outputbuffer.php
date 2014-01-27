<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Provides an RAII wrapper for an
	 *	output buffer.
	 */
	class OutputBuffer {
	
	
		/**
		 *	Starts output buffering.
		 */
		public function __construct () {
		
			ob_start();
		
		}
		
		
		/**
		 *	Ends output buffering.  Anything
		 *	in the buffer will be discarded.
		 */
		public function __destruct () {
		
			ob_end_clean();
		
		}
		
		
		/**
		 *	Flushes the buffer.
		 */
		public function Flush () {
		
			ob_flush();
		
		}
		
		
		/**
		 *	Cleans the buffer.
		 */
		public function Clean () {
		
			ob_clean();
		
		}
		
		
		/**
		 *	Gets the contents of the buffer as
		 *	a string.
		 *
		 *	Note that after calling this function,
		 *	the contents will still be in the buffer
		 *	until manually cleaned or flushed.
		 *
		 *	\return
		 *		A string containing the current
		 *		contents of the output buffer.
		 */
		public function Get () {
		
			return ob_get_contents();
		
		}
	
	
	}


?>