<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once 'vendor/autoload.php';

session_start();


$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {

    $r->get('/register', 'UsersController@showRegisterForm');
    $r->post('/register', 'UsersController@register');
    $r->get('/login', 'UsersController@showLoginForm');
    $r->post('/login', 'UsersController@login');

    $r->get('/', 'ItemsController@index');
    $r->get('/items', 'ItemsController@index');
    $r->get('/items/add', 'ItemsController@showAddForm');
    $r->post('/items/add', 'ItemsController@add');

    $r->get('/items/edit/{id}', 'ItemsController@showEditForm');
    $r->post('/items/edit/{id}', 'ItemsController@edit');
    $r->post('/items/delete/{id}', 'ItemsController@delete');
    $r->post('/items/search/{id}', 'ItemsController@search');

});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo "You shouldn't be here";
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controller, $method] = explode('@', $handler);
        $controller = 'App\Controllers\\' . $controller;
        $controller = new $controller();
        $controller->$method($vars);
        break;
}



