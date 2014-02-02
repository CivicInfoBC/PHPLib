<?php


	namespace CivicInfoBC\CanadaPost;
	
	
	/**
	 *	Contains additional details about a
	 *	PriceDetailsOption object.
	 */
	class PriceDetailsOptionQualifier {
	
	
		/**
		 *	The step size for additional step
		 *	pricing.
		 */
		public $step_size;
		/**
		 *	The cost for a step size.
		 */
		public $step_cost;
		/**
		 *	How much is covered by base service.
		 */
		public $included_amount;
		/**
		 *	The maximum option amount.
		 */
		public $max;
		/**
		 *	Indicates that the option is included at
		 *	no charge.
		 */
		public $included;
		/**
		 *	If this option is based on a percentage
		 *	value the percentage, \em null otherwise.
		 */
		public $percentage;
		
		
		private static function get_float (\DOMElement $node=null) {
		
			return is_null($node) ? null : \CivicInfoBC\Convert::ToFloatOrThrow($node->textContent);
		
		}
	
	
		public static function FromXML (\DOMNode $node) {
			
			$node=new \CivicInfoBC\DOMWrapper($node);
			
			$retr=new self();
			$retr->step_size=self::get_float($node->GetChild('step-size'));
			$retr->step_cost=self::get_float($node->GetChild('step-cost'));
			$retr->included_amount=self::get_float($node->GetChild('included-amount'));
			$retr->max=self::get_float($node->GetChild('max-value'));
			if (!is_null(
				$included=$node->GetChild('included')
			)) $retr->included=\CivicInfoBC\Convert::ToBooleanOrThrow($included->textContent);
			$retr->percentage=self::get_float($node->GetChild('percent'));
			
			return $retr;		
		}
	
	
	}


?>