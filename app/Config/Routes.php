<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Items::index');

$routes->group('items', function ($routes) {
    $routes->get('/', 'Items::index');
    $routes->get('data', 'Items::data');
    $routes->get('categories', 'Items::categories');
    $routes->get('show/(:num)', 'Items::show/$1');
    $routes->post('save', 'Items::save');
    $routes->post('delete/(:num)', 'Items::delete/$1');
});

$routes->group('categories', function ($routes) {
    $routes->get('/', 'Categories::index');
    $routes->get('fetch', 'Categories::fetch');
    $routes->get('show/(:num)', 'Categories::show/$1');
    $routes->post('create', 'Categories::create');
    $routes->post('update/(:num)', 'Categories::update/$1');
    $routes->post('delete/(:num)', 'Categories::delete/$1');
});