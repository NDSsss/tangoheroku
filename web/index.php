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
		return 'data is null';

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
			error_log(request_params);
			file_get_contents("https://api.vk.com/method/messages.send?user_id=88677243&message=Test2&access_token=e7c1719be1f5c6d9b858e95e1d21f1b3129126e88964c2ab5b67f5b16837cb0fdcbb9491eb744fde64467&v=5.69");
			return 'ok';
			break;
		
		default:
			# code...
			break;
	}

	return 'end';
});

$app->get('/getusers', function() use($app) {
	$respp = json_decode(file_get_contents("https://script.google.com/macros/s/AKfycbwwgtPVBck0oKJ3FU435xcbhVHbz0AXh09UvsHwe1AmRwsWfsuF/exec?action=getPeople"));
	return $respp;
});


$app->run();
