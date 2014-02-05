<?php


	use CivicInfoBC\String as String;


	//	Load in PHPLib
	require_once('./civicinfobc/init.php');
	
	
	//	Loads test suites
	function load_suites ($path, $namespace, array &$arr) {
	
		$dir=new \DirectoryIterator($path);
		foreach ($dir as $x) {
		
			if (
				($x->getFilename()==='.') ||
				($x->getFilename()==='..')
			) continue;
		
			if ($x->isDir()) {
			
				load_suites(
					\CivicInfoBC\Path::Join($path,$x->getFilename()),
					$namespace.'\\'.$x->getFilename(),
					$arr
				);
				
				continue;
			
			}
			
			if (!(
				$x->isFile() &&
				String::Equals(
					String::ToLower($x->getExtension()),
					'php'
				) &&
				class_exists($class_name=$namespace.'\\'.$x->getBasename(
					'.'.$x->getExtension()
				)) &&
				is_subclass_of($class_name,'\\CivicInfoBC\\Testing\\TestSuite')
			)) continue;
			
			$ref=new \ReflectionClass($class_name);
			$arr[]=$ref->newInstance();
		
		}
	
	}
	
	
	$suites=array();
	load_suites('./tests','\\Tests',$suites);
	
	
	//	Get results
	$results=array();
	$success=0;
	$total=0;
	foreach ($suites as $suite) {
	
		$result=$suite->Execute();
		$total+=count($result->results);
		foreach ($result->results as $r) if ($r->success) ++$success;
	
		$results[]=$result;
		
	}
	
	
	//	Sort the results
	usort($results,function ($a, $b) {	return String::Compare($a->name,$b->name);	});
	
	
	//	Prepare and render a template
	$template=new \CivicInfoBC\Template('./templates');
	$template->results=$results;
	$template->success=$success;
	$template->total=$total;
	$template->Add('unit_tests.phtml');
	foreach ($results as $x) $template->Add('test.phtml');
	$template->Render();


?>