<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        $data['notices'] = $db->table('notices')
            ->where('status', 'Active')
            ->orderBy('created_at', 'DESC')
            ->limit(6)
            ->get()
            ->getResultArray();
        return view('welcome_message', $data);
    }

    public function verify_id($family_id)
    {
        $db = \Config\Database::connect();
        $citizen = $db->table('citizens')
            ->select('citizens.*, users.name')
            ->join('users', 'users.id = citizens.user_id')
            ->where('citizens.family_id', $family_id)
            ->get()
            ->getRowArray();

        if (!$citizen) {
            return "Invalid Identity Card - Citizen Record Not Found";
        }

        return view('public/verify_identity', ['citizen' => $citizen]);
    }

    public function login(): string
    {
        if (session()->get('user_id')) {
            if (session()->get('user_role') == 'admin') {
                return redirect()->to(base_url('admin/dashboard'));
            } else {
                return redirect()->to(base_url('user/dashboard'));
            }
        }
        return view('welcome_message');
    }
}
