<?php

$injector = new \Auryn\Injector;

$signer = new Kunststube\CSRFP\SignatureGenerator(getenv('CSRF_SECRET'));
$injector->share($signer);

$blade = new duncan3dc\Laravel\BladeInstance(getenv('VIEWS_DIRECTORY'), getenv('CACHE_DIRECTORY'));
$injector->share($blade);

$injector->make('Phpunittest\Http\Request');
$injector->make('Phpunittest\Http\Response');
$injector->make('Phpunittest\Http\Session');

$injector->share('Phpunittest\Http\Request');
$injector->share('Phpunittest\Http\Response');
$injector->share('Phpunittest\Http\Session');

return $injector;
