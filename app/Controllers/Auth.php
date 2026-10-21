<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    private UserModel $users;

    public function __construct()
    {
        $this->users = new UserModel();
        helper(['form']);
    }

    public function registerView()
    {
        return view('auth/register');
    }

    public function register()
    {
        $rules = [
            'name'     => 'required|min_length[3]|max_length[120]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'confirm'  => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $this->users->insert([
            'name'       => $this->request->getPost('name'),
            'email'      => strtolower($this->request->getPost('email')),
            'password'   => $this->request->getPost('password'),
            'paypal_acc' => $this->request->getPost('paypal_acc'),
        ], true);

        session()->set([
            'isLoggedIn' => true,
            'userId'     => $user,
            'name'       => $this->request->getPost('name'),
            'role'       => 'user',
        ]);

        return redirect()->route('dashboard.index')->with('success', 'Akun berhasil dibuat. Selamat bertransaksi!');
    }

    public function loginView()
    {
        return view('auth/login');
    }

    public function login()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $this->users->where('email', strtolower($this->request->getPost('email')))->first();

        if ($user === null || ! password_verify($this->request->getPost('password'), $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        session()->set([
            'isLoggedIn' => true,
            'userId'     => (int) $user['id'],
            'name'       => $user['name'],
            'role'       => $user['role'],
        ]);

        return redirect()->to(route_to('dashboard.index'))->with('success', 'Login berhasil.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->route('home')->with('success', 'Anda telah keluar.');
    }
}
