<?php
require __DIR__ . '/../vendor/autoload.php';

use Http\Request;
use Dal\Connection;

// Config
$debug = true;

$app = new \App(new View\TemplateEngine(
	__DIR__ . '/templates/'
	), $debug);


$dsn = 'sqlite:./config/uframe.db';
$user = '';
$password = '';

//$inMemoryF = new \Model\InMemoryFinder();
//$jsonF = new \Model\JsonFinder();
$connection = new Connection($dsn, $user, $password);

/**
 * Index
 */
$app->get('/', function () use ($app) {
	return $app->render('index.php');
});


$app->get('/statuses', function (Request $request) use ($app, $jsonF) {
	//$statuses = $inMemoryF->findAll();

	$statuses = $jsonF->findAll();
	return $app->render('statuses.php', array('statuses' => $statuses));
});

$app->post('/statuses', function (Request $request) use ($app, $jsonF) {
	$username = $request->getParameter('username');
	$message = $request->getParameter('message');

	$jsonF->addOne($username, $message);
	
	$app->redirect('/statuses');
});

$app->get('/statuses/(\d+)', function (Request $request, $id) use ($app, $jsonF) {
	//$status = $inMemoryF->findOneById($id);

	$status = $jsonF->findOneById($id);
	return $app->render('status.php', array('status' => $status));
});

$app->delete('/statuses/(\d+)', function (Request $request, $id) use ($app, $jsonF) {
	$jsonF->deleteOneById($id);
	$app->redirect('/statuses');
});

return $app;
