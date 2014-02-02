<?php


	namespace CivicInfoBC\CanadaPost;
	
	
	/**
	 *	Contains details about package delivery.
	 */
	class ServiceStandard {
	
	
		/**
		 *	Indicates whether a.m. delivery is defined
		 *	as part of the service standard for this
		 *	service.
		 */
		public $am;
		/**
		 *	Indicates if the delivery date is guaranteed.
		 */
		public $guaranteed;
		/**
		 *	Indicates the number of days from drop-off or
		 *	pickup to first delivery attempt.
		 */
		public $transit_time;
		/**
		 *	The estimated date of delivery, assuming the
		 *	expected mailing date supplied is accurate.
		 */
		public $delivery_date;
		
		
		public static function FromXML (\DOMNode $node) {
			
			$node=new \CivicInfoBC\DOMWrapper($node);
			
			$retr=new self();
			$retr->am=\CivicInfoBC\Convert::ToBooleanOrThrow($node->{'am-delivery'}->textContent);
			$retr->guaranteed=\CivicInfoBC\Convert::ToBooleanOrThrow($node->{'guaranteed-delivery'}->textContent);
			if (!is_null(
				$tt=$node->GetChild('expected-transit-time')
			)) $retr->transit_time=\CivicInfoBC\Convert::ToIntegerOrThrow($tt->textContent);
			if (!is_null(
				$dd=$node->GetChild('expected-delivery-date')
			)) $retr->delivery_date=\CivicInfoBC\Convert::ToDateTimeOrThrow(
				$dd->textContent,
				'Y-m-d'
			);
			
			return $retr;
		
		}
	
	
	}


?>