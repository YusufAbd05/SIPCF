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
        return view('ubah_jadwal');
    }

    public function adminDashboard(): string
    {
        return view('admin/dashboard');
    }

    public function adminBooking(): string
    {
        return view('admin/booking');
    }

    public function adminLapang(): string
    {
        return view('admin/lapang');
    }
}
