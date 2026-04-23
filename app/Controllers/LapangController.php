<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LapangModel;

class LapangController extends BaseController
{
    public function index()
    {
        $lapangModel = new LapangModel();
        $lapangs = $lapangModel->findAll();

        // Hitung statistik
        $totalLapang = count($lapangs);
        $totalTersedia = count(array_filter($lapangs, fn($l) => $l['status_lapang'] === 'Tersedia'));
        $totalPerbaikan = count(array_filter($lapangs, fn($l) => $l['status_lapang'] === 'Perbaikan'));

        $data = [
            'lapangs' => $lapangs,
            'totalLapang' => $totalLapang,
            'totalTersedia' => $totalTersedia,
            'totalPerbaikan' => $totalPerbaikan,
        ];

        return view('admin/ViewLapang', $data);
    }

    public function save()
    {
        $lapangModel = new LapangModel();

        $data = [
            'nama_lapangan' => $this->request->getPost('nama_lapangan'),
            'spesifikasi_lapang' => $this->request->getPost('spesifikasi_lapang'),
            'status_lapang' => $this->request->getPost('status_lapang'),
            'jam_buka_weekday' => $this->request->getPost('jam_buka_weekday'),
            'jam_tutup_weekday' => $this->request->getPost('jam_tutup_weekday'),
            'jam_buka_weekend' => $this->request->getPost('jam_buka_weekend'),
            'jam_tutup_weekend' => $this->request->getPost('jam_tutup_weekend'),
        ];

        $lapangModel->insert($data);

        return redirect()->to('/admin/lapang')->with('success', 'Data lapang berhasil disimpan!');
    }

    public function update()
    {
        $lapangModel = new LapangModel();
        $id = $this->request->getPost('id_lapang');

        $data = [
            'nama_lapangan' => $this->request->getPost('nama_lapangan'),
            'spesifikasi_lapang' => $this->request->getPost('spesifikasi_lapang'),
            'status_lapang' => $this->request->getPost('status_lapang'),
            'jam_buka_weekday' => $this->request->getPost('jam_buka_weekday'),
            'jam_tutup_weekday' => $this->request->getPost('jam_tutup_weekday'),
            'jam_buka_weekend' => $this->request->getPost('jam_buka_weekend'),
            'jam_tutup_weekend' => $this->request->getPost('jam_tutup_weekend'),
        ];

        $lapangModel->update($id, $data);

        return redirect()->to('/admin/lapang')->with('success', 'Data lapang berhasil diubah!');
    }

    public function delete()
    {
        $lapangModel = new LapangModel();
        $id = $this->request->getPost('id_lapang');

        $lapangModel->delete($id);

        return redirect()->to('/admin/lapang')->with('success', 'Data lapang berhasil dihapus!');
    }
}
