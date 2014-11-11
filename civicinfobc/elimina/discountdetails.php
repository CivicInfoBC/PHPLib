<?php


	namespace CivicInfoBC\EliMina;
	
	
	class DiscountDetails {
	
	
		/**
		 *	A string describing the discount.
		 */
		public $description;
		/**
		 *	The amount of the discount.
		 */
		public $amount;
		
		
		/**
		 *	Creates a new DiscountDetails.
		 *
		 *	\param [in] $description
		 *		A string which describes the discount.
		 *	\param [in] $amount
		 *		The number of dollars the discount is for.
		 */
		public function __construct ($description, $amount) {
		
			$this->description=$description;
			$this->amount=$amount;
		
		}
	
	
	}


?>