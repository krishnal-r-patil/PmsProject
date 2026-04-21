<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Count Total Residents
        $data['total_residents'] = $db->table('citizens')->countAll();
        
        // Count Total Approved Certificates
        $data['total_approved'] = $db->table('applications')->where('status', 'Approved')->countAll();
        
        // Count Pending Applications
        $data['total_pending'] = $db->table('applications')->where('status', 'Pending')->countAll();
        
        // Count Revenue (Example)
        $data['total_revenue'] = $db->table('taxes')->where('status', 'Paid')->selectSum('amount')->get()->getRow()->amount ?? 0;

        // Fetch Recent Applications for table
        $data['recent_apps'] = $db->table('applications')
                                  ->select('applications.*, users.name as citizen_name')
                                  ->join('users', 'users.id = applications.user_id')
                                  ->orderBy('applied_at', 'DESC')
                                  ->limit(5)
                                  ->get()->getResultArray();

        // Prevent back-button from showing dashboard after logout
        $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $this->response->setHeader('Pragma', 'no-cache');

        return view('admin/dashboard', $data);
    }



    public function residents()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('citizens');
        $builder->select('citizens.*, users.name, users.email');
        $builder->join('users', 'users.id = citizens.user_id');
        $query = $builder->get();

        $data['residents'] = $query->getResultArray();
        
        return view('admin/residents_list', $data);
    }

    public function view_resident($id)
    {
        $db = \Config\Database::connect();
        $resident = $db->table('citizens')
            ->select('citizens.*, users.name, users.email')
            ->join('users', 'users.id = citizens.user_id')
            ->where('citizens.id', $id)
            ->get()->getRowArray();

        if (!$resident) {
            return redirect()->to(base_url('admin/residents'))->with('error', 'Resident not found.');
        }

        return view('admin/resident_view', ['resident' => $resident]);
    }

    public function edit_resident($id)
    {
        $db = \Config\Database::connect();
        $resident = $db->table('citizens')
            ->select('citizens.*, users.name, users.email')
            ->join('users', 'users.id = citizens.user_id')
            ->where('citizens.id', $id)
            ->get()->getRowArray();

        if (!$resident) {
            return redirect()->to(base_url('admin/residents'))->with('error', 'Resident not found.');
        }

        return view('admin/resident_edit', ['resident' => $resident]);
    }

    public function save_resident($id)
    {
        $db = \Config\Database::connect();

        $updateData = [
            'father_name'    => $this->request->getPost('father_name'),
            'aadhar_no'      => $this->request->getPost('aadhar_no'),
            'voter_id'       => $this->request->getPost('voter_id'),
            'phone'          => $this->request->getPost('phone'),
            'gender'         => $this->request->getPost('gender'),
            'dob'            => $this->request->getPost('dob'),
            'category'       => $this->request->getPost('category'),
            'occupation'     => $this->request->getPost('occupation'),
            'income_annual'  => $this->request->getPost('income_annual'),
            'house_no'       => $this->request->getPost('house_no'),
            'ward_no'        => $this->request->getPost('ward_no'),
            'village'        => $this->request->getPost('village'),
            'block'          => $this->request->getPost('block'),
            'district'       => $this->request->getPost('district'),
            'family_id'      => $this->request->getPost('family_id'),
        ];

        $db->table('citizens')->where('id', $id)->update($updateData);

        // Also update the name in users table
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        if ($name) {
            $resident = $db->table('citizens')->where('id', $id)->get()->getRowArray();
            if ($resident) {
                $db->table('users')->where('id', $resident['user_id'])->update(['name' => $name, 'email' => $email]);
            }
        }

        return redirect()->to(base_url('admin/residents'))->with('success', 'Resident updated successfully.');
    }

    public function delete_resident($id)
    {
        $db = \Config\Database::connect();
        // Get citizen to find user_id
        $resident = $db->table('citizens')->where('id', $id)->get()->getRowArray();
        if ($resident) {
            // Delete citizen record (user deletion cascades)
            $db->table('citizens')->where('id', $id)->delete();
        }
        return redirect()->to(base_url('admin/residents'))->with('success', 'Resident deleted successfully.');
    }

    public function applications()
    {
        $db = \Config\Database::connect();
        $data['applications'] = $db->table('applications')
            ->select('applications.*, users.name as user_name')
            ->join('users', 'users.id = applications.user_id')
            ->orderBy('applied_at', 'DESC')
            ->get()
            ->getResultArray();
        return view('admin/applications_list', $data);
    }

    public function update_status()
    {
        $db = \Config\Database::connect();
        $table = $this->request->getPost('table'); // applications, grievances, or permissions
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        $remarks = $this->request->getPost('remarks');

        $updateData = ['status' => $status];
        if (!empty($remarks)) {
            $updateData['remarks'] = $remarks;
        }

        $db->table($table)->where('id', $id)->update($updateData);

        return redirect()->back()->with('success', 'Status updated successfully with remarks.');
    }

    public function grievances()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('grievances');
        $builder->select('grievances.*, users.name as citizen_name');
        $builder->join('users', 'users.id = grievances.user_id');
        $builder->orderBy('grievances.created_at', 'DESC');
        $data['grievances'] = $builder->get()->getResultArray();
        return view('admin/grievances_list', $data);
    }

    public function assets()
    {
        $db = \Config\Database::connect();
        $data['assets'] = $db->table('assets')->get()->getResultArray();
        return view('admin/assets_list', $data);
    }

    public function village_map()
    {
        $db = \Config\Database::connect();
        $data['assets'] = $db->table('assets')
            ->where('latitude IS NOT NULL')
            ->where('longitude IS NOT NULL')
            ->get()->getResultArray();
        return view('admin/village_map', $data);
    }

    public function schemes()
    {
        $db = \Config\Database::connect();
        $data['schemes'] = $db->table('schemes')->get()->getResultArray();
        return view('admin/schemes_list', $data);
    }

    public function save_scheme()
    {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        $data = [
            'title'                => $this->request->getPost('title'),
            'description'          => $this->request->getPost('description'),
            'eligibility_criteria' => $this->request->getPost('eligibility_criteria'),
            'benefit_details'      => $this->request->getPost('benefit_details'),
            'benefit_amount'       => $this->request->getPost('benefit_amount') ?: 0,
            'status'               => $this->request->getPost('status') ?: 'Active'
        ];

        if ($id) {
            $db->table('schemes')->where('id', $id)->update($data);
            $msg = 'Scheme updated successfully.';
        } else {
            $db->table('schemes')->insert($data);
            $msg = 'New government scheme launched.';
        }
        return redirect()->to(base_url('admin/schemes'))->with('success', $msg);
    }

    public function delete_scheme($id)
    {
        $db = \Config\Database::connect();
        $db->table('schemes')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/schemes'))->with('success', 'Scheme decommissioned.');
    }


    public function meetings()
    {
        $db = \Config\Database::connect();
        $data['meetings'] = $db->table('meetings')->orderBy('meeting_date', 'DESC')->get()->getResultArray();
        return view('admin/meetings_list', $data);
    }

    public function save_meeting()
    {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        $data = [
            'title'        => $this->request->getPost('title'),
            'meeting_date' => $this->request->getPost('meeting_date'),
            'meeting_type' => $this->request->getPost('meeting_type'),
            'venue'        => $this->request->getPost('venue'),
            'agenda'       => $this->request->getPost('agenda'),
            'status'       => $this->request->getPost('status') ?: 'Scheduled'
        ];

        if ($id) {
            $db->table('meetings')->where('id', $id)->update($data);
            $msg = 'Meeting scheduled updated.';
        } else {
            $db->table('meetings')->insert($data);
            $msg = 'New meeting scheduled.';
        }
        return redirect()->to(base_url('admin/meetings'))->with('success', $msg);
    }

    public function delete_meeting($id)
    {
        $db = \Config\Database::connect();
        $db->table('meetings')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/meetings'))->with('success', 'Meeting removed from calendar.');
    }


    public function staff()
    {
        $db = \Config\Database::connect();
        $data['staff'] = $db->table('staff')->orderBy('department', 'ASC')->orderBy('name', 'ASC')->get()->getResultArray();
        return view('admin/staff_list', $data);
    }

    public function add_staff()
    {
        $db = \Config\Database::connect();
        $db->table('staff')->insert([
            'name'         => $this->request->getPost('name'),
            'designation'  => $this->request->getPost('designation'),
            'department'   => $this->request->getPost('department'),
            'phone'        => $this->request->getPost('phone'),
            'email'        => $this->request->getPost('email') ?: null,
            'ward_no'      => $this->request->getPost('ward_no') ?: null,
            'joining_date' => $this->request->getPost('joining_date'),
            'salary'       => $this->request->getPost('salary') ?: null,
            'status'       => $this->request->getPost('status') ?: 'Active',
            'address'      => $this->request->getPost('address') ?: null,
        ]);
        return redirect()->to(base_url('admin/staff'))->with('success', '✓ Staff member <strong>' . esc($this->request->getPost('name')) . '</strong> has been registered successfully.');
    }

    public function edit_staff($id)
    {
        $db = \Config\Database::connect();
        $db->table('staff')->where('id', $id)->update([
            'name'         => $this->request->getPost('name'),
            'designation'  => $this->request->getPost('designation'),
            'department'   => $this->request->getPost('department'),
            'phone'        => $this->request->getPost('phone'),
            'email'        => $this->request->getPost('email') ?: null,
            'ward_no'      => $this->request->getPost('ward_no') ?: null,
            'joining_date' => $this->request->getPost('joining_date'),
            'salary'       => $this->request->getPost('salary') ?: null,
            'status'       => $this->request->getPost('status'),
            'address'      => $this->request->getPost('address') ?: null,
        ]);
        return redirect()->to(base_url('admin/staff'))->with('success', '✓ Staff record updated successfully.');
    }

    public function delete_staff($id)
    {
        $db = \Config\Database::connect();
        $staff = $db->table('staff')->where('id', $id)->get()->getRowArray();
        $db->table('staff')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/staff'))->with('success', '✓ Staff member <strong>' . esc($staff['name'] ?? '') . '</strong> has been removed from records.');
    }

    public function elearning()
    {
        $db = \Config\Database::connect();
        $data['resources'] = $db->table('elearning')->orderBy('created_at', 'DESC')->get()->getResultArray();
        return view('admin/elearning_admin', $data);
    }

    public function save_elearning()
    {
        $db = \Config\Database::connect();
        $db->table('elearning')->insert([
            'title'       => $this->request->getPost('title'),
            'category'    => $this->request->getPost('category'),
            'description' => $this->request->getPost('description'),
            'provider'    => $this->request->getPost('provider'),
            'link'        => $this->request->getPost('link'),
            'deadline'    => $this->request->getPost('deadline') ?: null,
            'status'      => 'Active'
        ]);
        return redirect()->to(base_url('admin/elearning'))->with('success', 'Resource added successfully.');
    }

    public function update_elearning($id)
    {
        $db = \Config\Database::connect();
        $db->table('elearning')->where('id', $id)->update([
            'title'       => $this->request->getPost('title'),
            'category'    => $this->request->getPost('category'),
            'description' => $this->request->getPost('description'),
            'provider'    => $this->request->getPost('provider'),
            'link'        => $this->request->getPost('link'),
            'deadline'    => $this->request->getPost('deadline') ?: null,
        ]);
        return redirect()->to(base_url('admin/elearning'))->with('success', 'Resource updated successfully.');
    }

    public function delete_elearning($id)
    {
        $db = \Config\Database::connect();
        $db->table('elearning')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/elearning'))->with('success', 'Resource deleted successfully.');
    }

    public function permissions()
    {
        $db = \Config\Database::connect();
        $data['permissions'] = $db->table('permissions')
            ->select('permissions.*, users.name as user_name')
            ->join('users', 'users.id = permissions.user_id')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();
        return view('admin/permissions_list', $data);
    }

    public function accounts()
    {
        $db = \Config\Database::connect();
        $data['vouchers'] = $db->table('vouchers')->orderBy('date', 'DESC')->get()->getResultArray();
        return view('admin/accounts_list', $data);
    }

    public function register_docs()
    {
        $db      = \Config\Database::connect();
        $records = $db->table('birth_death_register')->orderBy('date_of_event', 'DESC')->get()->getResultArray();
        $users   = $db->table('users')->where('role', 'user')->select('id, name, email')->get()->getResultArray();
        
        return view('admin/register_docs', [
            'records' => $records,
            'users'   => $users
        ]);
    }

    public function save_register_doc()
    {
        $db   = \Config\Database::connect();
        $type = $this->request->getPost('type');
        $year = date('Y');

        // ── Safe auto-increment registration number ──────────────────────────
        // Each type has its own prefix; we find the highest existing number for
        // that prefix and add 1, avoiding collisions on concurrent saves.
        if ($type === 'Death') {
            $prefix = "CRS/{$year}/D-";
        } else {
            // Birth records
            $prefix = "CRS/{$year}/";
        }

        // Pull the highest existing reg_no for this prefix group
        if ($type === 'Death') {
            $row = $db->query(
                "SELECT MAX(CAST(REPLACE(registration_no, 'CRS/{$year}/D-', '') AS UNSIGNED)) AS maxnum
                 FROM birth_death_register
                 WHERE registration_no LIKE 'CRS/{$year}/D-%'"
            )->getRowArray();
        } else {
            // Birth — exclude Death rows (which have 'D-')
            $row = $db->query(
                "SELECT MAX(CAST(REPLACE(registration_no, 'CRS/{$year}/', '') AS UNSIGNED)) AS maxnum
                 FROM birth_death_register
                 WHERE registration_no LIKE 'CRS/{$year}/%'
                   AND registration_no NOT LIKE 'CRS/{$year}/D-%'"
            )->getRowArray();
        }

        $nextNum = (int)($row['maxnum'] ?? 0) + 1;
        $reg_no  = $prefix . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        // ── Build insert data ────────────────────────────────────────────────
        $record = [
            'registration_no'    => $reg_no,
            'type'               => $type,
            'person_name'        => $this->request->getPost('person_name'),
            'gender'             => $this->request->getPost('gender'),
            'age_at_event'       => (int)($this->request->getPost('age_at_event') ?? 0),
            'father_mother_name' => $this->request->getPost('father_mother_name'),
            'informant_name'     => $this->request->getPost('informant_name'),
            'date_of_event'      => $this->request->getPost('date_of_event'),
            'place_of_event'     => $this->request->getPost('place_of_event'),
            'village_ward'       => $this->request->getPost('village_ward'),
            'remarks'            => $this->request->getPost('remarks') ?: null,
            'sub_caste'          => $this->request->getPost('sub_caste') ?: null,
            // Type-specific fields
            'cause_of_death'     => ($type === 'Death')
                                        ? ($this->request->getPost('cause_of_death') ?: null)
                                        : null,
            'weight_at_birth'    => ($type === 'Birth')
                                        ? ($this->request->getPost('weight_at_birth') ?: null)
                                        : null,
        ];

        try {
            $db->table('birth_death_register')->insert($record);
            return redirect()->to(base_url('admin/register-docs'))
                             ->with('success', "✓ {$type} record registered successfully as <strong>{$reg_no}</strong>.");
        } catch (\Exception $e) {
            log_message('error', 'CRS Insert error: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }

    public function export_register()
    {
        $db = \Config\Database::connect();
        $selectedIds = $this->request->getPost('selected_ids');
        
        $builder = $db->table('birth_death_register');
        
        if (!empty($selectedIds)) {
            $builder->whereIn('id', $selectedIds);
        }
        
        $records = $builder->orderBy('date_of_event', 'DESC')->get()->getResultArray();

        $filename = 'CRS_Register_' . date('Y-m-d') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        // UTF-8 BOM for Excel compatibility
        fputs($output, "\xEF\xBB\xBF");

        // Header row
        fputcsv($output, [
            'Registration No', 'Type', 'Person Name', 'Gender', 'Age',
            'Father/Mother Name', 'Informant', 'Date of Event',
            'Cause of Death', 'Birth Weight (kg)', 'Place of Event',
            'Ward/Village', 'Remarks', 'Recorded At'
        ]);

        foreach ($records as $r) {
            fputcsv($output, [
                $r['registration_no'],
                $r['type'],
                $r['person_name'],
                $r['gender'],
                $r['age_at_event'],
                $r['father_mother_name'],
                $r['informant_name'],
                $r['date_of_event'],
                $r['cause_of_death'] ?? '',
                $r['weight_at_birth'] ?? '',
                $r['place_of_event'],
                $r['village_ward'],
                $r['remarks'] ?? '',
                $r['created_at'],
            ]);
        }

        fclose($output);
        exit;
    }

    public function view_certificate($id)
    {
        $db = \Config\Database::connect();
        $record = $db->table('birth_death_register')->where('id', $id)->get()->getRowArray();
        
        if (!$record) return "Record not found";

        $lang = $this->request->getGet('lang') ?? 'bilingual';
        
        return view('admin/certificate_template', [
            'record' => $record,
            'lang'   => $lang
        ]);
    }

    public function issue_certificate($id)
    {
        $db = \Config\Database::connect();
        $userId = $this->request->getPost('user_id');
        
        $user = $db->table('users')->where('id', $userId)->get()->getRowArray();
        $record = $db->table('birth_death_register')->where('id', $id)->get()->getRowArray();

        $db->table('birth_death_register')->where('id', $id)->update([
            'linked_user_id' => $userId,
            'is_issued'      => 1
        ]);

        return redirect()->back()->with('success', "✓ Official {$record['type']} Certificate for <strong>{$record['person_name']}</strong> has been issued and sent to <strong>{$user['name']}</strong>.");
    }

    public function get_register_record($id)
    {
        $db = \Config\Database::connect();
        $record = $db->table('birth_death_register')->where('id', $id)->get()->getRowArray();
        return $this->response->setJSON($record);
    }

    public function update_register_doc($id)
    {
        $db = \Config\Database::connect();
        
        $data = [
            'person_name'        => $this->request->getPost('person_name'),
            'gender'             => $this->request->getPost('gender'),
            'age_at_event'       => (int)($this->request->getPost('age_at_event') ?? 0),
            'father_mother_name' => $this->request->getPost('father_mother_name'),
            'informant_name'     => $this->request->getPost('informant_name'),
            'date_of_event'      => $this->request->getPost('date_of_event'),
            'place_of_event'     => $this->request->getPost('place_of_event'),
            'village_ward'       => $this->request->getPost('village_ward'),
            'cause_of_death'     => $this->request->getPost('cause_of_death') ?: null,
            'weight_at_birth'    => $this->request->getPost('weight_at_birth') ?: null,
            'remarks'            => $this->request->getPost('remarks') ?: null,
        ];
        
        try {
            $db->table('birth_death_register')->where('id', $id)->update($data);
            return redirect()->to(base_url('admin/register-docs'))->with('success', '✓ Record updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    public function cert_approvals()
    {
        $db = \Config\Database::connect();
        $data['apps'] = $db->table('applications')
            ->select('applications.*, users.name as user_name')
            ->join('users', 'users.id = applications.user_id')
            ->whereIn('service_type', ['Birth Certificate', 'Death Certificate', 'Income Certificate', 'Caste Certificate', 'Domicile Certificate'])
            ->orderBy('applied_at', 'DESC')
            ->get()
            ->getResultArray();
        
        $data['registry'] = $db->table('birth_death_register')->select('id, registration_no, person_name, type')->get()->getResultArray();
            
        return view('admin/cert_approvals', $data);
    }

    public function process_cert_approval($id)
    {
        $db     = \Config\Database::connect();
        
        // --- On-Demand Migration: Ensure columns exist ---
        $db->query("ALTER TABLE birth_death_register ADD COLUMN IF NOT EXISTS profession VARCHAR(255) DEFAULT NULL");
        $db->query("ALTER TABLE birth_death_register ADD COLUMN IF NOT EXISTS annual_income VARCHAR(255) DEFAULT NULL");
        $db->query("ALTER TABLE birth_death_register ADD COLUMN IF NOT EXISTS financial_year VARCHAR(100) DEFAULT NULL");
        $db->query("ALTER TABLE birth_death_register MODIFY COLUMN annual_income VARCHAR(255)");
        $db->query("ALTER TABLE birth_death_register MODIFY COLUMN profession VARCHAR(255)");
        $db->query("ALTER TABLE birth_death_register ADD COLUMN IF NOT EXISTS category VARCHAR(50) DEFAULT NULL");
        $db->query("ALTER TABLE birth_death_register ADD COLUMN IF NOT EXISTS caste_name VARCHAR(100) DEFAULT NULL");
        $db->query("ALTER TABLE birth_death_register ADD COLUMN IF NOT EXISTS sub_caste VARCHAR(100) DEFAULT NULL");
        $db->query("ALTER TABLE birth_death_register ADD COLUMN IF NOT EXISTS religion VARCHAR(100) DEFAULT NULL");
        $db->query("ALTER TABLE birth_death_register ADD COLUMN IF NOT EXISTS stay_duration VARCHAR(50) DEFAULT NULL");
        $db->query("ALTER TABLE birth_death_register ADD COLUMN IF NOT EXISTS id_proof_no VARCHAR(100) DEFAULT NULL");

        $action = $this->request->getPost('action'); // Approve or Reject
        $remarks = $this->request->getPost('remarks');
        
        if ($action === 'Approve') {
            $app   = $db->table('applications')->where('id', $id)->get()->getRowArray();
            $data  = json_decode($app['application_data'], true);
            // --- Generate Official Reg No ---
            $year = date('Y');
            // Determine registry type and prefix
            if ($app['service_type'] === 'Birth Certificate') {
                $type = 'Birth';
                $prefix = "CRS/{$year}/";
            } elseif ($app['service_type'] === 'Death Certificate') {
                $type = 'Death';
                $prefix = "CRS/{$year}/D-";
            } elseif ($app['service_type'] === 'Income Certificate') {
                $type = 'Income';
                $prefix = "INC/{$year}/";
            } elseif ($app['service_type'] === 'Caste Certificate') {
                $type = 'Caste';
                $prefix = "CST/{$year}/";
            } elseif ($app['service_type'] === 'Domicile Certificate') {
                $type = 'Domicile';
                $prefix = "DOM/{$year}/";
            } else {
                $type = 'Income';
                $prefix = "INC/{$year}/";
            }

            $row = $db->query("SELECT MAX(CAST(REPLACE(registration_no, '$prefix', '') AS UNSIGNED)) AS maxnum FROM birth_death_register WHERE registration_no LIKE '$prefix%'")->getRowArray();
            $nextNum = (int)($row['maxnum'] ?? 0) + 1;
            $reg_no  = $prefix . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

            // --- Create Official Registry Record from Form Data ---
            $recordData = [
                'registration_no'    => $reg_no,
                'type'               => $type,
                'person_name'        => $data['person_name'] ?? ($app['user_name'] ?? 'N/A'),
                'gender'             => $data['gender'] ?? 'N/A',
                'father_mother_name' => ($data['father_name'] ?? ($data['father'] ?? 'N/A')) . " & " . ($data['mother_name'] ?? 'N/A'),
                'date_of_event'      => $data['date_of_event'] ?? date('Y-m-d'),
                'place_of_event'     => $data['place_of_event'] ?? ($data['house'] ?? 'Panchayat Area'),
                'village_ward'       => $data['village_ward'] ?? 'Panchayat Area',
                'age_at_event'       => $data['age_at_event'] ?? 0,
                'linked_user_id'     => $app['user_id'],
                'is_issued'          => 1,
                'remarks'            => "Generated from Application #$id",
                'weight_at_birth'    => $data['weight_at_birth'] ?? null,
                'cause_of_death'     => $data['cause_of_death'] ?? null,
                'category'           => $data['category'] ?? null,
                'caste_name'         => $data['caste_name'] ?? null,
                'sub_caste'          => $data['sub_caste'] ?? null,
                'religion'           => $data['religion'] ?? null,
                'stay_duration'      => $data['stay_duration'] ?? null,
                'id_proof_no'        => $data['id_proof_no'] ?? null,
                'annual_income'      => $data['annual_income'] ?? null,
                'financial_year'     => $data['financial_year'] ?? null,
                'profession'         => $data['profession'] ?? null,
            ];
            
            $db->table('birth_death_register')->insert($recordData);
            $newRegId = $db->insertID();
            
            // --- Update application with final link ---
            $db->table('applications')->where('id', $id)->update([
                'status'         => 'Approved',
                'certificate_id' => $newRegId,
                'remarks'        => 'Approved: Certificate Generated & Issued'
            ]);
            
            return redirect()->to(base_url('admin/cert-approvals'))->with('success', "✓ Generated! Official {$type} Certificate (#{$reg_no}) was created from the application and sent to the user.");
        } else {
            // Reject
            $db->table('applications')->where('id', $id)->update([
                'status'  => 'Rejected',
                'remarks' => $remarks
            ]);
            return redirect()->to(base_url('admin/cert-approvals'))->with('success', 'Application rejected successfully.');
        }
    }

    public function complaints()
    {
        $db = \Config\Database::connect();
        $data['complaints'] = $db->table('grievances')
            ->select('grievances.*, users.name as citizen_name')
            ->join('users', 'users.id = grievances.user_id')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('admin/complaints', $data);
    }

    public function process_complaint($id)
    {
        $db = \Config\Database::connect();
        $status = $this->request->getPost('status');
        $remarks = $this->request->getPost('remarks');

        $db->table('grievances')->where('id', $id)->update([
            'status' => $status,
            'remarks' => $remarks
        ]);

    }

    public function scheme_applications()
    {
        $db = \Config\Database::connect();
        $data['applications'] = $db->table('scheme_applications')
            ->select('scheme_applications.*, users.name as citizen_name, schemes.title as scheme_title')
            ->join('users', 'users.id = scheme_applications.user_id')
            ->join('schemes', 'schemes.id = scheme_applications.scheme_id')
            ->orderBy('applied_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('admin/scheme_applications', $data);
    }

    public function process_scheme_application($id)
    {
        $db = \Config\Database::connect();
        $status = $this->request->getPost('status');
        $remarks = $this->request->getPost('remarks');

        // Fetch application and scheme details
        $app = $db->table('scheme_applications')->where('id', $id)->get()->getRowArray();
        $scheme = $db->table('schemes')->where('id', $app['scheme_id'])->get()->getRowArray();

        $db->table('scheme_applications')->where('id', $id)->update([
            'status' => $status,
            'remarks' => $remarks
        ]);

        // Automatically create a ledger entry if Approved
        if ($status == 'Approved') {
            $txn_id = 'TXN-' . strtoupper(substr($scheme['title'], 0, 3)) . '-' . mt_rand(1000, 9999);
            
            $db->table('transactions')->insert([
                'user_id' => $app['user_id'],
                'type' => 'Credit',
                'title' => 'Approved: ' . $scheme['title'],
                'category' => 'Govt Fund',
                'amount' => $scheme['benefit_amount'] ?: 0,
                'status' => 'Completed',
                'transaction_id' => $txn_id,
                'reference_note' => 'Automatic grant disbursement upon scheme enrollment approval.'
            ]);
        }

        return redirect()->to(base_url('admin/scheme-applications'))->with('success', 'Scheme application updated' . ($status == 'Approved' ? ' and funds disbursed to citizen ledger.' : '.'));
    }

    public function transactions()
    {
        $db = \Config\Database::connect();
        $data['transactions'] = $db->table('transactions')
            ->select('transactions.*, users.name as citizen_name')
            ->join('users', 'users.id = transactions.user_id')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data['users'] = $db->table('users')->where('role', 'user')->get()->getResultArray();

        return view('admin/transactions', $data);
    }

    public function add_transaction()
    {
        $db = \Config\Database::connect();
        $user_id = $this->request->getPost('user_id');
        $type = $this->request->getPost('type');
        $amount = $this->request->getPost('amount');
        $title = $this->request->getPost('title');
        $category = $this->request->getPost('category');

        $txn_id = 'TXN-MAN-' . mt_rand(100000, 999999);

        $db->table('transactions')->insert([
            'user_id' => $user_id,
            'type' => $type,
            'title' => $title,
            'category' => $category,
            'amount' => $amount,
            'status' => 'Completed',
            'transaction_id' => $txn_id,
            'reference_note' => 'Manually posted by Administrator.'
        ]);

        return redirect()->to(base_url('admin/transactions'))->with('success', 'Transaction posted successfully to citizen ledger.');
    }

    public function tax_collection()
    {
        $db = \Config\Database::connect();
        
        // Fetch stats
        $stats = [
            'total_demand' => $db->table('taxes')->selectSum('amount')->get()->getRow()->amount ?? 0,
            'total_collected' => $db->table('taxes')->where('status', 'Paid')->selectSum('amount')->get()->getRow()->amount ?? 0,
            'total_pending' => $db->table('taxes')->where('status', 'Unpaid')->selectSum('amount')->get()->getRow()->amount ?? 0,
        ];
        $stats['collection_rate'] = $stats['total_demand'] > 0 ? round(($stats['total_collected'] / $stats['total_demand']) * 100, 1) : 0;

        $data['stats'] = $stats;
        $data['taxes'] = $db->table('taxes')
            ->select('taxes.*, users.name as citizen_name')
            ->join('users', 'users.id = taxes.user_id')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();

        $data['users'] = $db->table('users')->where('role', 'user')->get()->getResultArray();

        return view('admin/tax_collection', $data);
    }

    public function demand_tax()
    {
        $db = \Config\Database::connect();
        $db->table('taxes')->insert([
            'user_id' => $this->request->getPost('user_id'),
            'tax_type' => $this->request->getPost('tax_type'),
            'amount' => $this->request->getPost('amount'),
            'due_date' => $this->request->getPost('due_date'),
            'status' => 'Unpaid'
        ]);

        return redirect()->to(base_url('admin/taxes'))->with('success', 'Tax demand generated and sent to citizen.');
    }

    public function projects()
    {
        $db = \Config\Database::connect();
        $data['projects'] = $db->table('projects')->orderBy('id', 'DESC')->get()->getResultArray();
        return view('admin/projects', $data);
    }

    public function save_project()
    {
        $db = \Config\Database::connect();
        $db->table('projects')->insert([
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'budget' => $this->request->getPost('budget'),
            'ward_no' => $this->request->getPost('ward_no'),
            'start_date' => $this->request->getPost('start_date'),
            'estimate_end_date' => $this->request->getPost('estimate_end_date'),
            'status' => 'Planned',
            'progress_percent' => 0,
            'executing_agency' => $this->request->getPost('executing_agency'),
            'fund_source' => $this->request->getPost('fund_source')
        ]);

        return redirect()->to(base_url('admin/projects'))->with('success', 'Infrastructure project planned and recorded.');
    }

    public function update_project_status()
    {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        $db->table('projects')->where('id', $id)->update([
            'status' => $this->request->getPost('status'),
            'progress_percent' => $this->request->getPost('progress_percent')
        ]);

        return redirect()->to(base_url('admin/projects'))->with('success', 'Project progress updated successfully.');
    }

    public function transparency_vault()
    {
        $db = \Config\Database::connect();
        
        // Initialize Table if not exists
        $db->query("CREATE TABLE IF NOT EXISTS project_audit (
            id INT AUTO_INCREMENT PRIMARY KEY,
            project_id INT,
            type ENUM('Bill', 'Muster Roll', 'Photo Before', 'Photo After') NOT NULL,
            file_path VARCHAR(255),
            latitude DECIMAL(10, 8) NULL,
            longitude DECIMAL(11, 8) NULL,
            uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            remarks TEXT
        )");

        $data['projects'] = $db->table('projects')->orderBy('id', 'DESC')->get()->getResultArray();
        
        // For each project, fetch its audit documents
        foreach($data['projects'] as &$p) {
            $p['audits'] = $db->table('project_audit')->where('project_id', $p['id'])->get()->getResultArray();
        }

        return view('admin/transparency_vault', $data);
    }

    public function save_audit_file()
    {
        $db = \Config\Database::connect();
        $file = $this->request->getFile('audit_file');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            if(!is_dir(FCPATH . 'uploads/audit')) mkdir(FCPATH . 'uploads/audit', 0777, true);
            $file->move(FCPATH . 'uploads/audit', $newName);
            $filePath = 'uploads/audit/' . $newName;

            $db->table('project_audit')->insert([
                'project_id' => $this->request->getPost('project_id'),
                'type'       => $this->request->getPost('type'),
                'remarks'    => $this->request->getPost('remarks'),
                'latitude'   => $this->request->getPost('latitude') ?: null,
                'longitude'  => $this->request->getPost('longitude') ?: null,
                'file_path'  => $filePath
            ]);

            return redirect()->to(base_url('admin/transparency'))->with('success', 'Document/Photo added to Transparency Vault.');
        }

        return redirect()->back()->with('error', 'Failed to upload audit file.');
    }

    public function delete_audit_file($id)
    {
        $db = \Config\Database::connect();
        $db->table('project_audit')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/transparency'))->with('success', 'Record removed from vault.');
    }


    public function save_asset()
    {
        $db = \Config\Database::connect();
        $db->table('assets')->insert([
            'asset_name' => $this->request->getPost('asset_name'),
            'asset_type' => $this->request->getPost('asset_type'),
            'location' => $this->request->getPost('location'),
            'cost' => $this->request->getPost('cost'),
            'current_status' => $this->request->getPost('current_status'),
            'purchased_at' => date('Y-m-d')
        ]);

        return redirect()->to(base_url('admin/assets'))->with('success', 'New asset recorded in official registry.');
    }

    public function update_asset_status()
    {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        $db->table('assets')->where('id', $id)->update([
            'current_status' => $this->request->getPost('current_status')
        ]);

        return redirect()->to(base_url('admin/assets'))->with('success', 'Asset condition status updated.');
    }

    public function notices()
    {
        $db = \Config\Database::connect();
        $data['notices'] = $db->table('notices')->orderBy('created_at', 'DESC')->get()->getResultArray();
        return view('admin/notices_list', $data);
    }

    public function save_notice()
    {
        $db = \Config\Database::connect();
        $data = [
            'title'       => $this->request->getPost('title'),
            'type'        => $this->request->getPost('type'),
            'content'     => $this->request->getPost('content'),
            'expiry_date' => $this->request->getPost('expiry_date') ?: null,
            'status'      => 'Active'
        ];
        
        $db->table('notices')->insert($data);
        return redirect()->to(base_url('admin/notices'))->with('success', 'Notice/Tender posted successfully.');
    }

    public function delete_notice($id)
    {
        $db = \Config\Database::connect();
        $db->table('notices')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/notices'))->with('success', 'Notice deleted successfully.');
    }

    public function manage_marketplace()
    {
        $db = \Config\Database::connect();
        $data['products'] = $db->table('products')
            ->select('products.*, users.name as seller_name')
            ->join('users', 'users.id = products.user_id', 'left') // Left join to show all
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();
        return view('admin/marketplace_admin', $data);
    }

    public function approve_product($id)
    {
        $db = \Config\Database::connect();
        $db->table('products')->where('id', $id)->update(['status' => 'Active']);
        return redirect()->to('admin/marketplace')->with('success', 'Product listing approved and live.');
    }

    public function reject_product($id)
    {
        $db = \Config\Database::connect();
        $reason = $this->request->getPost('reason') ?: 'No specific reason provided.';
        $db->table('products')->where('id', $id)->update([
            'status' => 'Rejected',
            'admin_remarks' => $reason
        ]);
        return redirect()->to('admin/marketplace')->with('success', 'Product listing rejected with reason.');
    }

    public function save_marketplace_product()
    {
        $db = \Config\Database::connect();
        $data = [
            'user_id'       => session()->get('user_id'), // Admin's user ID
            'title'         => $this->request->getPost('title'),
            'category'      => $this->request->getPost('category'),
            'price'         => $this->request->getPost('price'),
            'unit'          => $this->request->getPost('unit'),
            'description'   => $this->request->getPost('description'),
            'contact_phone' => $this->request->getPost('contact_phone'),
            'status'        => 'Active' // Admin posts are active immediately
        ];
        $db->table('products')->insert($data);
        return redirect()->to('admin/marketplace')->with('success', 'Official listing published successfully!');
    }

    public function manage_utilities()
    {
        $db = \Config\Database::connect();
        $data['requests'] = $db->table('utility_requests')
            ->select('utility_requests.*, users.name as citizen_name')
            ->join('users', 'users.id = utility_requests.user_id')
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();

        return view('admin/utility_admin', $data);
    }

    public function update_utility_status($id, $status)
    {
        $db = \Config\Database::connect();
        $remarks = $this->request->getPost('remarks');
        
        $db->table('utility_requests')->where('id', $id)->update([
            'status' => $status,
            'admin_remarks' => $remarks
        ]);
        
        return redirect()->to('admin/utilities')->with('success', 'Utility request status updated to ' . $status);
    }

    public function agriculture()
    {
        $db = \Config\Database::connect();
        $data['mandi_rates'] = $db->table('mandi_rates')->orderBy('updated_at', 'DESC')->get()->getResultArray();
        $data['equipment'] = $db->table('agri_equipment')->get()->getResultArray();
        $data['bookings'] = $db->table('agri_bookings')
            ->select('agri_bookings.*, users.name as farmer_name, agri_equipment.name as eq_name')
            ->join('users', 'users.id = agri_bookings.user_id')
            ->join('agri_equipment', 'agri_equipment.id = agri_bookings.equipment_id')
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();

        return view('admin/agriculture_admin', $data);
    }

    public function save_mandi_rate()
    {
        $db = \Config\Database::connect();
        $data = [
            'crop_name' => $this->request->getPost('crop_name'),
            'price_min' => $this->request->getPost('price_min'),
            'price_max' => $this->request->getPost('price_max'),
            'market_name' => $this->request->getPost('market_name'),
            'trend' => $this->request->getPost('trend')
        ];
        $db->table('mandi_rates')->insert($data);
        return redirect()->to('admin/agriculture')->with('success', 'Mandi Bhav updated.');
    }

    public function save_equipment()
    {
        $db = \Config\Database::connect();
        $data = [
            'name' => $this->request->getPost('name'),
            'vehicle_no' => $this->request->getPost('vehicle_no'),
            'rate_per_hour' => $this->request->getPost('rate_per_hour'),
            'status' => 'Available',
            'description' => $this->request->getPost('description')
        ];
        $db->table('agri_equipment')->insert($data);
        return redirect()->to('admin/agriculture')->with('success', 'New machinery added to village inventory.');
    }

    public function delete_equipment($id)
    {
        $db = \Config\Database::connect();
        $db->table('agri_equipment')->where('id', $id)->delete();
        return redirect()->to('admin/agriculture')->with('success', 'Equipment removed from inventory.');
    }

    public function update_booking_status($id, $status)
    {
        $db = \Config\Database::connect();
        $remarks = $this->request->getPost('remarks') ?: 'Processed by System Admin';
        
        // Fetch booking to get equipment ID
        $booking = $db->table('agri_bookings')->where('id', $id)->get()->getRowArray();
        
        $db->table('agri_bookings')->where('id', $id)->update([
            'status' => $status,
            'admin_remarks' => $remarks
        ]);
        
        // If approved, mark equipment as 'Booked'
        if($status == 'Approved') {
            $db->table('agri_equipment')->where('id', $booking['equipment_id'])->update(['status' => 'Booked']);
        }
        
        // If completed or cancelled, release equipment to 'Available'
        if(in_array($status, ['Completed', 'Cancelled'])) {
            $db->table('agri_equipment')->where('id', $booking['equipment_id'])->update(['status' => 'Available']);
        }

        return redirect()->to('admin/agriculture')->with('success', 'Booking pipeline updated to ' . $status);
    }

    public function emergency()
    {
        $db = \Config\Database::connect();
        $data['alerts'] = $db->table('emergency_alerts')->orderBy('created_at', 'DESC')->get()->getResultArray();
        $data['directory'] = $db->table('health_directory')->get()->getResultArray();
        return view('admin/emergency_admin', $data);
    }

    public function save_emergency_alert()
    {
        $db = \Config\Database::connect();
        $data = [
            'title'       => $this->request->getPost('title'),
            'message'     => $this->request->getPost('message'),
            'type'        => $this->request->getPost('type'),
            'severity'    => $this->request->getPost('severity'),
            'ward_no'     => $this->request->getPost('ward_no') ?: 'All',
            'expiry_date' => $this->request->getPost('expiry_date') ?: null,
            'is_active'   => 1
        ];
        $db->table('emergency_alerts')->insert($data);
        return redirect()->to(base_url('admin/emergency'))->with('success', 'Mass emergency alert broadcasted.');
    }

    public function delete_alert($id)
    {
        $db = \Config\Database::connect();
        $db->table('emergency_alerts')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/emergency'))->with('success', 'Alert removed.');
    }

    public function save_health_directory()
    {
        $db = \Config\Database::connect();
        $data = [
            'category'           => $this->request->getPost('category'),
            'name'               => $this->request->getPost('name'),
            'contact_no'         => $this->request->getPost('contact_no'),
            'address'            => $this->request->getPost('address'),
            'blood_group'        => $this->request->getPost('blood_group'),
            'service_hours'      => $this->request->getPost('service_hours') ?: '24/7',
            'map_link'           => $this->request->getPost('map_link'),
            'available_capacity' => $this->request->getPost('available_capacity'),
            'website'            => $this->request->getPost('website'),
            'is_verified'        => 1
        ];

        $id = $this->request->getPost('id');
        if($id) {
            $db->table('health_directory')->where('id', $id)->update($data);
            $msg = 'Entry updated successfully.';
        } else {
            $db->table('health_directory')->insert($data);
            $msg = 'New medical contact added successfully.';
        }

        return redirect()->to(base_url('admin/emergency'))->with('success', $msg);
    }

    public function delete_health_directory($id)
    {
        $db = \Config\Database::connect();
        $db->table('health_directory')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/emergency'))->with('success', 'Directory entry removed.');
    }
    public function proceedings()
    {
        $db = \Config\Database::connect();
        $meetingId = $this->request->getGet('meeting_id');
        $prefill = null;
        if($meetingId) {
            $prefill = $db->table('meetings')->where('id', $meetingId)->get()->getRowArray();
        }

        $data['proceedings'] = $db->table('proceedings')->orderBy('meeting_date', 'DESC')->get()->getResultArray();
        $data['prefill'] = $prefill;
        return view('admin/proceedings_admin', $data);
    }

    public function save_proceeding()
    {
        $db = \Config\Database::connect();
        $file = $this->request->getFile('minutes_file');
        $filePath = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            if(!is_dir('public/uploads/proceedings')) mkdir('public/uploads/proceedings', 0777, true);
            $file->move('public/uploads/proceedings', $newName);
            $filePath = 'uploads/proceedings/' . $newName;
        }

        $title = $this->request->getPost('title');
        
        // Auto-Illustration Logic: If no file is uploaded, suggest a context-aware image
        if (!$filePath && !$this->request->getPost('old_file')) {
            $lowerTitle = strtolower($title);
            if (strpos($lowerTitle, 'budget') !== false) {
                $filePath = 'assets/img/budget_default.png';
            } elseif (strpos($lowerTitle, 'infra') !== false || strpos($lowerTitle, 'road') !== false || strpos($lowerTitle, 'construction') !== false) {
                $filePath = 'assets/img/infra_default.png';
            } elseif (strpos($lowerTitle, 'agri') !== false || strpos($lowerTitle, 'farmer') !== false || strpos($lowerTitle, 'krishi') !== false) {
                $filePath = 'assets/img/agri_default.png';
            } elseif (strpos($lowerTitle, 'health') !== false || strpos($lowerTitle, 'vaccine') !== false || strpos($lowerTitle, 'medical') !== false) {
                $filePath = 'assets/img/health_default.png';
            } elseif (strpos($lowerTitle, 'edu') !== false || strpos($lowerTitle, 'school') !== false || strpos($lowerTitle, 'library') !== false) {
                $filePath = 'assets/img/edu_default.png';
            } elseif (strpos($lowerTitle, 'water') !== false || strpos($lowerTitle, 'toilet') !== false || strpos($lowerTitle, 'sanitation') !== false) {
                $filePath = 'assets/img/water_default.png';
            } elseif (strpos($lowerTitle, 'welfare') !== false || strpos($lowerTitle, 'pension') !== false || strpos($lowerTitle, 'social') !== false) {
                $filePath = 'assets/img/welfare_default.png';
            } else {
                $filePath = 'assets/img/assembly_branding.png';
            }
        }

        $meeting_id = $this->request->getPost('meeting_id');
        $data = [
            'meeting_id'   => $meeting_id ?: null,
            'title'        => $title,
            'meeting_date' => $this->request->getPost('meeting_date'),
            'minutes'      => $this->request->getPost('minutes'),
            'attendees'    => $this->request->getPost('attendees'),
            'agenda'       => $this->request->getPost('agenda'),
            'resolutions'  => $this->request->getPost('resolutions'),
            'file_path'    => $filePath ?: $this->request->getPost('old_file')
        ];

        $id = $this->request->getPost('id');
        if ($id) {
            $db->table('proceedings')->where('id', $id)->update($data);
        } else {
            $db->table('proceedings')->insert($data);
            
            // If linked to a scheduled meeting, mark it as Completed
            if ($meeting_id) {
                $db->table('meetings')->where('id', $meeting_id)->update(['status' => 'Completed']);
            }
        }

        return redirect()->to(base_url('admin/proceedings'))->with('success', 'Meeting proceedings updated.');
    }

    public function delete_proceeding($id)
    {
        $db = \Config\Database::connect();
        $db->table('proceedings')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/proceedings'))->with('success', 'Record removed.');
    }

    public function democracy()
    {
        $db = \Config\Database::connect();
        $data['polls'] = $db->table('polls')->orderBy('created_at', 'DESC')->get()->getResultArray();
        $data['suggestions'] = $db->table('suggestions')
            ->select('suggestions.*, users.name as citizen_name')
            ->join('users', 'users.id = suggestions.user_id')
            ->orderBy('created_at', 'DESC')->get()->getResultArray();
            
        // Calculate poll results
        foreach($data['polls'] as &$poll) {
            $poll['votes'] = $db->table('poll_votes')->where('poll_id', $poll['id'])->get()->getResultArray();
            $poll['options'] = json_decode($poll['options'], true);
        }

        // Governance Performance Metrics
        $totalSuggestions = count($data['suggestions']);
        $responded = count(array_filter($data['suggestions'], fn($s) => $s['status'] !== 'Pending'));
        $data['accountability_score'] = $totalSuggestions > 0 ? round(($responded / $totalSuggestions) * 100) : 100;
        $data['pending_ideas'] = count(array_filter($data['suggestions'], fn($s) => $s['status'] === 'Pending'));

        return view('admin/democracy_admin', $data);
    }

    public function save_poll()
    {
        $db = \Config\Database::connect();
        $options = $this->request->getPost('options');
        $optionsArray = array_filter(explode("\n", str_replace("\r", "", $options)));
        
        $data = [
            'question' => $this->request->getPost('question'),
            'options'  => json_encode(array_values($optionsArray)),
            'status'   => 'Active'
        ];
        
        $db->table('polls')->insert($data);
        return redirect()->to(base_url('admin/democracy'))->with('success', 'New priority poll launched.');
    }

    public function delete_poll($id)
    {
        $db = \Config\Database::connect();
        $db->table('polls')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/democracy'))->with('success', 'Poll removed.');
    }

    public function update_suggestion()
    {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        $note = $this->request->getPost('admin_note');

        $db->table('suggestions')->where('id', $id)->update([
            'status' => $status,
            'admin_note' => $note
        ]);

        return redirect()->to(base_url('admin/democracy'))->with('success', 'Suggestion status updated and response sent to citizen.');
    }

    public function categories()
    {
        $db = \Config\Database::connect();
        $data['categories'] = $db->table('service_categories')->get()->getResultArray();
        return view('admin/categories', $data);
    }

    public function save_category()
    {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        $data = [
            'name'            => $this->request->getPost('name'),
            'prefix'          => $this->request->getPost('prefix'),
            'description'     => $this->request->getPost('description'),
            'processing_days' => $this->request->getPost('processing_days') ?: 7,
            'fees'            => $this->request->getPost('fees') ?: 0
        ];

        if ($id) {
            $db->table('service_categories')->where('id', $id)->update($data);
            $msg = 'Service category updated.';
        } else {
            $db->table('service_categories')->insert($data);
            $msg = 'New service category added.';
        }
        return redirect()->to(base_url('admin/categories'))->with('success', $msg);
    }

    public function delete_category($id)
    {
        $db = \Config\Database::connect();
        $db->table('service_categories')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/categories'))->with('success', 'Category removed.');
    }
}

