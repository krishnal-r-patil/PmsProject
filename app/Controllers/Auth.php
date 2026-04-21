<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function index()
    {
        // If already logged in, redirect to respective dashboard
        if (session()->get('user_id')) {
            if (session()->get('user_role') == 'admin') {
                return redirect()->to(base_url('admin/dashboard'));
            } else {
                return redirect()->to(base_url('user/dashboard'));
            }
        }

        // Prevent browser back button from showing login page after login
        $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $this->response->setHeader('Pragma', 'no-cache');

        return view('login');
    }

    public function process()
    {
        $userModel = new \App\Models\UserModel();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if ($user && $password == $user['password']) {
            // Store user info in session
            session()->set('user_id', $user['id']);
            session()->set('user_role', $user['role']);
            session()->set('user_name', $user['name']);

            if ($user['role'] == 'admin') {
                return redirect()->to(base_url('admin/dashboard'));
            } else {
                return redirect()->to(base_url('user/dashboard'));
            }
        } else {
            return redirect()->back()->with('error', 'Invalid email or password');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
