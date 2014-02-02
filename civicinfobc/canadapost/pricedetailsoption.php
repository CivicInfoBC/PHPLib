<?php


	namespace CivicInfoBC\CanadaPost;
	
	
	/**
	 *	Contains details about a single option.
	 */
	class PriceDetailsOption {
	
	
		/**
		 *	The unique code for this option.
		 */
		public $code;
		/**
		 *	A human-readable name for this option.
		 */
		public $name;
		/**
		 *	The cost of this option.
		 */
		public $price;
		/**
		 *	Additional details if available.  If
		 *	unavailable this field will be \em null.
		 */
		public $qualifier;
		
		
		private static function from_xml (\DOMElement $node) {
		
			$node=new \CivicInfoBC\DOMWrapper($node);
		
			$retr=new self();
			$retr->code=$node->{'option-code'}->textContent;
			$retr->name=$node->{'option-name'}->textContent;
			$retr->price=\CivicInfoBC\Convert::ToFloatOrThrow($node->{'option-price'}->textContent);
			$retr->qualifier=PriceDetailsOptionQualifier::FromXML($node->GetChild('qualifier'));
			
			return $retr;
		
		}
		
		
		public static function FromXML (\DOMNode $node=null) {
		
			$retr=array();
		
			if (is_null($node)) return $retr;
			
			$node=new \CivicInfoBC\DOMWrapper($node,'option');
			foreach ($node as $child) $retr[]=self::from_xml($child);
			
			return $retr;
		
		}
	
	
	}


?>