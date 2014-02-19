<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Thrown when a participant could not
	 *	be registered for an event.
	 */
	class CouldNotRegister extends \Exception {
	
	
		/**
		 *	Could not register because the
		 *	registration was full.
		 */
		const FULL=0;
		/**
		 *	Could not register because a person
		 *	with that first and last name is
		 *	already registered.
		 */
		const ALREADY_REGISTERED=1;
	
	
		/**
		 *	Creates a new CouldNotRegister exception.
		 *
		 *	\param [in] $reason
		 *		The reason this exception is being
		 *		created.
		 */
		public function __construct ($reason) {
		
			switch ($reason) {
			
				case self::FULL:
					$message='Registration is full';
					break;
				case self::ALREADY_REGISTERED:
					$message='User already registered';
					break;
				default:
					$message='Unknown error';
					break;
			
			}
			
			parent::__construct($message,$reason);
		
		}
	
	
	}


?>