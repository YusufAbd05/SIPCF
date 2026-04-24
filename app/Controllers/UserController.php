<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();

        $data = [
            'users' => $users,
        ];

        return view('admin/ViewUser', $data);
    }

    public function save()
    {
        $userModel = new UserModel();

        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
        ];

        $userModel->insert($data);

        return redirect()->to('/admin/users')->with('success', 'Data user berhasil disimpan!');
    }

    public function update()
    {
        $userModel = new UserModel();
        $id = $this->request->getPost('id_user');

        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'role' => $this->request->getPost('role'),
        ];

        // Jika password diisi, update password juga
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $userModel->update($id, $data);

        return redirect()->to('/admin/users')->with('success', 'Data user berhasil diubah!');
    }

    public function delete()
    {
        $userModel = new UserModel();
        $id = $this->request->getPost('id_user');

        $userModel->delete($id);

        return redirect()->to('/admin/users')->with('success', 'Data user berhasil dihapus!');
    }
}
