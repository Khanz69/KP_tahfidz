<?php

namespace App\Models;

use CodeIgniter\Model;

class HafalanModel extends Model
{
    protected $table = 'hafalan';
    protected $primaryKey = 'hafalan_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'santri_id',
        'juz',
        'halaman',
        'surat',
        'tanggal_setor',
        'status',
        'keterangan'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'santri_id' => 'required|numeric',
        'juz' => 'required|numeric|greater_than[0]|less_than[31]',
        'halaman' => 'permit_empty|numeric|greater_than[0]',
        'surat' => 'permit_empty|max_length[100]',
        'tanggal_setor' => 'required|valid_date',
        'status' => 'required|in_list[lulus,tidak_lulus]',
        'keterangan' => 'permit_empty'
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
     * Get hafalan with santri information
     */
    public function getHafalanWithSantri()
    {
        $builder = $this->db->table('hafalan h');
        $builder->select('h.*, s.nama_santri, s.kamar, s.kelas');
        $builder->join('santri s', 'h.santri_id = s.santri_id');
        $builder->orderBy('h.tanggal_setor', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get hafalan by santri
     */
    public function getHafalanBySantri($santri_id)
    {
        $builder = $this->db->table('hafalan h');
        $builder->select('h.*, s.nama_santri');
        $builder->join('santri s', 'h.santri_id = s.santri_id');
        $builder->where('h.santri_id', $santri_id);
        $builder->orderBy('h.tanggal_setor', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get hafalan statistics
     */
    public function getHafalanStats()
    {
        $builder = $this->db->table('hafalan');
        $builder->select('
            COUNT(*) as total_hafalan,
            COUNT(CASE WHEN status = "lulus" THEN 1 END) as hafalan_lulus,
            COUNT(CASE WHEN status = "tidak_lulus" THEN 1 END) as hafalan_tidak_lulus,
            COUNT(DISTINCT santri_id) as total_santri_aktif
        ');
        
        return $builder->get()->getRowArray();
    }

    /**
     * Get hafalan by date range
     */
    public function getHafalanByDateRange($start_date, $end_date)
    {
        $builder = $this->db->table('hafalan h');
        $builder->select('h.*, s.nama_santri, s.kamar, s.kelas');
        $builder->join('santri s', 'h.santri_id = s.santri_id');
        $builder->where('h.tanggal_setor >=', $start_date);
        $builder->where('h.tanggal_setor <=', $end_date);
        $builder->orderBy('h.tanggal_setor', 'DESC');
        
        return $builder->get()->getResultArray();
    }
}
