<?php

Autoloader::directories(array(
	Bundle::path('laradev').'models',
	Bundle::path('laradev').'libraries',
));

Autoloader::namespaces(array(
	'Laradevdrivers' => Bundle::path('laradev').'libraries'. DS .'laradevdrivers',
));
