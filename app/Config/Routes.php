<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\AuthController;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->group('admin',['filter' => 'group:admin'], function ($routes) {


});
$routes->get('login', [AuthController::class, 'loginView']);
$routes->post('login', [AuthController::class, 'loginAction']);
$routes->get('register', [AuthController::class, 'registerView']);
$routes->post('register', [AuthController::class, 'registerAction']);
$routes->get('logout', [AuthController::class, 'logoutAction']);
