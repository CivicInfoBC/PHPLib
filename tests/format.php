<?php


	namespace Tests;
	
	
	use \CivicInfoBC\Format as F;
	use \CivicInfoBC\Testing\Test as T;
	
	
	class Format extends \CivicInfoBC\Testing\TestSuite {
	
	
		public function __construct () {
		
			parent::__construct('Formatting Utilities');
			
			$this->tester->tests=array(
				new T(
					'Name',
					'Formatting an already formatted name leaves it untouched',
					function () {
					
						$str='Robert Leahy';
						return F::Name($str)===$str;
					
					}
				),
				new T(
					'Name (whitespace)',
					'Formatting a name removes spurious whitespace',
					function () {	return F::Name(' Robert  Leahy ')==='Robert Leahy';	}
				),
				new T(
					'Name (whitespace)',
					'Formatting a name with non-space whitespace converts yields a name with only space whitespace',
					function () {	return F::Name('Robert'."\t".'Leahy')==='Robert Leahy';	}
				),
				new T(
					'Name (case correction)',
					'Initial letters are capitalized (i.e. "ROBERT LEAHY" becomes "Robert Leahy")',
					function () {	return F::Name('ROBERT LEAHY')==='Robert Leahy';	}
				),
				new T(
					'Name (case correction)',
					'Formatting a name that begins with "Mc-" yields proper capitalization (i.e. "McDonald" rather than "Mcdonald")',
					function () {	return F::Name('mcdonald')==='McDonald';	}
				),
				new T(
					'Name (case correction)',
					'Formatting a name that begins with "Mac-" yields proper capitalization (i.e. "MacWilliam" rather than "Macwilliam")',
					function () {	return F::Name('macwilliam')==='MacWilliam';	}
				),
				new T(
					'Name (case correction)',
					'Formatting a name that begins with "O\'-" yields proper capitalization (i.e. "O\'Brien" rather than "O\'brien")',
					function () {	return F::Name('o\'brien')==='O\'Brien';	}
				),
				new T(
					'Name (case correction)',
					'Formatting a name that contains "van" yields proper capitalization (i.e. "van der Waft" rather than "Van Der Waft")',
					function () {	return \CivicInfoBC\Regex::IsMatch('/\\bvan\\b/u',F::Name('VAN DER WAFT'));	}
				),
				new T(
					'Name (case correction)',
					'Formatting a name that contains "der" yields proper capitalization (i.e. "van der Waft" rather than "Van Der Waft")',
					function () {	return \CivicInfoBC\Regex::IsMatch('/\\bder\\b/u',F::Name('VAN DER WAFT'));	}
				),
				new T(
					'Name (case correction)',
					'Formatting a name that contains "von" yields proper capitalization (i.e. "Ludwig von Mises" rather than "Ludwig Von Mises")',
					function () {	return F::Name('LUDWIG VON MISES')==='Ludwig von Mises';	}
				)
			);
		
		}
	
	
	}


?>