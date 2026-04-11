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
$routes->get('/admin', 'Home::adminDashboard');
$routes->get('/admin/booking', 'Home::adminBooking');
$routes->get('/admin/lapang', 'Home::adminLapang');
