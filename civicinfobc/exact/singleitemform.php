<?php


	namespace CivicInfoBC\EXact;
	
	
	/**
	 *	A form for redirecting users to pay using
	 *	E-Xact hosted checkout, which only encapsulates
	 *	a single item.
	 */
	class SingleItemForm extends Form {
	
	
		/**
		 *	The type of item being encapsulated.
		 */
		public $type;
		/**
		 *	\em true if the item is taxable, \em false
		 *	otherwise.
		 *
		 *	Defaults to \em false.
		 */
		public $taxable=false;
		
		
		public function Get () {
		
			$retr=parent::Get();
			
			$this->AddLineItem(
				1,
				$this->type,
				$this->description,
				1,
				$this->amount,
				$this->taxable ? 'YES' : 'NO'
			);
			
			return $retr;
		
		}
	
	
	}


?>