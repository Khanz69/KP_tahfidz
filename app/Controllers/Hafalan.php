<?php

namespace App\Controllers;

use App\Models\HafalanModel;
use App\Models\SantriModel;

class Hafalan extends BaseController
{
    protected $hafalanModel;
    protected $santriModel;

    public function __construct()
    {
        $this->hafalanModel = new HafalanModel();
        $this->santriModel = new SantriModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Hafalan - Sistem Monitoring Tahfidz',
            'hafalan' => $this->hafalanModel->getHafalanWithSantri(),
            'santri' => $this->santriModel->findAll(),
            'openEditId' => $this->request->getGet('edit_id'),
            'prefillSantriId' => $this->request->getGet('santri_id')
        ];

        return view('hafalan/index', $data);
    }

    public function create()
    {
        $santriId = $this->request->getGet('santri_id');
        $query = $santriId ? '?santri_id=' . urlencode($santriId) : '';

        return redirect()->to('/hafalan' . $query);
    }

    public function store()
    {
        $rules = [
            'santri_id' => 'required|numeric',
            'juz' => 'required|numeric|greater_than[0]|less_than[31]',
            'halaman' => 'permit_empty|numeric|greater_than[0]',
            'surat' => 'permit_empty|max_length[100]',
            'tanggal_setor' => 'required|valid_date',
            'status' => 'required|in_list[lulus,tidak_lulus]',
            'keterangan' => 'permit_empty'
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
            'santri_id' => $this->request->getPost('santri_id'),
            'juz' => $this->request->getPost('juz'),
            'halaman' => $this->request->getPost('halaman'),
            'surat' => $this->request->getPost('surat'),
            'tanggal_setor' => $this->request->getPost('tanggal_setor'),
            'status' => $this->request->getPost('status'),
            'keterangan' => $this->request->getPost('keterangan')
        ];

        if ($this->hafalanModel->insert($data)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data hafalan berhasil ditambahkan'
                ]);
            }
            return redirect()->to('/hafalan')->with('success', 'Data hafalan berhasil ditambahkan');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => $this->hafalanModel->errors()
                ]);
            }
            return redirect()->back()->withInput()->with('errors', $this->hafalanModel->errors());
        }
    }

    public function edit($id)
    {
        return redirect()->to('/hafalan?edit_id=' . $id);
    }

    public function update($id)
    {
        $hafalan = $this->hafalanModel->find($id);
        
        if (!$hafalan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data hafalan tidak ditemukan');
        }

        $rules = [
            'santri_id' => 'required|numeric',
            'juz' => 'required|numeric|greater_than[0]|less_than[31]',
            'halaman' => 'permit_empty|numeric|greater_than[0]',
            'surat' => 'permit_empty|max_length[100]',
            'tanggal_setor' => 'required|valid_date',
            'status' => 'required|in_list[lulus,tidak_lulus]',
            'keterangan' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'santri_id' => $this->request->getPost('santri_id'),
            'juz' => $this->request->getPost('juz'),
            'halaman' => $this->request->getPost('halaman'),
            'surat' => $this->request->getPost('surat'),
            'tanggal_setor' => $this->request->getPost('tanggal_setor'),
            'status' => $this->request->getPost('status'),
            'keterangan' => $this->request->getPost('keterangan')
        ];

        if ($this->hafalanModel->update($id, $data)) {
            return redirect()->to('/hafalan')->with('success', 'Data hafalan berhasil diperbarui');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->hafalanModel->errors());
        }
    }

    public function delete($id)
    {
        $hafalan = $this->hafalanModel->find($id);
        
        if (!$hafalan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data hafalan tidak ditemukan');
        }

        if ($this->hafalanModel->delete($id)) {
            return redirect()->to('/hafalan')->with('success', 'Data hafalan berhasil dihapus');
        } else {
            return redirect()->to('/hafalan')->with('error', 'Gagal menghapus data hafalan');
        }
    }

    public function filter()
    {
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');
        $status = $this->request->getGet('status');
        $santri_id = $this->request->getGet('santri_id');

        $builder = $this->hafalanModel->db->table('hafalan h');
        $builder->select('h.*, s.nama_santri, s.kamar, s.kelas');
        $builder->join('santri s', 'h.santri_id = s.santri_id');

        if ($start_date) {
            $builder->where('h.tanggal_setor >=', $start_date);
        }
        if ($end_date) {
            $builder->where('h.tanggal_setor <=', $end_date);
        }
        if ($status) {
            $builder->where('h.status', $status);
        }
        if ($santri_id) {
            $builder->where('h.santri_id', $santri_id);
        }

        $builder->orderBy('h.tanggal_setor', 'DESC');
        $hafalan = $builder->get()->getResultArray();

        $data = [
            'title' => 'Data Hafalan (Filtered) - Sistem Monitoring Tahfidz',
            'hafalan' => $hafalan,
            'santri' => $this->santriModel->findAll(),
            'filters' => [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'status' => $status,
                'santri_id' => $santri_id
            ]
        ];

        return view('hafalan/index', $data);
    }
}
