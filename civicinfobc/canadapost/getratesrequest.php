<?php


	namespace CivicInfoBC\CanadaPost;
	
	
	class GetRatesRequest extends Request {
	
	
		public $customer_number;
		public $contract_id;
		public $commercial=false;
		public $expected_mailing_date;
		public $options=array();
		public $parcel;
		public $services=array();
		public $postal_code;
		public $destination;
		
		
		public function GetURL ($production) {
		
			return \CivicInfoBC\URL::Combine(
				parent::GetURL($production),
				'rs/ship/price'
			);
		
		}
		
		
		public function GetContentType () {
		
			return 'application/vnd.cpc.ship.rate-v2+xml';
		
		}
		
		
		public function GetAccept () {
		
			return $this->GetContentType();
		
		}
		
		
		public function GetMethod () {
		
			return 'POST';
		
		}
		
		
		private static function add ($node, $tag, $value=null) {
		
			$doc=$node->ownerDocument;
		
			$node->appendChild(
				$retr=is_null($value)
					?	$doc->createElement($tag)
					:	$doc->createElement($tag,$value)
			);
			
			return $retr;
		
		}
		
		
		public function GetBody () {
		
			//	Create the document and root
			//	element
			$doc=new \DOMDocument('1.0','utf-8');
			$root=$doc->createElementNS('http://www.canadapost.ca/ws/ship/rate-v2','mailing-scenario');
			$doc->appendChild($root);
			
			//	Add customer number & contract ID
			//	if applicable
			if (!(
				is_null($this->customer_number) ||
				is_null($this->contract_id)
			)) {
			
				self::add($root,'customer-number',$this->customer_number);
				self::add($root,'contract-id',$this->contract_id);
			
			}
			
			//	Add quote type
			self::add($root,'quote-type',$this->commercial ? 'commercial' : 'counter');
			
			//	Add expected mailing date
			if (!is_null($this->expected_mailing_date)) self::add($root,'expected-mailing-date',
				($this->expected_mailing_date instanceof \DateTime)
					?	$this->expected_mailing_date->format('Y-m-d')
					:	$this->expected_mailing_date
			);
			
			//	Add options
			Option::GetArray($this->options,$root);
			
			//	Add parcel characteristics
			if (!is_null($this->parcel)) $this->parcel->Get($root);
			
			//	Add services
			if (count($this->services)!==0) {
			
				$services=self::add($root,'services');
				foreach ($this->services as $service) self::add($services,'service-code',$service);
			
			}
			
			//	Add origin postal code
			if (!is_null($this->postal_code)) self::add($root,'origin-postal-code',$this->postal_code);
			
			//	Add destination
			if (!is_null($this->destination)) $this->destination->Get($root);
			
			return $doc->saveXML();
		
		}
		
		
		public function GetResponse (\DOMDocument $response) {
		
			
		
		}
	
	
	}


?>