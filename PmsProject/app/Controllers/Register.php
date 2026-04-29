<?php

namespace App\Controllers;

use App\Models\UserModel;

class Register extends BaseController
{
    public function index()
    {
        // Public registration view
        return view('register_citizen');
    }

    public function save()
    {
        $userModel = new UserModel();
        $db = \Config\Database::connect();

        // Start transaction for atomic insertion in users and citizens table
        $db->transStart();

        // 1. Create User Account
        $userData = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'), // In production use password_hash
            'role'     => 'user'
        ];
        
        $userModel->insert($userData);
        $userId = $userModel->getInsertID();

        // 2. Create Citizen Profile (Handling empty strings as NULL for optional fields)
        $citizenData = [
            'user_id'       => $userId,
            'father_name'   => $this->request->getPost('father_name'),
            'aadhar_no'     => $this->request->getPost('aadhar_no'),
            'voter_id'      => $this->request->getPost('voter_id') ?: null,
            'phone'         => $this->request->getPost('phone'),
            'gender'        => $this->request->getPost('gender'),
            'dob'           => $this->request->getPost('dob'),
            'category'      => $this->request->getPost('category'),
            'occupation'    => $this->request->getPost('occupation') ?: null,
            'house_no'      => $this->request->getPost('house_no') ?: null,
            'ward_no'       => $this->request->getPost('ward_no'),
            'village'       => $this->request->getPost('village'),
            'family_id'     => $this->request->getPost('family_id') ?: null
        ];

        $db->table('citizens')->insert($citizenData);

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Registration failed. Aadhar Number or Voter ID may already be registered.')->withInput();
        }

        // Check if admin is adding or it's self-registration
        if (session()->get('user_role') == 'admin') {
            return redirect()->to(base_url('admin/dashboard'))->with('success', 'New Citizen registered successfully!');
        }

        return redirect()->to(base_url('login'))->with('success', 'Registration successful! Please login.');
    }
}
