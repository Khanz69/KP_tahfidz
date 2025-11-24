<?php

namespace App\Controllers;

use App\Models\SantriModel;
use App\Models\HafalanModel;

class Santri extends BaseController
{
    protected $santriModel;
    protected $hafalanModel;

    public function __construct()
    {
        $this->santriModel = new SantriModel();
        $this->hafalanModel = new HafalanModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Santri - Sistem Monitoring Tahfidz',
            'santri' => $this->santriModel->getSantriWithStats()
        ];

        return view('santri/index', $data);
    }


    public function detail($id)
    {
        $santri = $this->santriModel->find($id);
        
        if (!$santri) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Santri tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Santri - ' . $santri['nama_santri'],
            'santri' => $santri,
            'hafalan' => $this->hafalanModel->getHafalanBySantri($id),
            'hafalan_stats' => $this->getHafalanStatsBySantri($id)
        ];

        return view('santri/detail', $data);
    }

    public function create()
    {
        return redirect()->to('/santri');
    }

    public function store()
    {
        try {
            // Debug: Log all incoming data
            log_message('debug', 'Store method called');
            log_message('debug', 'POST data: ' . json_encode($this->request->getPost()));
            log_message('debug', 'Is AJAX: ' . ($this->request->isAJAX() ? 'Yes' : 'No'));
            log_message('debug', 'Request method: ' . $this->request->getMethod());
            
            $rules = [
                'nama_santri' => 'required|min_length[3]|max_length[100]',
                'kamar' => 'permit_empty|max_length[50]',
                'kelas' => 'permit_empty|max_length[50]',
                'angkatan' => 'permit_empty|integer|greater_than[1900]|less_than[2100]',
                'tanggal_masuk' => 'permit_empty|valid_date'
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
                'nama_santri' => $this->request->getPost('nama_santri'),
                'kamar' => $this->request->getPost('kamar'),
                'kelas' => $this->request->getPost('kelas'),
                'angkatan' => $this->request->getPost('angkatan'),
                'tanggal_masuk' => $this->request->getPost('tanggal_masuk')
            ];

            // Debug: Log the data being inserted
            log_message('debug', 'Inserting santri data: ' . json_encode($data));

            $insertResult = $this->santriModel->insert($data);
            
            if ($insertResult) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Data santri berhasil ditambahkan',
                        'insert_id' => $insertResult
                    ]);
                }
                return redirect()->to('/santri')->with('success', 'Data santri berhasil ditambahkan');
            } else {
                $errors = $this->santriModel->errors();
                log_message('error', 'Santri insert failed: ' . json_encode($errors));
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'errors' => $errors,
                        'message' => 'Gagal menyimpan data santri'
                    ]);
                }
                return redirect()->back()->withInput()->with('errors', $errors);
            }
        } catch (\Exception $e) {
            log_message('error', 'Santri store exception: ' . $e->getMessage());
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        return redirect()->to('/santri');
    }

    public function update($id)
    {
        $santri = $this->santriModel->find($id);
        
        if (!$santri) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Santri tidak ditemukan');
        }

        $rules = [
            'nama_santri' => 'required|min_length[3]|max_length[100]',
            'kamar' => 'permit_empty|max_length[50]',
            'kelas' => 'permit_empty|max_length[50]',
            'angkatan' => 'permit_empty|numeric',
            'tanggal_masuk' => 'permit_empty|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_santri' => $this->request->getPost('nama_santri'),
            'kamar' => $this->request->getPost('kamar'),
            'kelas' => $this->request->getPost('kelas'),
            'angkatan' => $this->request->getPost('angkatan'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk')
        ];

        if ($this->santriModel->update($id, $data)) {
            return redirect()->to('/santri')->with('success', 'Data santri berhasil diperbarui');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->santriModel->errors());
        }
    }

    public function delete($id)
    {
        $santri = $this->santriModel->find($id);
        
        if (!$santri) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Santri tidak ditemukan');
        }
    
        if ($this->santriModel->delete($id)) {
            return redirect()->to('/santri')->with('success', 'Data santri berhasil dihapus');
        } else {
            return redirect()->to('/santri')->with('error', 'Gagal menghapus data santri');
        }
    }
    

    private function getHafalanStatsBySantri($santri_id)
    {
        $builder = $this->hafalanModel->db->table('hafalan');
        $builder->select('
            COUNT(*) as total_hafalan,
            COUNT(CASE WHEN status = "lulus" THEN 1 END) as hafalan_lulus,
            COUNT(CASE WHEN status = "tidak_lulus" THEN 1 END) as hafalan_tidak_lulus,
            MAX(tanggal_setor) as terakhir_setor,
            MIN(tanggal_setor) as pertama_setor
        ');
        $builder->where('santri_id', $santri_id);
        
        return $builder->get()->getRowArray();
    }
}
