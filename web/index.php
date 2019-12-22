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

	if( $data->secret !== getenv('VK_SECRET_TOKEN'))
		return 'nioh';
	error_log("in switch");
	switch ($data->type) {
		case 'confirmation':
			return getenv('VK_CONFIRM_TOKEN');
			break;
		case 'message_new':
	error_log("in message_new");
			$request_params = array(
				'user_id' => $data->object->from_id,
				'message' => 'Test',
				'access_token' => getenv(VK_TOKEN),
				'v' => '5.69'
			);
			error_log(request_params)
			file_get_contents("https://api.vk.com/method/messages.send?" . http_build_query($request_params));
			return 'ok';
			break;
		
		default:
			# code...
			break;
	}

	return 'nioh';
});

$app->run();
