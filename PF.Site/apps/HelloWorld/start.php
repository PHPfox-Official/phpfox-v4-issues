<?php

$Route = new Core\Route('/hello-world');
$Route->run(function(Core\Controller $Controller) {

	// p('run...');

	return $Controller->render('index.html', [
		'foo' => 'bar'
	]);
});

(new Core\Route('/hello-world/sample/:type'))
	->accept('GET')
	->call('Apps\HelloWorld\Controllers\HelloWorld@sample')
	->where([
		':type' => '([0-9]+)'
	]);

(new Core\Route([
	'/hello-world/array' => [
		'call' => 'Apps\HelloWorld\Controllers\HelloWorld@arrayRoute',
		'auth' => true
	]
]));

(new Core\Route('/hello-world/url'))->url('http://localhost/phpfox/4x_/dev/api.php')
	->accept('GET', 'POST');

// d($Route);
// exit('okay...');