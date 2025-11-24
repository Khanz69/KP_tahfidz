<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Show login form
     */
    public function index()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('userSession')) {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Login - Sistem Monitoring Tahfidz'
        ];

        return view('auth/login', $data);
    }

    /**
     * Handle authentication
     */
    public function auth()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->verifyUser($username, $password);

        if ($user) {
            // Normalize role to integer if possible (support older string roles temporarily)
            if (isset($user['role'])) {
                // If role is textual (e.g., 'admin' or 'user'), map to numeric values
                if (!is_numeric($user['role'])) {
                    $map = [
                        'admin' => 0,
                        'user' => 1,
                    ];
                    $user['role'] = $map[$user['role']] ?? $user['role'];
                }

                // Cast to int if numeric string
                if (is_numeric($user['role'])) {
                    $user['role'] = (int) $user['role'];
                }
            }

            // Set session in teacher's format: userSession and userData (object)
            $sess = [
                'userSession' => true,
                'userData' => (object) $user,
            ];

            session()->set($sess);

            return redirect()->to('/dashboard')->with('success', 'Berhasil login.');
        }

        return redirect()->back()->withInput()->with('error', 'Username atau password salah.');
    }

    /**
     * Logout the user
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah logout.');
    }
}
