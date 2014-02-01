<?php


	namespace CivicInfoBC\CanadaPost;
	
	
	/**
	 *	Encapsulates a single shipping option.
	 */
	class Option {
	
	
		/**
		 *	The Canada Post-specific option code.
		 */
		public $code;
		/**
		 *	Required for COV (i.e. coverage).  Indicates
		 *	the amount of insurance to be purchased.
		 */
		public $amount;
		
		
		public function __construct ($code, $amount=null) {
		
			$this->code=$code;
			$this->amount=$amount;
		
		}
		
		
		/**
		 *	Adds this option to an existing XML document
		 *	as a child of a certain XML node.
		 *
		 *	\param [in] $node
		 *		The XML node to which to add this option
		 *		as a child.
		 */
		public function Get (\DOMNode $node) {
		
			$doc=$node->ownerDocument;
		
			$node->appendChild($option=$doc->createElement('option'));
			
			//	Option code
			$option->appendChild($doc->createElement('option-code',$this->code));
			
			//	Option amount
			if (!is_null($this->amount)) $option->appendChild($doc->createElement('option-amount',
				is_float($this->amount)
					?	sprintf('%.2f',$this->amount)
					:	$this->amount
			));
		
		}
		
		
		/**
		 *	Adds an array of options as children of a
		 *	certain XML node.
		 *
		 *	\param [in] $arr
		 *		The array of options to add.
		 *	\param [in] $node
		 *		The XML node to which to add the options
		 *		in \em arr as children.
		 */
		public static function GetArray (array $arr, \DOMNode $node) {
		
			//	Do nothing if there are no elements
			if (count($arr)===0) return;
			
			$options=$node->appendChild($node->ownerDocument->createElement('options'));
			
			foreach ($arr as $option) $option->Get($options);
		
		}
	
	
	}


?>