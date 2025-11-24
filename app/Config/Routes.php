<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Authentication (public)
$routes->get('/', 'AuthController::login');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::loginCheck');
$routes->get('/logout', 'AuthController::logout');

// Protected routes (require auth)
$routes->group('', ['filter' => 'auth'], function($routes) {
    // Dashboard Routes
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->get('/dashboard/export', 'Dashboard::export');

$routes->group('santri', function($routes) {
    $routes->get('/', 'Santri::index');
    $routes->get('create', 'Santri::create');
    $routes->post('store', 'Santri::store');
    $routes->get('detail/(:num)', 'Santri::detail/$1');
    $routes->get('edit/(:num)', 'Santri::edit/$1');
    $routes->post('update/(:num)', 'Santri::update/$1');
    $routes->delete('delete/(:num)', 'Santri::delete/$1');
});


// Hafalan Routes
$routes->group('hafalan', function($routes) {
    $routes->get('/', 'Hafalan::index');
    $routes->get('create', 'Hafalan::create');
    $routes->post('store', 'Hafalan::store');
    $routes->get('edit/(:num)', 'Hafalan::edit/$1');
    $routes->post('update/(:num)', 'Hafalan::update/$1');
    $routes->get('delete/(:num)', 'Hafalan::delete/$1');
    $routes->get('filter', 'Hafalan::filter');
});

// Laporan Routes
$routes->group('laporan', function($routes) {
    $routes->get('/', 'Laporan::index');
    $routes->get('create', 'Laporan::create');
    $routes->post('store', 'Laporan::store');
    $routes->get('edit/(:num)', 'Laporan::edit/$1');
    $routes->post('update/(:num)', 'Laporan::update/$1');
    $routes->get('delete/(:num)', 'Laporan::delete/$1');
    $routes->get('jenis/(:alpha)', 'Laporan::jenis/$1');
    $routes->get('print/(:num)', 'Laporan::print/$1');
});

// Default route (fallback)
$routes->get('/home', 'Home::index');

});
