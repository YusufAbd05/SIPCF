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
    // Booking CRUD
    $routes->get('booking', 'BookingController::index');
    $routes->post('booking/saveWalkIn', 'BookingController::saveWalkIn');
    $routes->post('booking/update', 'BookingController::update');
    $routes->post('booking/verifikasi', 'BookingController::verifikasi');
    $routes->post('booking/savePelunasan', 'BookingController::savePelunasan');
    // Booking API (JSON)
    $routes->get('booking/getBookedSlots', 'BookingController::getBookedSlots');
    $routes->get('booking/getTarif', 'BookingController::getTarif');
    $routes->get('booking/getKeuangan', 'BookingController::getKeuangan');

    // Lapang CRUD
    $routes->get('lapang', 'LapangController::index');
    $routes->post('lapang/save', 'LapangController::save');
    $routes->post('lapang/update', 'LapangController::update');
    $routes->post('lapang/delete', 'LapangController::delete');

    // Tarif CRUD
    $routes->get('tarif', 'TarifController::index');
    $routes->post('tarif/save', 'TarifController::save');
    $routes->post('tarif/update', 'TarifController::update');
    $routes->post('tarif/delete', 'TarifController::delete');

    // User CRUD
    $routes->get('users', 'UserController::index');
    $routes->post('users/save', 'UserController::save');
    $routes->post('users/update', 'UserController::update');
    $routes->post('users/delete', 'UserController::delete');
});
