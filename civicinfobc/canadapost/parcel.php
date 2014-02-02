<?php


	namespace CivicInfoBC\CanadaPost;
	
	
	/**
	 *	Details about a single parcel.
	 */
	class Parcel {
	
	
		/**
		 *	The weight of the parcel in
		 *	kilograms.
		 */
		public $weight;
		/**
		 *	A Dimensions object representing
		 *	the dimensions of the parcel.
		 */
		public $dimensions;
		/**
		 *	\em true if the package is unpackaged,
		 *	\em false otherwise.  Defaults to \em false.
		 */
		public $unpackaged=false;
		/**
		 *	\em true if the package will be shipped
		 *	in a mailing tube, \em false otherwise.
		 *	Defaults to \em false.
		 */
		public $mailing_tube=false;
		/**
		 *	\em true if the package is oversized,
		 *	\em false otherwise.  Defaults to \em false.
		 */
		public $oversized=false;
		
		
		private static function get_bool ($bool) {
		
			return $bool ? 'true' : 'false';
		
		}
		
		
		public function Get (\DOMNode $node) {
		
			$doc=$node->ownerDocument;
		
			$node->appendChild($root=$doc->createElement('parcel-characteristics'));
			
			$root->appendChild($doc->createElement('weight',$this->weight));
			
			//	If the dimensions aren't null, we
			//	get them as XML.
			//
			//	If the dimensions are null, we send
			//	the oversized field
			if (is_null($this->dimensions)) $root->appendChild($doc->createElement(
				'oversized',
				self::get_bool($this->dimensions)
			));
			else $this->dimensions->Get($root);
			
			$root->appendChild($doc->createElement('unpackaged',self::get_bool($this->unpackaged)));
			$root->appendChild($doc->createElement('mailing-tube',self::get_bool($this->mailing_tube)));
		
		}
	
	
	}


?>