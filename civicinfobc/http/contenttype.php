<?php


	namespace CivicInfoBC\HTTP;
	
	
	/**
	 *	Encapsulates the information contained in
	 *	an HTTP Content-Type header.
	 */
	class ContentType {
	
	
		/**
		 *	The media type associated with this
		 *	Content-Type header.
		 */
		public $media_type;
		/**
		 *	The character set associated with this
		 *	Content-Type header.
		 */
		public $charset;
		
		
		private function get_media_type ($header, $default_media_type) {
		
			$this->media_type=(
				is_null($header) ||
				is_null($matches=\CivicInfoBC\Regex::Match(
					'/^\\s*([^\\/;\\s]+\\/[^;\\s]+)\\s*(?:;|$)/u',
					$header
				))
			) ? $default_media_type : $matches[1];
		
		}
		
		
		private function get_charset ($header, $default_charset) {
		
			$this->charset=(
				is_null($header) ||
				is_null($matches=\CivicInfoBC\Regex::Match(
					'/(?:^|\\s|;)charset\\s*\\=\\s*(\\S+)(?:$|\\s)/ui',
					$header
				))
			) ? $default_charset : $matches[1];
		
		}
		
		
		/**
		 *	Create a new ContentType object.
		 *
		 *	\param [in] $header
		 *		The Content-Type header to parse.  If
		 *		\em null the Content-Type header of this
		 *		request will be used.  Defaults to
		 *		\em null.
		 *	\param [in] $default_media_type
		 *		The media type to fallback to if one isn't
		 *		specified by the header (or if no header
		 *		is available).  Defaults to \em null.
		 *	\param [in] $default_charset
		 *		The character set to fallback to if one
		 *		isn't specified by the header (or if no
		 *		header is available).  Defaults to
		 *		\em null.
		 */
		public function __construct ($header=null, $default_media_type=null, $default_charset=null) {
		
			if (is_null($header)) $header=\CivicInfoBC\Request::GetHeaders()->Get('content-type');
			
			$this->get_media_type($header,$default_media_type);
			$this->get_charset($header,$default_charset);
		
		}
	
	
	}


?>