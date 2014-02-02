<?php


	namespace CivicInfoBC\CanadaPost;
	
	
	/**
	 *	Encapsulates a destination.
	 */
	class Destination {
	
	
		/**
		 *	Indicates a destination in Canada.
		 */
		const DOMESTIC=0;
		/**
		 *	Indicates a destination in the United
		 *	States of America.
		 */
		const USA=1;
		/**
		 *	Indicates a destination somewhere other
		 *	than Canada and the United States of
		 *	America.
		 */
		const INTERNATIONAL=2;
	
	
		/**
		 *	One of the type constants defined
		 *	by this class.
		 */
		public $type;
		/**
		 *	If this destination is domestic, the
		 *	postal code of the destination.
		 *
		 *	If this destination is the USA, the
		 *	zip code of the destination.
		 *
		 *	if this destination is international,
		 *	the country code of that country.
		 */
		public $code;
		
		
		/**
		 *	Creates and initializes a Destination
		 *	object.
		 *
		 *	\param [in] $type
		 *		A value with which to initialize the
		 *		\em type field.
		 *	\param [in] $code
		 *		A value with which to initialize the
		 *		\em code field.
		 */
		public function __construct ($type, $code) {
		
			$this->type=$type;
			$this->code=$code;
		
		}
		
		
		public function Get (\DOMNode $node) {
		
			$doc=$node->ownerDocument;
			
			$node->appendChild($root=$doc->createElement('destination'));
			
			switch ($this->type) {
			
				case self::DOMESTIC:
					$root->appendChild($inner=$doc->createElement('domestic'));
					$inner->appendChild($doc->createElement('postal-code',$this->code));
					break;
					
				case self::USA:
					$root->appendChild($inner=$doc->createElement('united-states'));
					$inner->appendChild($doc->createElement('zip-code',$this->code));
					break;
					
				default:
					$root->appendChild($inner=$doc->createElement('international'));
					$inner->appendChild($doc->createElement('country-code',$this->code));
					break;
			
			}
		
		}
	
	
	}


?>