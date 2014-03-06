<?php


	namespace CivicInfoBC\MySQL;
	
	
	/**
	 *	Encapsulates a piece of text that shouldn't be
	 *	escaped before being inserted into a SQL query.
	 */
	class Literal {
	
	
		private $text;
		
		
		/**
		 *	Creates a new MySQL literal.
		 *
		 *	\param [in] $text
		 *		The text to insert into the query without
		 *		escaping.
		 */
		public function __construct ($text) {
		
			$this->text=$text;
		
		}
		
		
		/**
		 *	Retrieves the string.
		 *
		 *	\return
		 *		The escapsulated string.
		 */
		public function __toString () {
		
			return $this->text;
		
		}
	
	
	}


?>