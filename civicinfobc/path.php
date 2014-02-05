<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains utilities for working with
	 *	file system paths.
	 */
	class Path {
	
	
		private static function join_impl ($a, $b) {
			
			if (Platform::IsWindows()) Regex::Replace(
				'/\\\\/u',
				'/',
				$b
			);
			
			if ($a==='') return $b;
			
			return Regex::Replace(
				'/\\/$/u',
				'',
				$a
			).Regex::Replace(
				'/^(?!\\/)/u',
				'/',
				$b
			);
		
		}
	
	
		/**
		 *	Joins an arbitrary number of file system
		 *	path components into a path.
		 *
		 *	An arbitrary number of arguments may be
		 *	supplied, they will all be joined.  If any
		 *	arrays are supplied, they will be flattened
		 *	(i.e. it will be treated as if each element
		 *	of that array was passed as an argument).
		 *
		 *	\return
		 *		A path which is the result of composing
		 *		each argument.
		 */
		public static function Join () {
		
			$retr='';
			foreach (func_get_args() as $x) {
			
				if (is_array($x)) $x=call_user_func_array(
					array(
						'Path',
						'Join'
					),
					$x
				);
				
				$retr=self::join_impl($retr,$x);
			
			}
			
			return $retr;
		
		}
	
	
	}


?>