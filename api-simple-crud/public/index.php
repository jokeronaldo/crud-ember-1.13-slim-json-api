<?php

require_once dirname(__FILE__) . '/../bootstrap.php';

// JSON-API 
use \Neomerx\JsonApi\Document\Error;
use \Neomerx\JsonApi\Schema\Link;
use \Neomerx\JsonApi\Encoder\Encoder;
use \Neomerx\JsonApi\Encoder\EncoderOptions;
use \Neomerx\JsonApi\Parameters\EncodingParameters;

// Routes

// GET#users
$app->get('/users', function () use ($app) {
	$user = \User::all()->all();
	
	$encoder = Encoder::instance([
		User::class => UserSchema::class,
	], new EncoderOptions(JSON_PRETTY_PRINT));
	
	echo $encoder->encode($user) . PHP_EOL;
});

// GET#users/:id
$app->get('/users/:id', function ($id) use ($app) {
	$id = filter_var(filter_var($id, FILTER_SANITIZE_NUMBER_INT), FILTER_VALIDATE_INT);
	
	if ($id === false) {
		$app->response->setStatus(400);
	}
	else {
		$user = \User::find($id);
		
		if($user) {
			$encoder = Encoder::instance([
				User::class => UserSchema::class,
			], new EncoderOptions(JSON_PRETTY_PRINT));
			
			echo $encoder->encode($user) . PHP_EOL;
		}
		else {
			$app->jsonApiError(
				'get#users',
				$app->request->getResourceUri(),
				'404',
				'0002',
				'User not found.',
				'The requested user was not found or even never existed.'
			);
			
			$app->response->setStatus(404);
		}
	}
});

// POST#users
$app->post('/users', function () use ($app) {
	$body = $app->request->getBody();
	$name = $app->request()->post('name');
	$email = $app->request()->post('email');
	
	if(!empty($body)) {
		$decode = json_decode($body);
		
		$name = $app->jsonGetAttr($decode, 'name');
		$email = $app->jsonGetAttr($decode, 'email');
	}
	
	$name = filter_var($name, FILTER_SANITIZE_STRING);
	$email = filter_var(filter_var($email, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
	
	if($name === false || $email === false) {
		$app->response->setStatus(400);
	}
	else {
		$user = new User;
		
		$user->usr_name = $name;
		$user->usr_email = $email;
		
		$user->save();
		
		$encoder = Encoder::instance([
			User::class => UserSchema::class,
		], new EncoderOptions(JSON_PRETTY_PRINT));
		
		echo $encoder->encode($user) . PHP_EOL;
	}
});

// PATCH#users
$app->patch('/users/:id', function ($id) use ($app) {
	$id = filter_var(filter_var($id, FILTER_SANITIZE_NUMBER_INT), FILTER_VALIDATE_INT);
	
	$body = $app->request->getBody();
	$name = $app->request()->post('name');
	$email = $app->request()->post('email');
	
	if(!empty($body)) {
		$decode = json_decode($body);
		
		$name = $app->jsonGetAttr($decode, 'name');
		$email = $app->jsonGetAttr($decode, 'email');
	}
	
	$name = filter_var($name, FILTER_SANITIZE_STRING);
	
	if(!empty($email)) {
		$email = filter_var(filter_var($email, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
	}
	
	if($id === false || $name === false || $email === false) {
		$app->response->setStatus(400);
	}
	else {
		$user = \User::find($id);
		
		if($user) {
			$user->usr_name = $name;
			$user->usr_email = $email;
			
			$user->save();
			
			$encoder = Encoder::instance([
				User::class => UserSchema::class,
			], new EncoderOptions(JSON_PRETTY_PRINT));
			
			echo $encoder->encode($user) . PHP_EOL;
		}
		else {
			$app->jsonApiError(
				'get#users',
				$app->request->getResourceUri(),
				'404',
				'0002',
				'User not found.',
				'The requested user was not found or even never existed.'
			);
			
			$app->response->setStatus(404);
		}
	}
});

// DELETE#users
$app->delete('/users/:id', function ($id) use ($app) {	
	$id = filter_var(filter_var($id, FILTER_SANITIZE_NUMBER_INT), FILTER_VALIDATE_INT);
	
	if($id === false) {
		$app->response->setStatus(400);
	}
	else {
		$user = \User::find($id);
		
		if($user) {
			$user->delete();
			
			$encoder = Encoder::instance([
				User::class => UserSchema::class,
			], new EncoderOptions(JSON_PRETTY_PRINT));
			
			echo $encoder->encode($user) . PHP_EOL;
		}
		else {
			$app->jsonApiError(
				'get#users',
				$app->request->getResourceUri(),
				'404',
				'0002',
				'User not found.',
				'The requested user was not found or even never existed.'
			);
			
			$app->response->setStatus(404);
		}
	}
});

$app->run();