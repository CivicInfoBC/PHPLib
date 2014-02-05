<?php

	if (!(
		isset($_GET['encoding']) &&
		in_array(
			$_GET['encoding'],
			array(
				'utf-8',
				'utf-16'
			)
		)
	)) {
	
		header('HTTP/1.1 400 BAD REQUEST');
		
		exit();
	
	}
	
	header('Content-Type: text/plain; charset='.$_GET['encoding']);
	
	echo(mb_convert_encoding('naïveté',$_GET['encoding'],'utf-8'));
	
?>