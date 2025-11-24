<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'laporan_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'hafalan_id',
        'jenis_laporan',
        'tanggal_laporan'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'hafalan_id' => 'required|numeric',
        'jenis_laporan' => 'required|in_list[mingguan,bulanan,semesteran]',
        'tanggal_laporan' => 'required|valid_date'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get laporan with hafalan and santri information
     */
    public function getLaporanWithDetails()
    {
        $builder = $this->db->table('laporan l');
        $builder->select('l.*, h.juz, h.halaman, h.surat, h.tanggal_setor, h.status, s.nama_santri, s.kamar, s.kelas');
        $builder->join('hafalan h', 'l.hafalan_id = h.hafalan_id');
        $builder->join('santri s', 'h.santri_id = s.santri_id');
        $builder->orderBy('l.tanggal_laporan', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get laporan by jenis
     */
    public function getLaporanByJenis($jenis_laporan)
    {
        $builder = $this->db->table('laporan l');
        $builder->select('l.*, h.juz, h.halaman, h.surat, h.tanggal_setor, h.status, s.nama_santri, s.kamar, s.kelas');
        $builder->join('hafalan h', 'l.hafalan_id = h.hafalan_id');
        $builder->join('santri s', 'h.santri_id = s.santri_id');
        $builder->where('l.jenis_laporan', $jenis_laporan);
        $builder->orderBy('l.tanggal_laporan', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get laporan statistics
     */
    public function getLaporanStats()
    {
        $builder = $this->db->table('laporan');
        $builder->select('
            COUNT(*) as total_laporan,
            COUNT(CASE WHEN jenis_laporan = "mingguan" THEN 1 END) as laporan_mingguan,
            COUNT(CASE WHEN jenis_laporan = "bulanan" THEN 1 END) as laporan_bulanan,
            COUNT(CASE WHEN jenis_laporan = "semesteran" THEN 1 END) as laporan_semesteran
        ');
        
        return $builder->get()->getRowArray();
    }
}
