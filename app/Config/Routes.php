<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =====================
// PUBLIC ROUTES
// =====================
$routes->get('/', 'Home::index');
$routes->get('baca/(:segment)', 'Home::read_blog/$1');
$routes->get('sejarah', 'Home::sejarah');
$routes->get('perangkat', 'Home::perangkat');
$routes->get('kkn-107', 'Home::kkn');
$routes->get('kabar-desa', 'Home::kabar_desa');
$routes->get('berita', 'Home::blog_list');

// System Logs Endpoint (untuk debug di production, diproteksi password)
$routes->get('system-logs', 'SystemLogController::index');

// =====================
// ADMIN ROUTES (dilindungi oleh BaseAdminController)
// =====================

// Dashboard
$routes->get('admin/dashboard', 'DashboardController::index');

// Blog
$routes->group('admin/blog', function($routes) {
    $routes->get('/', 'BlogController::index');
    $routes->get('create', 'BlogController::create_draft');
    $routes->get('edit/(:num)', 'BlogController::edit/$1');
    $routes->post('autosave', 'BlogController::autosave');
    $routes->get('delete/(:num)', 'BlogController::delete/$1');
    $routes->get('preview/(:num)', 'BlogController::preview/$1');
});

// File Manager
$routes->group('admin/file-manager', function($routes) {
    $routes->get('/',         'FileManagerController::index');
    $routes->get('api/list',  'FileManagerController::api_list');
    $routes->post('upload',   'FileManagerController::upload');
    $routes->delete('delete/(:num)', 'FileManagerController::delete/$1');
});

// Map
$routes->group('admin/map', function($routes) {
    $routes->get('/', 'MapController::index');
    $routes->get('create', 'MapController::create');
    $routes->get('edit/(:num)', 'MapController::edit/$1');
    $routes->post('save', 'MapController::save');
    $routes->get('delete/(:num)', 'MapController::delete/$1');
});

// Carousel
$routes->group('admin/carousel', function($routes) {
    $routes->get('/', 'CarouselController::index');
    $routes->post('store', 'CarouselController::store');
    $routes->get('delete/(:num)', 'CarouselController::delete/$1');
    $routes->get('toggle/(:num)', 'CarouselController::updateStatus/$1');
});

// Officers (Perangkat Desa)
$routes->group('admin/officers', function($routes) {
    $routes->get('/',              'OfficerController::index');
    $routes->get('create',         'OfficerController::create');
    $routes->post('store',         'OfficerController::store');
    $routes->get('edit/(:num)',    'OfficerController::edit/$1');
    $routes->post('update/(:num)', 'OfficerController::update/$1');
    $routes->get('delete/(:num)',  'OfficerController::delete/$1');
});

// Gallery — KKN
$routes->group('admin/gallery/kkn', function($routes) {
    $routes->get('/',              'GalleryController::index/kkn');
    $routes->get('create',         'GalleryController::create/kkn');
    $routes->post('store',         'GalleryController::store/kkn');
    $routes->get('edit/(:num)',    'GalleryController::edit/kkn/$1');
    $routes->post('update/(:num)', 'GalleryController::update/kkn/$1');
    $routes->get('delete/(:num)',  'GalleryController::delete/kkn/$1');
});

// Gallery — Kabar Desa
$routes->group('admin/gallery/kabar-desa', function($routes) {
    $routes->get('/',              'GalleryController::index/kabar_desa');
    $routes->get('create',         'GalleryController::create/kabar_desa');
    $routes->post('store',         'GalleryController::store/kabar_desa');
    $routes->get('edit/(:num)',    'GalleryController::edit/kabar_desa/$1');
    $routes->post('update/(:num)', 'GalleryController::update/kabar_desa/$1');
    $routes->get('delete/(:num)',  'GalleryController::delete/kabar_desa/$1');
});

// Redirect /admin ke dashboard
$routes->get('admin', function() { return redirect()->to('admin/dashboard'); });

// Users (Superadmin only — guard ada di controller)
$routes->group('admin/users', function($routes) {
    $routes->get('/',              'UserManagementController::index');
    $routes->get('create',         'UserManagementController::create');
    $routes->post('store',         'UserManagementController::store');
    $routes->get('edit/(:num)',    'UserManagementController::edit/$1');
    $routes->post('update/(:num)', 'UserManagementController::update/$1');
    $routes->get('delete/(:num)',  'UserManagementController::delete/$1');
});

// Settings (Superadmin only)
$routes->group('admin/settings', function($routes) {
    $routes->get('/', 'SettingsController::index');
    $routes->post('/', 'SettingsController::index');
});

// =====================
// AUTH ROUTES (CI4 Shield)
// =====================
service('auth')->routes($routes);
