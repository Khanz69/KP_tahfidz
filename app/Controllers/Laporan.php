<?php

namespace App\Controllers;

use App\Models\LaporanModel;
use App\Models\HafalanModel;

class Laporan extends BaseController
{
    protected $laporanModel;
    protected $hafalanModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
        $this->hafalanModel = new HafalanModel();
    }

    public function index()
    {
        $openEditId = $this->request->getGet('edit_id');
        $prefillHafalanId = $this->request->getGet('prefill_hafalan_id') ?? $this->request->getGet('hafalan_id');

        $data = [
            'title' => 'Data Laporan - Sistem Monitoring Tahfidz',
            'laporan' => $this->laporanModel->getLaporanWithDetails(),
            'hafalan' => $this->hafalanModel->getHafalanWithSantri(),
            'openEditId' => $openEditId,
            'prefillHafalanId' => $prefillHafalanId
        ];

        return view('laporan/index', $data);
    }

    public function create()
    {
        $prefillHafalanId = $this->request->getGet('hafalan_id') ?? $this->request->getGet('prefill_hafalan_id');
        $redirectUrl = '/laporan';

        if ($prefillHafalanId) {
            $redirectUrl .= '?prefill_hafalan_id=' . urlencode($prefillHafalanId);
        }

        return redirect()->to($redirectUrl);
    }

    public function store()
    {
        $rules = [
            'hafalan_id' => 'required|numeric',
            'jenis_laporan' => 'required|in_list[mingguan,bulanan,semesteran]',
            'tanggal_laporan' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => $this->validator->getErrors()
                ]);
            }
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'hafalan_id' => $this->request->getPost('hafalan_id'),
            'jenis_laporan' => $this->request->getPost('jenis_laporan'),
            'tanggal_laporan' => $this->request->getPost('tanggal_laporan')
        ];

        if ($this->laporanModel->insert($data)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data laporan berhasil ditambahkan'
                ]);
            }
            return redirect()->to('/laporan')->with('success', 'Data laporan berhasil ditambahkan');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => $this->laporanModel->errors()
                ]);
            }
            return redirect()->back()->withInput()->with('errors', $this->laporanModel->errors());
        }
    }

    public function edit($id)
    {
        $laporan = $this->laporanModel->find($id);

        if (!$laporan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data laporan tidak ditemukan');
        }

        return redirect()->to('/laporan?edit_id=' . $id);
    }

    public function update($id)
    {
        $laporan = $this->laporanModel->find($id);
        
        if (!$laporan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data laporan tidak ditemukan');
        }

        $rules = [
            'hafalan_id' => 'required|numeric',
            'jenis_laporan' => 'required|in_list[mingguan,bulanan,semesteran]',
            'tanggal_laporan' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/laporan?edit_id=' . $id)
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'hafalan_id' => $this->request->getPost('hafalan_id'),
            'jenis_laporan' => $this->request->getPost('jenis_laporan'),
            'tanggal_laporan' => $this->request->getPost('tanggal_laporan')
        ];

        if ($this->laporanModel->update($id, $data)) {
            return redirect()->to('/laporan')->with('success', 'Data laporan berhasil diperbarui');
        } else {
            return redirect()->to('/laporan?edit_id=' . $id)
                ->withInput()
                ->with('errors', $this->laporanModel->errors());
        }
    }

    public function delete($id)
    {
        $laporan = $this->laporanModel->find($id);
        
        if (!$laporan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data laporan tidak ditemukan');
        }

        if ($this->laporanModel->delete($id)) {
            return redirect()->to('/laporan')->with('success', 'Data laporan berhasil dihapus');
        } else {
            return redirect()->to('/laporan')->with('error', 'Gagal menghapus data laporan');
        }
    }

    public function jenis($jenis)
    {
        if (!in_array($jenis, ['mingguan', 'bulanan', 'semesteran'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Jenis laporan tidak valid');
        }

        $data = [
            'title' => 'Laporan ' . ucfirst($jenis) . ' - Sistem Monitoring Tahfidz',
            'laporan' => $this->laporanModel->getLaporanByJenis($jenis),
            'jenis' => $jenis
        ];

        return view('laporan/jenis', $data);
    }

    public function print($id)
    {
        $laporan = $this->laporanModel->getLaporanWithDetails();
        $laporan = array_filter($laporan, function($item) use ($id) {
            return $item['laporan_id'] == $id;
        });
        
        if (empty($laporan)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data laporan tidak ditemukan');
        }

        $data = [
            'title' => 'Print Laporan - Sistem Monitoring Tahfidz',
            'laporan' => array_values($laporan)[0]
        ];

        return view('laporan/print', $data);
    }
}
