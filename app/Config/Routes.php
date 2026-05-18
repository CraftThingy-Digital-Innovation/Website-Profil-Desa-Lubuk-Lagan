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

// Routes untuk Blog (Admin)
$routes->group('admin/blog', function($routes) {
    $routes->get('/', 'BlogController::index');
    $routes->get('create', 'BlogController::create_draft');
    $routes->get('edit/(:num)', 'BlogController::edit/$1');
    $routes->post('autosave', 'BlogController::autosave');
    $routes->get('delete/(:num)', 'BlogController::delete/$1');
});

// Routes untuk Map (Admin)
$routes->group('admin/map', function($routes) {
    $routes->get('/', 'MapController::index');
    $routes->get('create', 'MapController::create');
    $routes->get('edit/(:num)', 'MapController::edit/$1');
    $routes->post('save', 'MapController::save');
    $routes->get('delete/(:num)', 'MapController::delete/$1');
});

service('auth')->routes($routes);
