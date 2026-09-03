<?php

use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('login', [AuthController::class, 'loginView']);
$routes->post('login', [AuthController::class, 'loginAction']);
$routes->get('register', [AuthController::class, 'registerView']);
$routes->post('register', [AuthController::class, 'registerAction']);
$routes->get('logout', [AuthController::class, 'logoutAction']);
$routes->get('level', 'Admin\levelThresholdController::index');

/* Routes pour l'administration */
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'group:admin'], function ($routes) {
    $routes->get('/', 'AdminController::index');

    $routes->group('user', function ($routes) {
        $routes->get('/', 'UserController::index');
        $routes->get('edit/(:num)', 'UserController::edit/$1');
        $routes->get('new', 'UserController::new');
        $routes->post('update', 'UserController::update');
        $routes->post('create', 'UserController::create');
    });

    $routes->group('level-threshold', function ($routes) {
        $routes->get('/', 'levelThresholdController::index');
        $routes->get('edit/(:num)', 'levelThresholdController::edit/$1');
        $routes->post('update', 'levelThresholdController::update');
        $routes->post('create', 'levelThresholdController::create');
        $routes->get('delete/(:num)', 'levelThresholdController::delete/$1');
    });
});

/*
 * Routes pour l'ajout et la suppression des niveaux
 */
$routes->post('level/add', 'Admin\levelThresholdController::add');
$routes->post('level/delete', 'Admin\levelThresholdController::delete');
