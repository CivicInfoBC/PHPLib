<?php


	namespace CivicInfoBC\CanadaPost;
	
	
	/**
	 *	Represents a tax applied to a price.
	 */
	class Tax {
	
	
		/**
		 *	The type of tax.  HST, GST, or PST.
		 */
		public $type;
		/**
		 *	The percentage.
		 */
		public $percentage;
		/**
		 *	The amount.
		 */
		public $amount;
		
		
		public static function FromXML (\DOMNode $node=null) {
		
			$retr=array();
		
			if (is_null($node)) return $retr;
		
			$node=new \CivicInfoBC\DOMWrapper($node);
			
			foreach ($node as $child) {
			
				//	For some reason the Canada Post XML API sends
				//	taxes that aren't relevant, with the "percent"
				//	attribute unset and the text content set to "0.00",
				//	even though the documentation
				//	(http://www.canadapost.ca/cpo/mc/business/productsservices/developers/services/rating/getrates/default.jsf)
				//	explicitly says "[w]ill not contain all three
				//	tax type elements at once".
				//
				//	Just skip these, they're noise.
				if (($amount=\CivicInfoBC\Convert::ToFloatOrThrow($child->textContent))===0.0) continue;
			
				$tax=new self();
				$tax->amount=$amount;
				$tax->type=\CivicInfoBC\StringUtil::ToUpper($child->tagName);
				$child=new \CivicInfoBC\DOMWrapper($child);
				$tax->percentage=\CivicInfoBC\Convert::ToFloatOrThrow($child['percent']);
				
				$retr[]=$tax;
			
			}
			
			return $retr;
		
		}
	
	
	}


?>