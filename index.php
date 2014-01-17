<?php

$f3=require('framework/base.php');

$f3->set('DEBUG',1);
if ((float)PCRE_VERSION<7.9)
	trigger_error('PCRE version is out of date');

$f3->config('api/configs/config.ini');
$f3->config('api/configs/routes.ini');

$f3->route('GET /',
	function($f3) {
		echo 'Bienvenue sur l\'api movies';
	}
);

$hive = $f3->hive();

$f3->set('ONERROR',function($f3){
    $error = F3::get('ERROR');
    Api::response($error['code'], $error['status']);
});

$f3->run();
