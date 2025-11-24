<?php

namespace App\Models;

use CodeIgniter\Model;

class SantriModel extends Model
{
    protected $table = 'santri';
    protected $primaryKey = 'santri_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_santri',
        'kamar',
        'kelas',
        'angkatan',
        'tanggal_masuk'
    ];

    // Dates
    protected $useTimestamps = false; // Disable timestamps for now
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = null; // Table doesn't have updated_at column
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'nama_santri' => 'required|min_length[3]|max_length[100]',
        'kamar' => 'permit_empty|max_length[50]',
        'kelas' => 'permit_empty|max_length[50]',
        'angkatan' => 'permit_empty|integer|greater_than[1900]|less_than[2100]',
        'tanggal_masuk' => 'permit_empty|valid_date'
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
     * Get santri with hafalan statistics
     */
    public function getSantriWithStats()
    {
        $builder = $this->db->table('santri s');
        $builder->select('s.*, 
            COUNT(h.hafalan_id) as total_hafalan,
            COUNT(CASE WHEN h.status = "lulus" THEN 1 END) as hafalan_lulus,
            COUNT(CASE WHEN h.status = "tidak_lulus" THEN 1 END) as hafalan_tidak_lulus,
            MAX(h.tanggal_setor) as terakhir_setor');
        $builder->join('hafalan h', 's.santri_id = h.santri_id', 'left');
        $builder->groupBy('s.santri_id');
        $builder->orderBy('s.nama_santri', 'ASC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get santri by angkatan
     */
    public function getSantriByAngkatan($angkatan = null)
    {
        if ($angkatan) {
            return $this->where('angkatan', $angkatan)->findAll();
        }
        return $this->findAll();
    }
}
