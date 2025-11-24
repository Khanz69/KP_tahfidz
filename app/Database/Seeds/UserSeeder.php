<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => password_hash('AdminPass123!', PASSWORD_DEFAULT),
                'nama'     => 'Administrator',
                'role'     => 0, // admin
            ],
            [
                'username' => 'user',
                'password' => password_hash('UserPass123!', PASSWORD_DEFAULT),
                'nama'     => 'Regular User',
                'role'     => 1, // user
            ],
        ];

        $table = $this->db->table('user');
        foreach ($data as $row) {
            $exists = $table->where('username', $row['username'])->countAllResults(false);
            if ($exists == 0) {
                $table->insert($row);
            }
        }

        echo "Inserted admin and user accounts with numeric roles.\n";
    }
}
