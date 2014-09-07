<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains functions for encoding and decoding
	 *	JSON.
	 */
	class JSON {
	
	
		private static function check () {
		
			if (($code=json_last_error())!==JSON_ERROR_NONE) throw new JSONException(
				json_last_error_msg(),
				$code
			);
		
		}
	
	
		/**
		 *	Encodes data as JSON.
		 *
		 *	\param [in] $data
		 *		The data to encode.
		 *	\param [in] $depth
		 *		The maximum depth to which this function
		 *		will recurse to encode \em data.  Defaults
		 *		to \em null in which case a sensible
		 *		default will be used.
		 */
		public static function Encode ($data, $depth=null) {
		
			$json=is_null($depth) ? json_encode($data) : json_encode($data,0,$depth);
			
			self::check();
			
			return $json;
		
		}
		
		
		/**
		 *	Decodes JSON data.
		 *
		 *	\param [in] $json
		 *		The JSON to decode.
		 *	\param [in] $depth
		 *		The maximum depth to which this function
		 *		will recurse to decode \em json.  Defaults
		 *		to \em null in which case a sensible
		 *		default will be used.
		 */
		public static function Decode ($json, $depth=null) {
		
			$obj=is_null($depth) ? json_decode($json) : json_decode($json,false,$depth);
			
			self::check();
			
			return $obj;
		
		}
		
		
		/**
		 *	Sends JSON.
		 *
		 *	\param [in] $json
		 *		The object to serialize to JSON.
		 *	\param [in] $headers
		 *		If \em true the function should set the
		 *		HTTP \"Content-Type\" header to specify
		 *		that the response is JSON.  Defaults to
		 *		\em true.
		 *	\param [in] $depth
		 *		Specifies the maximum depth to which
		 *		the encoder will recurse while encoding
		 *		\em json.  If \em null a sensible default
		 *		will be chosen.  Defaults to \em null.
		 */
		public static function Send ($json, $headers=true, $depth=null) {
		
			//	Attempt to get JSON to send first,
			//	so that we haven't committed to sending
			//	headers if this function throws
			$text=self::Encode($json,$depth);
			
			//	Send header (if requested)
			if ($headers) header('Content-Type: application/json; charset=utf-8');
			//	Send JSON
			echo($text);
		
		}
		
		
		/**
		 *	Gets the body of the request decoded as JSON.
		 *
		 *	\param [in] $depth
		 *		The maximum depth to which this function
		 *		will recurse to decode \em json.  Defaults
		 *		to \em null in which case a sensible
		 *		default will be used.
		 *
		 *	\return
		 *		The result of decoding the request.
		 */
		public static function Get ($depth=null) {
		
			return self::Decode(
				Request::GetBody(),
				$depth
			);
		
		}
	
	
	}


?>