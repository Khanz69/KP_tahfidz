<?php

namespace App\Controllers;

use App\Models\SantriModel;
use App\Models\HafalanModel;
use App\Models\LaporanModel;
use App\Models\UserModel;
use App\Models\LogImportModel;

class Dashboard extends BaseController
{
    protected $santriModel;
    protected $hafalanModel;
    protected $laporanModel;
    protected $userModel;
    protected $logImportModel;

    public function __construct()
    {
        $this->santriModel = new SantriModel();
        $this->hafalanModel = new HafalanModel();
        $this->laporanModel = new LaporanModel();
        $this->userModel = new UserModel();
        $this->logImportModel = new LogImportModel();
    }

    public function index()
    {
        // Get statistics
        $data = [
            'title' => 'Dashboard - Sistem Monitoring Tahfidz',
            'santri_stats' => $this->getSantriStats(),
            'hafalan_stats' => $this->hafalanModel->getHafalanStats(),
            'laporan_stats' => $this->laporanModel->getLaporanStats(),
            'user_stats' => $this->userModel->getUserStats(),
            'import_stats' => $this->logImportModel->getImportStats(),
            'recent_hafalan' => $this->getRecentHafalan(),
            'recent_imports' => $this->logImportModel->getRecentImports(5),
            'chart_data' => $this->getChartData()
        ];

        return view('dashboard/index', $data);
    }

    private function getSantriStats()
    {
        $builder = $this->santriModel->db->table('santri');
        $builder->select('
            COUNT(*) as total_santri,
            COUNT(DISTINCT angkatan) as total_angkatan,
            COUNT(DISTINCT kamar) as total_kamar,
            COUNT(DISTINCT kelas) as total_kelas
        ');
        
        return $builder->get()->getRowArray();
    }

    private function getRecentHafalan()
    {
        $builder = $this->hafalanModel->db->table('hafalan h');
        $builder->select('h.*, s.nama_santri, s.kamar, s.kelas');
        $builder->join('santri s', 'h.santri_id = s.santri_id');
        $builder->orderBy('h.tanggal_setor', 'DESC');
        $builder->limit(10);
        
        return $builder->get()->getResultArray();
    }

    private function getChartData()
    {
        // Data untuk chart hafalan per bulan (6 bulan terakhir)
        $builder = $this->hafalanModel->db->table('hafalan');
        $builder->select('
            DATE_FORMAT(tanggal_setor, "%Y-%m") as bulan,
            COUNT(*) as total_hafalan,
            COUNT(CASE WHEN status = "lulus" THEN 1 END) as hafalan_lulus,
            COUNT(CASE WHEN status = "tidak_lulus" THEN 1 END) as hafalan_tidak_lulus
        ');
        $builder->where('tanggal_setor >=', date('Y-m-01', strtotime('-5 months')));
        $builder->groupBy('DATE_FORMAT(tanggal_setor, "%Y-%m")');
        $builder->orderBy('bulan', 'ASC');
        
        return $builder->get()->getResultArray();
    }

    public function export()
    {
        // Export data functionality
        $data = [
            'title' => 'Export Data - Sistem Monitoring Tahfidz',
            'santri_data' => $this->santriModel->getSantriWithStats(),
            'hafalan_data' => $this->hafalanModel->getHafalanWithSantri(),
            'laporan_data' => $this->laporanModel->getLaporanWithDetails()
        ];

        return view('dashboard/export', $data);
    }
}
