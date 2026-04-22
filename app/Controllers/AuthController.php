<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function loginPage()
    {
        // If already logged in, redirect to admin
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        return view('auth/login');
    }

    public function login()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan.')->withInput();
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah.')->withInput();
        }

        // Set session
        session()->set([
            'isLoggedIn' => true,
            'id_user'    => $user['id_user'],
            'nama'       => $user['nama'],
            'email'      => $user['email'],
            'role'       => $user['role'],
        ]);

        return redirect()->to('/admin')->with('success', 'Selamat datang, ' . $user['nama'] . '!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
