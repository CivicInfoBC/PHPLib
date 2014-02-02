<?php


	namespace CivicInfoBC\CanadaPost;
	
	
	/**
	 *	Encapsulates a single shipping quote.
	 */
	class Quote {
	
	
		/**
		 *	The code associated with this service.
		 */
		public $service;
		/**
		 *	An endpoint for this service.
		 */
		public $link;
		/**
		 *	The human-readable name of the service.
		 */
		public $service_name;
		/**
		 *	Contains a PriceDetails object.
		 */
		public $price_details;
		/**
		 *	The weight in kilograms of the package used
		 *	in rate calculations based on standard
		 *	density.
		 */
		public $cubed_weight;
		/**
		 *	Contains a ServiceStandard object if provided,
		 *	otherwise is \em null.
		 */
		public $service_standard;
	
	
		public static function FromXML (\DOMNode $node) {
		
			$node=new \CivicInfoBC\DOMWrapper($node);
			
			$retr=new self();
			$retr->service=$node->{'service-code'}->textContent;
			$retr->link=Endpoint::FromXML($node->{'service-link'});
			$retr->service_name=$node->{'service-name'}->textContent;
			$retr->price_details=PriceDetails::FromXML($node->{'price-details'});
			$weight_details=new \CivicInfoBC\DOMWrapper($node->{'weight-details'});
			if (!is_null(
				$cubed_weight=$weight_details->GetChild('cubed-weight')
			)) $retr->cubed_weight=\CivicInfoBC\Convert::ToIntegerOrThrow($cubed_weight->textContent);
			$retr->service_standard=ServiceStandard::FromXML($node->{'service-standard'});
			
			return $retr;
		
		}
	
	
	}


?>