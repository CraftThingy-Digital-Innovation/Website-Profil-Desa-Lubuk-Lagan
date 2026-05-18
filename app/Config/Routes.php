<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Routes untuk File Manager (Admin)
$routes->group('admin/file-manager', function($routes) {
    $routes->get('/', 'FileManagerController::index');
    $routes->post('upload', 'FileManagerController::upload');
    $routes->delete('delete/(:num)', 'FileManagerController::delete/$1');
});

service('auth')->routes($routes);
