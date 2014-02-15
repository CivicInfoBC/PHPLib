<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains utilities for dealing with files.
	 */
	class File {
	
	
		/**
		 *	Gets a DateTime object which represents
		 *	the last time a particular file was
		 *	modified.
		 *
		 *	\param [in] $path
		 *		The path to the file-in-question.
		 *
		 *	\return
		 *		A DateTime object representing the
		 *		last time a particular file was
		 *		modified.
		 */
		public static function GetLastModified ($path) {
		
			if (($timestamp=Error::Wrap(function () use ($path) {
			
				return filemtime($path);
				
			}))===false) throw new \Exception(
				'filemtime failed'
			);
			
			$retr=new \DateTime();
			$retr->setTimestamp($timestamp);
			return $retr;
		
		}
		
		
		/**
		 *	Gets the contents of a file as a string.
		 *
		 *	\param [in] $path
		 *		The path to the file-in-question.
		 *
		 *	\return
		 *		The contents of the file given by \em path
		 *		as a string.
		 */
		public static function GetContents ($path) {
		
			if (($retr=Error::Wrap(function () use ($path) {
			
				return file_get_contents($path);
			
			}))===false) throw new \Exception(
				'file_get_contents failed'
			);
			
			return $retr;
		
		}
		
		
		/**
		 *	Writes a string to a file.
		 *
		 *	\param [in] $path
		 *		The path to the file-in-question.
		 *	\param [in] $contents
		 *		The string to write to the file.
		 *	\param [in] $overwrite
		 *		If \em true, the file will be overwritten.
		 *		If \em false, the file will be appended
		 *		to.  Defaults to \em true.
		 */
		public static function PutContents ($path, $contents, $overwrite=true) {
		
			$flags=LOCK_EX;
			if (!$overwrite) $flags|=FILE_APPEND;
			
			if (Error::Wrap(function () use ($path,$contents,$flags) {
				
				return file_put_contents($path,$contents,$flags);
				
			})===false) throw new \Exception(
				'file_put_contents failed'
			);
		
		}
		
		
		/**
		 *	Checks to see if a file exists.
		 *
		 *	\param [in] $path
		 *		The path to the file-in-question.
		 *
		 *	\return
		 *		\em true if the file exists,
		 *		\em false otherwise.
		 */
		public static function Exists ($path) {
		
			return @file_exists($path);
		
		}
		
		
		/**
		 *	Deletes a file.
		 *
		 *	\param [in] $path
		 *		The path to the file-in-question.
		 *
		 *	\return
		 *		\em true if the file was deleted,
		 *		\em false otherwise.
		 */
		public static function Delete ($path) {
		
			return @unlink($path);
		
		}
	
	
	}


?>