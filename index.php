<?php
require_once __DIR__ . '/vendor/autoload.php';

use Bookstore\Core\SessionMiddleware;
use Bookstore\Core\Config;
use Bookstore\Core\Router;
use Bookstore\Core\Request;
use Bookstore\Core\Db;
use Bookstore\Utils\DependencyInjector;

use Monolog\Logger;
#use Twig_Environment;
#use Twig_Loader_Filesystem;
use Monolog\Handler\StreamHandler;

use Bookstore\Models\ItemModel;

use Kreait\Firebase\Factory;

ini_set('session.cookie_lifetime', 0);
$sessionMiddleware = new SessionMiddleware();
$sessionMiddleware->handle();


$config = new Config();

// $dbConfig = $config->get('db');
// $db = new PDO(
//     'mysql:host=' . getenv('IP') . ';dbname=bookstore;port=3306',
//     $dbConfig['user'],
//     $dbConfig['password']
// );

$factory = (new Factory)
    ->withServiceAccount('php-firebase-eccomerce-firebase-adminsdk-md6r1-e9b43468bb.json')
    ->withDatabaseUri('https://php-firebase-eccomerce-default-rtdb.firebaseio.com/');

    $db = $factory->createDatabase();

$loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
$view = new Twig_Environment($loader, array('auto_reload' => true, 'cache' => false));
$view->addGlobal('session', $_SESSION);

$log = new Logger('itemstore');
$logFile = $config->get('log');
$log->pushHandler(new StreamHandler($logFile, Logger::DEBUG));

$di = new DependencyInjector();
$di->set('PDO', $db);
$di->set('Utils\Config', $config);
$di->set('Twig_Environment', $view);
$di->set('Logger', $log);

$di->set('ItemModel', new ItemModel($di->get('PDO')));

$router = new Router($di);
$response = $router->route(new Request());
echo $response;

/*
$loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
$twig = new Twig_Environment($loader);

$saleModel = new SaleModel(Db::getInstance()); 
$sale = $saleModel->get(3); 

$params = ['sale' => $sale];
echo $twig->loadTemplate('sale.twig')->render($params);
*/