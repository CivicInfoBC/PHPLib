<?php


	namespace CivicInfoBC\CanadaPost;
	
	
	/**
	 *	A dynamically generated endpoint returned
	 *	by the Canada Post XML API.
	 */
	class Endpoint {
	
	
		/**
		 *	The resource this endpoint related to
		 *	the original response.
		 */
		public $relationship;
		/**
		 *	The URL associated with this endpoint.
		 */
		public $url;
		/**
		 *	The media type this endpoint will return.
		 */
		public $media_type;
		/**
		 *	Present if this endpoint is for some kind
		 *	of formatted output.  The value starts at
		 *	0 for the first page.
		 */
		public $index;
		
		
		public static function FromXML (\DOMElement $node) {
		
			if (is_null($node)) return null;
		
			$node=new \CivicInfoBC\DOMWrapper($node);
		
			$retr=new self();
			$retr->relationship=$node['rel'];
			$retr->url=$node['href'];
			$retr->media_type=$node['media-type'];
			if (!is_null(
				$index=$node->GetAttribute('index')
			)) $retr->index=CivicInfoBC\Convert::ToIntegerOrThrow($index);
			
			return $retr;
		
		}
	
	
	}


?>