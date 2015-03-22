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

// d($Route);
// exit('okay...');