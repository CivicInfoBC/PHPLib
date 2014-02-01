<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains utilities for working with XML.
	 */
	class XML {
	
	
		private static function raise () {
		
			$message='';
			$first=true;
			foreach (libxml_get_errors() as $err) {
			
				if ($first) $first=false;
				else $message.='; ';
				
				$message.='Error parsing XML ';
				if (!(
					is_null($err->file) ||
					($err->file==='')
				)) $message.=sprintf(
					'in file %s ',
					$err->file
				);
				$message.=sprintf(
					'on line %s at column %s',
					$err->line,
					$err->column
				);
				if (!(
					is_null($err->message) ||
					($err->message==='')
				)) $message.=sprintf(
					': %s',
					$err->message
				);
			
			}
			
			throw new \Exception($message);
		
		}
	
	
		/**
		 *	Creates a DOMDocument object from an
		 *	XML string.
		 *
		 *	\param [in] $data
		 *		An XML string.
		 *
		 *	\return
		 *		A DOMDocument which is the root of
		 *		the document contained in \em data.
		 */
		public static function Load ($data) {
		
			$retr=new \DOMDocument();
		
			$restore=libxml_use_internal_errors(true);
			
			try {
			
				if (!$retr->loadXML(
					$data,
					//	See: https://bugs.php.net/bug.php?id=54138
					pow(2,22)
				)) self::raise();
			
			} catch (\Exception $e) {
			
				libxml_use_internal_errors($restore);
				
				throw $e;
			
			}
			
			libxml_use_internal_errors($restore);
			
			return $retr;
		
		}
	
	
	}


?>