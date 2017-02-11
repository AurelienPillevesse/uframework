<?php
require __DIR__ . '/../vendor/autoload.php';

use Http\Request;
use Http\JsonResponse;
use Dal\Connection;
use DateTime;

// Config
$debug = true;

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
    ), $debug);

$dsn = 'mysql:host=127.0.0.1;dbname=uframework;port=32768' ;
$user = 'uframework' ;
$password = 'p4ssw0rd';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$connection = new Connection($dsn, $user, $password, $options);
$statusFinderMysql = new \Model\Finder\StatusFinder($connection);
$statusMapperMysql = new \Model\DataMapper\StatusMapper($connection);
$userMapperMysql = new \Model\DataMapper\UserMapper($connection);
$userFinderMysql = new \Model\Finder\UserFinder($connection);

session_start();

/**
 * Index
 */
$app->get('/', function () use ($app) {
    return $app->redirect('/statuses');
});

$app->get('/statuses', function (Request $request) use ($app, $statusFinderMysql) {
    $filter['limit'] = $request->getParameter("limit") ? htmlspecialchars(preg_replace('/\s+/', '', $request->getParameter("limit"))) : null;
    $filter['orderBy'] = $request->getParameter("orderBy") ? htmlspecialchars(preg_replace('/\s+/', '', $request->getParameter("orderBy"))) : null;
    $filter['order'] = $request->getParameter("order") ? htmlspecialchars(preg_replace('/\s+/', '', $request->getParameter("order"))) : null;

    $statuses = $statusFinderMysql->findAll($filter);

    if ($request->guessBestFormat() == 'application/json') {
        return JsonResponse(json_encode($statuses));
    }

    return $app->render('statuses.php', array('statuses' => $statuses));
});

$app->post('/statuses', function (Request $request) use ($app, $statusMapperMysql) {
    $message = htmlspecialchars(trim($request->getParameter('message')));
    
    if ($message === "") {
        return $app->redirect('/statuses');
    }

    $user = isset($_SESSION['login']) ? $_SESSION['login'] : null;
    if ($user !== null && isset($_SESSION['id'])) {
        $user = new \Model\User($user, null, null, $_SESSION['id']);
    }

    $statusMapperMysql->persist(new \Model\Status($user, $message, new DateTime()));
    
    return $app->redirect('/statuses');
});

$app->get('/statuses/(\d+)', function (Request $request, $id) use ($app, $statusFinderMysql) {
    $status = $statusFinderMysql->findOneById($id);

    if ($status !== null) {
        throw new HttpException(404, "Status not found");
    }

    if ($request->guessBestFormat() == 'application/json') {
        return JsonResponse(json_encode($status));
    }

    return $app->render('status.php', array('status' => $status));
});

$app->delete('/statuses/(\d+)', function (Request $request, $id) use ($app, $statusMapperMysql) {
    $statusMapperMysql->remove($id);

    return $app->redirect('/statuses');
});

$app->get('/login', function (Request $request, $id) use ($app, $userFinderMysql) {
    return $app->render('login.php');
});

$app->post('/login', function (Request $request) use ($app, $userFinderMysql) {
    $login = $request->getParameter('login');
    $password = $request->getParameter('password');

    $user = $userFinderMysql->findOneByLogin($login);

    if ($user == null) {
        throw new HttpException(403, "Could not find user's login");
    }
    if (!$user->verifyPassword($password)) {
        throw new HttpException(403, "Wrong password for this user");
    }

    $_SESSION['id'] = $user->getId();
    $_SESSION['login'] = $user->getLogin();
    $_SESSION['is_authenticated'] = true;

    return $app->redirect('/statuses');
});

$app->get('/register', function (Request $request) use ($app) {
    return $app->render('register.php');
});

$app->post('/register', function (Request $request) use ($app, $userMapperMysql) {
    $login = $request->getParameter('login');
    $password = $request->getParameter('password');

    $userMapperMysql->persist(new \Model\User($login, $password));

    return $app->redirect('/login');
});

$app->get('/logout', function (Request $request) use ($app) {
    session_destroy();
    return $app->redirect('/');
});

return $app;
