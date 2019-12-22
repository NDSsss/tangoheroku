<?php

require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

$app->get('/', function() use($app) {
	return "Hellow World!";
});

$app->get('/info', function() use($app) {
	return "info";
});

$app->post('/bot', function() use($app) {

	$data = json_decode(file_get_contents('php://input'));

	if( !$data)
		return 'nioh';

	if( $data->secret !== getenv('VK_SECRET_TOKEN') && $data->type !== 'confirmation')
		return 'nioh';

	switch ($data->type) {
		case 'confirmation':
			return getenv('VK_CONFIRM_TOKEN');
			break;
		
		default:
			# code...
			break;
	}

	return 'nioh';
});

$app->run();
