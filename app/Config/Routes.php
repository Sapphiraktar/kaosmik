<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->group('admin',['filter' => 'group:admin'], function ($routes) {


});
service('auth')->routes($routes);
