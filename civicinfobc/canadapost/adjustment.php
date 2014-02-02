<?php


	namespace CivicInfoBC\CanadaPost;
	
	
	/**
	 *	The details of a single adjustment to
	 *	a price.
	 */
	class Adjustment {
	
	
		/**
		 *	A code identifying the adjustment.
		 */
		public $code;
		/**
		 *	A human-readable name identifying the
		 *	adjustment.
		 */
		public $name;
		/**
		 *	The cost of the adjustment.
		 */
		public $cost;
		/**
		 *	If the adjustment is based on a percentage,
		 *	that percentage.  \em null otherwise.
		 */
		public $percentage;
		
		
		private static function from_xml (\DOMElement $node) {
		
			$node=new \CivicInfoBC\DOMWrapper($node);
			
			$retr=new self();
			$retr->code=$node->{'adjustment-code'}->textContent;
			$retr->name=$node->{'adjustment-name'}->textContent;
			$retr->cost=\CivicInfoBC\Convert::ToFloatOrThrow($node->{'adjustment-cost'}->textContent);
			if (!is_null(
				$qualifier=$node->GetChild('qualifier')
			)) {
			
				$qualifier=new \CivicInfoBC\DOMWrapper($qualifier);
				$retr->percentage=\CivicInfoBC\Convert::ToFloatOrThrow($qualifier->percent->textContent);
			
			}
			
			return $retr;
		
		}
		
		
		public static function FromXML (\DOMNode $node=null) {
		
			$retr=array();
		
			if (is_null($node)) return $retr;
			
			$node=new \CivicInfoBC\DOMWrapper($node,'adjustment');
			foreach ($node as $child) $retr[]=self::from_xml($child);
			
			return $retr;
		
		}
	
	
	}


?>