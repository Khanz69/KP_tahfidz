<?php

namespace App\Models;

use CodeIgniter\Model;

class LogImportModel extends Model
{
    protected $table = 'log_import';
    protected $primaryKey = 'id_log';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id',
        'jumlah_data',
        'sumber_file'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'tanggal_import';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'user_id' => 'required|numeric',
        'jumlah_data' => 'required|numeric|greater_than[0]',
        'sumber_file' => 'permit_empty|max_length[255]'
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
     * Get log import with user information
     */
    public function getLogImportWithUser()
    {
        $builder = $this->db->table('log_import l');
        $builder->select('l.*, u.nama, u.username, u.role');
        $builder->join('user u', 'l.user_id = u.user_id');
        $builder->orderBy('l.tanggal_import', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get import statistics
     */
    public function getImportStats()
    {
        $builder = $this->db->table('log_import');
        $builder->select('
            COUNT(*) as total_import,
            SUM(jumlah_data) as total_data_imported,
            MAX(tanggal_import) as terakhir_import
        ');
        
        return $builder->get()->getRowArray();
    }

    /**
     * Get recent imports
     */
    public function getRecentImports($limit = 10)
    {
        $builder = $this->db->table('log_import l');
        $builder->select('l.*, u.nama, u.username');
        $builder->join('user u', 'l.user_id = u.user_id');
        $builder->orderBy('l.tanggal_import', 'DESC');
        $builder->limit($limit);
        
        return $builder->get()->getResultArray();
    }
}
