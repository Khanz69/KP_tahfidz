<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $returnType = 'object';
    protected $allowedFields = ['username', 'password', 'nama', 'role'];

    /**
     * Get a user row by username
     * @param string $username
     * @return object|null
     */
    public function getUser(string $username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Update user's password by id
     */
    public function updatePassword($id, $hash)
    {
        return $this->update($id, ['password' => $hash]);
    }
}
