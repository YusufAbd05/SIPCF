<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TarifModel;
use App\Models\LapangModel;

class TarifController extends BaseController
{
    public function index()
    {
        $tarifModel = new TarifModel();
        $lapangModel = new LapangModel();

        $tarifs = $tarifModel->getTarifWithLapang();
        $lapangs = $lapangModel->findAll();

        $data = [
            'tarifs' => $tarifs,
            'lapangs' => $lapangs,
        ];

        return view('admin/ViewTarif', $data);
    }

    public function save()
    {
        $tarifModel = new TarifModel();

        $data = [
            'id_lapang' => $this->request->getPost('id_lapang'),
            'nama_tarif' => $this->request->getPost('nama_tarif'),
            'hari' => $this->request->getPost('hari'),
            'jam_mulai' => $this->request->getPost('jam_mulai'),
            'jam_selesai' => $this->request->getPost('jam_selesai'),
            'harga_umum' => $this->request->getPost('harga_umum'),
            'harga_member' => $this->request->getPost('harga_member'),
        ];

        $tarifModel->insert($data);

        return redirect()->to('/admin/tarif')->with('success', 'Data tarif berhasil disimpan!');
    }

    public function update()
    {
        $tarifModel = new TarifModel();
        $id = $this->request->getPost('id_tarif');

        $data = [
            'id_lapang' => $this->request->getPost('id_lapang'),
            'nama_tarif' => $this->request->getPost('nama_tarif'),
            'hari' => $this->request->getPost('hari'),
            'jam_mulai' => $this->request->getPost('jam_mulai'),
            'jam_selesai' => $this->request->getPost('jam_selesai'),
            'harga_umum' => $this->request->getPost('harga_umum'),
            'harga_member' => $this->request->getPost('harga_member'),
        ];

        $tarifModel->update($id, $data);

        return redirect()->to('/admin/tarif')->with('success', 'Data tarif berhasil diubah!');
    }

    public function delete()
    {
        $tarifModel = new TarifModel();
        $id = $this->request->getPost('id_tarif');

        $tarifModel->delete($id);

        return redirect()->to('/admin/tarif')->with('success', 'Data tarif berhasil dihapus!');
    }
}
