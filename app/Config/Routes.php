<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('items', function ($routes) {
    $routes->get('/', 'ItemController::index');
    $routes->get('fetch', 'ItemController::fetch');
    $routes->get('categories', 'ItemController::getCategories');
    $routes->post('create', 'ItemController::create');
    $routes->post('update/(:num)', 'ItemController::update/$1');
    $routes->post('delete/(:num)', 'ItemController::delete/$1');
});