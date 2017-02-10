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
$userMapperMysql = new \Model\DataMapper\UserMapper($connection);
$userFinderMysql = new \Model\Finder\UserFinder($connection);

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

$app->get('/login', function (Request $request, $id) use ($app, $userFinderMysql) {
	//$userFinderMysql->findOneById($id);
	return $app->render('login.php');
});
$app->post('/login', function (Request $request) use ($app, $userFinderMysql) {
	$login = $request->getParameter('login');
	$password = $request->getParameter('password');

	$user = $userFinderMysql->findOneByLogin($login);

	if($user != null && $user->verifyPassword($password)) {
		$app->redirect('/statuses');
	}

	var_dump('GENERER ERREUR');
	die;
});

$app->get('/register', function (Request $request, $id) use ($app, $userMapperMysql) {
	return $app->render('register.php');
});

$app->post('/register', function (Request $request, $id) use ($app, $userMapperMysql) {
	$login = $request->getParameter('login');
	$password = $request->getParameter('password');

	$userMapperMysql->persist(new \Model\User($login, $password));

	$app->redirect('/login');
});

return $app;
