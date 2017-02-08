<?php
require __DIR__ . '/../vendor/autoload.php';

use Http\Request;
use Dal\Connection;
use \DateTime;

// Config
$debug = true;

$app = new \App(new View\TemplateEngine(
	__DIR__ . '/templates/'
	), $debug);


/*$dsn = 'sqlite:./config/uframe.db';
$user = '';
$password = '';
*/
$dsn = 'mysql:host=127.0.0.1;dbname=uframework;port=32768' ;
$user = 'uframework' ;
$password = 'p4ssw0rd';

//$inMemoryF = new \Model\InMemoryFinder();
//$jsonF = new \Model\JsonFinder();
$connection = new Connection($dsn, $user, $password);
$statusFinderMysql = new \Model\Finder\StatusFinder($connection);
$statusMapperMysql = new \Model\DataMapper\StatusMapper($connection);

/**
 * Index
 */
$app->get('/', function () use ($app) {
	return $app->render('index.php');
});


$app->get('/statuses', function (Request $request) use ($app, $statusFinderMysql) {
	//$statuses = $inMemoryF->findAll();
	//$statuses = $jsonF->findAll();

	$filter['order'] = $request->getParameter("order") ? htmlspecialchars($request->getParameter("order")) : "";
	$filter['limit'] = $request->getParameter("limit") ? htmlspecialchars($request->getParameter("limit")) : "";
	$filter['orderBy'] = $request->getParameter("orderBy") ? htmlspecialchars($request->getParameter("orderBy")) : "";

	$statuses = $statusFinderMysql->findAll($filter);

	return $app->render('statuses.php', array('statuses' => $statuses));
});

$app->post('/statuses', function (Request $request) use ($app, $statusMapperMysql) {
	$username = $request->getParameter('username');
	$message = $request->getParameter('message');

	$statusMapperMysql->persist(new \Model\Status($username, $message, new DateTime()));

	//$jsonF->addOne($username, $message);

	$app->redirect('/statuses');
});

$app->get('/statuses/(\d+)', function (Request $request, $id) use ($app, $statusFinderMysql) {
	//$status = $inMemoryF->findOneById($id);

	$status = $statusFinderMysql->findOneById($id);
	return $app->render('status.php', array('status' => $status));
});

$app->delete('/statuses/(\d+)', function (Request $request, $id) use ($app, $statusMapperMysql) {
	$statusMapperMysql->remove($id);
	$app->redirect('/statuses');
});

return $app;
