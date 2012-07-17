<?php

Autoloader::directories(array(
	Bundle::path('laradev').'models'
));

Autoloader::namespaces(array(
	'Lib' => Bundle::path('laradev').'libraries'
));
