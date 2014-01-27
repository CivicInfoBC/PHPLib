<?php


	spl_autoload_register();
	//	Dirty hack so that checking if classes
	//	exist doesn't throw
	spl_autoload_register(function () {	});


?>