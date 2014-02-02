<?php


	namespace CivicInfoBC\CanadaPost;
	
	
	/**
	 *	Contains a detailed breakdown of the costs
	 *	for a shipment.
	 */
	class PriceDetails {
	
	
		/**
		 *	The base cost of the shipment before
		 *	taxes.
		 */
		public $base;
		/**
		 *	A collection of the taxes applied to
		 *	this shipment.
		 */
		public $taxes=array();
		/**
		 *	Total cost of this shipment including
		 *	the cost of selected or required options.
		 */
		public $due;
		/**
		 *	The selected options, in addition to free
		 *	options and the parcel characteristics of
		 *	mailing tube, unpackaged, or oversize if
		 *	selected or warranted by dimensions.
		 */
		public $options=array();
		/**
		 *	Details of adjustments to the price.
		 */
		public $adjustments=array();
		
		
		public static function FromXML (\DOMNode $node) {
		
			$node=new \CivicInfoBC\DOMWrapper($node);
			
			$retr=new self();
			$retr->base=\CivicInfoBC\Convert::ToFloatOrThrow($node->base->textContent);
			$retr->taxes=Tax::FromXML($node->GetChild('taxes'));
			$retr->due=\CivicInfoBC\Convert::ToFloatOrThrow($node->due->textContent);
			$retr->options=PriceDetailsOption::FromXML($node->GetChild('options'));

			$retr->adjustments=Adjustment::FromXML($node->GetChild('adjustments'));
			
			
			return $retr;
		
		}
	
	
	}


?>