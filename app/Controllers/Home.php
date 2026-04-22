<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('index');
    }

    public function ubahJadwal(): string
    {
        return view('UbahJadwal');
    }

    public function formulirBooking(): string
    {
        return view('FormulirBooking');
    }

    public function membership(): string
    {
        return view('Membership');
    }

    public function daftarMembership(): string
    {
        return view('DaftarMembership');
    }

    public function adminDashboard(): string
    {
        return view('admin/dashboard');
    }

    public function adminBooking(): string
    {
        return view('admin/booking');
    }

}
