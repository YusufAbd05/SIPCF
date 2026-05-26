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

// Public API (no auth required)
$routes->get('/api/getLapangs', 'Home::getLapangs');
$routes->get('/api/getBookedSlots', 'Home::getBookedSlots');
$routes->get('/api/getMonthBookings', 'Home::getMonthBookings');
$routes->get('/api/getTarif', 'Home::getTarif');
$routes->get('/api/getJadwalMembership', 'Home::getJadwalMembership');
$routes->get('/api/getPembayaran', 'Home::getPembayaran');
$routes->post('/booking', 'Home::saveBooking');

// UC-3: Ubah Jadwal (Public API)
$routes->get('/api/lookupBooking', 'Home::lookupBooking');
$routes->post('/api/ubahJadwal', 'Home::processUbahJadwal');

// Auth
$routes->get('/login', 'AuthController::loginPage');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

// Admin (protected by auth filter)
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    // ─── Semua role (Admin, Manajer, Owner) ───
    $routes->get('/', 'DashboardController::index');
    $routes->get('laporan', 'LaporanController::index');
    $routes->get('laporan/exportData', 'LaporanController::exportData');

    // ─── Admin & Manajer: Kelola Booking ───
    $routes->group('', ['filter' => 'role:Admin,Manajer'], function ($routes) {
        $routes->get('booking', 'BookingController::index');
        $routes->post('booking/save', 'BookingController::save');
        $routes->post('booking/update', 'BookingController::update');
        $routes->post('booking/verifikasi', 'BookingController::verifikasi');
        $routes->post('booking/savePelunasan', 'BookingController::savePelunasan');
        $routes->get('booking/getBookedSlots', 'BookingController::getBookedSlots');
        $routes->get('booking/getTarif', 'BookingController::getTarif');
        $routes->get('booking/getKeuangan', 'BookingController::getKeuangan');
    });

    // ─── Manajer & Owner: Kelola Tarif ───
    $routes->group('', ['filter' => 'role:Manajer,Owner'], function ($routes) {
        $routes->get('tarif', 'TarifController::index');
        $routes->post('tarif/save', 'TarifController::save');
        $routes->post('tarif/update', 'TarifController::update');
        $routes->post('tarif/delete', 'TarifController::delete');
    });

    // ─── Manajer only: Kelola Lapang, Kelola User ───
    $routes->group('', ['filter' => 'role:Manajer'], function ($routes) {
        // Lapang CRUD
        $routes->get('lapang', 'LapangController::index');
        $routes->post('lapang/save', 'LapangController::save');
        $routes->post('lapang/update', 'LapangController::update');
        $routes->post('lapang/delete', 'LapangController::delete');

        // User CRUD
        $routes->get('users', 'UserController::index');
        $routes->post('users/save', 'UserController::save');
        $routes->post('users/update', 'UserController::update');
        $routes->post('users/delete', 'UserController::delete');
    });
});
