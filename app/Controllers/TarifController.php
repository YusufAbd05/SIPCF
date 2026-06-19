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

        $jenis_sewa = $this->request->getPost('jenis_sewa');
        $harga = $this->request->getPost('harga');

        $harga_umum = ($jenis_sewa === 'Umum') ? $harga : 0;
        $harga_harian = ($jenis_sewa === 'Harian') ? $harga : 0;

        $data = [
            'id_lapang' => $this->request->getPost('id_lapang'),
            'nama_tarif' => $this->request->getPost('nama_tarif'),
            'hari' => $this->request->getPost('hari'),
            'jam_mulai' => $this->request->getPost('jam_mulai'),
            'jam_selesai' => $this->request->getPost('jam_selesai'),
            'harga_umum' => $harga_umum,
            'harga_harian' => $harga_harian,
        ];

        $tarifModel->insert($data);

        return redirect()->to('/admin/tarif')->with('success', 'Data tarif berhasil disimpan!');
    }

    public function update()
    {
        $tarifModel = new TarifModel();
        $id = $this->request->getPost('id_tarif');

        $jenis_sewa = $this->request->getPost('jenis_sewa');
        $harga = $this->request->getPost('harga');

        $harga_umum = ($jenis_sewa === 'Umum') ? $harga : 0;
        $harga_harian = ($jenis_sewa === 'Harian') ? $harga : 0;

        $data = [
            'id_lapang' => $this->request->getPost('id_lapang'),
            'nama_tarif' => $this->request->getPost('nama_tarif'),
            'hari' => $this->request->getPost('hari'),
            'jam_mulai' => $this->request->getPost('jam_mulai'),
            'jam_selesai' => $this->request->getPost('jam_selesai'),
            'harga_umum' => $harga_umum,
            'harga_harian' => $harga_harian,
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
