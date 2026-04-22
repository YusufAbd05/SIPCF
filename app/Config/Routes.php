<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/booking', 'Home::formulirBooking');
$routes->get('/membership', 'Home::membership');
$routes->get('/daftar-membership', 'Home::daftarMembership');
$routes->get('/ubah-jadwal', 'Home::ubahJadwal');

// Auth
$routes->get('/login', 'AuthController::loginPage');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

// Admin (protected by auth filter)
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Home::adminDashboard');
    $routes->get('booking', 'Home::adminBooking');
    $routes->get('lapang', 'Home::adminLapang');

    // User CRUD
    $routes->get('users', 'UserController::index');
    $routes->post('users/save', 'UserController::save');
    $routes->post('users/update', 'UserController::update');
    $routes->post('users/delete', 'UserController::delete');
});
