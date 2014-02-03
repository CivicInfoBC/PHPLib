<?php


	use CivicInfoBC\String as String;


	//	Load in PHPLib
	require_once('./civicinfobc/init.php');
	
	
	//	Load test suites
	$suites=array();
	$dir=new \DirectoryIterator('./tests');
	foreach ($dir as $file) {
	
		if (!(
			$file->isFile() &&
			String::Equals(
				String::ToLower($file->getExtension()),
				'php'
			) &&
			class_exists($class_name='\\Tests\\'.$file->getBasename(
				'.'.$file->getExtension()
			)) &&
			is_subclass_of($class_name,'\\CivicInfoBC\\Testing\\TestSuite')
		)) continue;
		
		$ref=new \ReflectionClass($class_name);
		$suites[]=$ref->newInstance();
	
	}
	
	
	//	Get results
	$results=array();
	foreach ($suites as $suite) $results[]=$suite->Execute();
	
	
	//	Sort the results
	usort($results,function ($a, $b) {	return String::Compare($a->name,$b->name);	});
	
	
	//	Prepare and render a template
	$template=new \CivicInfoBC\Template('./templates');
	$template->results=$results;
	$template->Add('unit_tests.phtml');
	foreach ($results as $x) $template->Add('test.phtml');
	$template->Render();


?>