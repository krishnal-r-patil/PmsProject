<?php

namespace App\Controllers;

class User extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');

        // Fetch citizen profile info joined with user record
        $data['citizen'] = $db->table('citizens')
            ->select('citizens.*, users.name, users.email')
            ->join('users', 'users.id = citizens.user_id')
            ->where('citizens.user_id', $user_id)
            ->get()
            ->getRowArray();
        
        // Fetch user's own applications
        $data['applications'] = $db->table('applications')->where('user_id', $user_id)->orderBy('applied_at', 'DESC')->limit(5)->get()->getResultArray();
        
        // Fetch user's own grievances
        $data['grievances'] = $db->table('grievances')->where('user_id', $user_id)->orderBy('created_at', 'DESC')->limit(3)->get()->getResultArray();
        
        $data['total_taxes_unpaid'] = $db->table('taxes')->where(['user_id' => $user_id, 'status' => 'Unpaid'])->countAllResults();

        // Fetch issued certificates for this user
        $data['issued_certificates'] = $db->table('birth_death_register')
            ->where('linked_user_id', $user_id)
            ->where('is_issued', 1)
            ->get()
            ->getResultArray();
            
        // Fetch Emergency Alerts for Broadcast
        $now = date('Y-m-d H:i:s');
        $user_ward = $data['citizen']['ward_no'] ?? 'All';
        $data['broadcast_alerts'] = $db->table('emergency_alerts')
            ->where('is_active', 1)
            ->groupStart()
                ->where('expiry_date >', $now)
                ->orWhere('expiry_date', null)
            ->groupEnd()
            ->groupStart()
                ->where('ward_no', 'All')
                ->orWhere('ward_no', $user_ward)
                ->orWhere('ward_no', 'Ward ' . str_pad($user_ward, 2, '0', STR_PAD_LEFT))
            ->groupEnd()
            ->orderBy('severity', 'DESC')
            ->get()->getResultArray();

        // Fetch active notices
        $data['notices'] = $db->table('notices')->where('status', 'Active')->orderBy('created_at', 'DESC')->limit(3)->get()->getResultArray();

        // Fetch latest/upcoming Gram Sabha meeting
        $data['next_meeting'] = $db->table('proceedings')->orderBy('meeting_date', 'DESC')->limit(1)->get()->getRowArray();

        // Prevent back-button from showing dashboard after logout

        $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $this->response->setHeader('Pragma', 'no-cache');

        return view('user/dashboard', $data);
    }

    public function grievances()
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');
        $data['grievances'] = $db->table('grievances')->where('user_id', $user_id)->orderBy('created_at', 'DESC')->get()->getResultArray();
        return view('user/grievances', $data);
    }

    public function submit_grievance()
    {
        $db = \Config\Database::connect();
        $data = [
            'user_id' => session()->get('user_id'),
            'title' => $this->request->getPost('title'),
            'category' => $this->request->getPost('category'),
            'description' => $this->request->getPost('description'),
            'status' => 'Open'
        ];
        $db->table('grievances')->insert($data);
        return redirect()->to('/user/grievances')->with('success', 'Complaint submitted successfully.');
    }

    public function schemes()
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');
        $data['schemes'] = $db->table('schemes')->where('status', 'Active')->get()->getResultArray();
        
        $data['applied_schemes'] = $db->table('scheme_applications')
            ->select('scheme_applications.*, schemes.title as scheme_title')
            ->join('schemes', 'schemes.id = scheme_applications.scheme_id')
            ->where('scheme_applications.user_id', $user_id)
            ->orderBy('applied_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('user/schemes', $data);
    }

    public function apply_scheme($id)
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');

        // Check if user has exceeded the limit of 10 applications for this specific scheme
        $existing_count = $db->table('scheme_applications')
            ->where(['user_id' => $user_id, 'scheme_id' => $id, 'status' => 'Pending'])
            ->countAllResults();

        if ($existing_count >= 10) {
            return redirect()->back()->with('error', 'You have reached the maximum limit of 10 pending applications for this specific scheme.');
        }

        $formData = $this->request->getPost('data');

        $db->table('scheme_applications')->insert([
            'user_id' => $user_id,
            'scheme_id' => $id,
            'application_details' => json_encode($formData),
            'status' => 'Pending',
            'applied_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(base_url('user/schemes'))->with('success', 'Application #' . ($existing_count + 1) . ' submitted successfully!');
    }

    public function payments()
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');

        $data['transactions'] = $db->table('transactions')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        // Calculate summary for the dashboard
        $data['total_received'] = 0;
        $data['total_paid'] = 0;
        foreach ($data['transactions'] as $t) {
            if ($t['status'] == 'Completed') {
                if ($t['type'] == 'Credit') $data['total_received'] += $t['amount'];
                else $data['total_paid'] += $t['amount'];
            }
        }

        return view('user/payments', $data);
    }

    public function taxes()
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');

        $data['unpaid_taxes'] = $db->table('taxes')
            ->where('user_id', $user_id)
            ->where('status', 'Unpaid')
            ->orderBy('due_date', 'ASC')
            ->get()->getResultArray();

        $data['paid_taxes'] = $db->table('taxes')
            ->where('user_id', $user_id)
            ->where('status', 'Paid')
            ->orderBy('paid_at', 'DESC')
            ->get()->getResultArray();

        return view('user/taxes', $data);
    }

    public function projects()
    {
        $db = \Config\Database::connect();
        $data['projects'] = $db->table('projects')->orderBy('id', 'DESC')->get()->getResultArray();
        return view('user/projects', $data);
    }

    public function transparency_vault()
    {
        $db = \Config\Database::connect();
        
        // Initialize Table if not exists (to prevent crash if user visits before admin)
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
        
        foreach($data['projects'] as &$p) {
            $p['audits'] = $db->table('project_audit')->where('project_id', $p['id'])->get()->getResultArray();
        }

        return view('user/transparency_vault', $data);
    }

    public function assets()
    {
        $db = \Config\Database::connect();
        $data['assets'] = $db->table('assets')->orderBy('id', 'DESC')->get()->getResultArray();
        return view('user/assets', $data);
    }

    public function pay_tax($id)
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');

        $tax = $db->table('taxes')->where('id', $id)->where('user_id', $user_id)->get()->getRowArray();

        if (!$tax) {
            return redirect()->back()->with('error', 'Tax record not found.');
        }

        // Update tax record
        $db->table('taxes')->where('id', $id)->update([
            'status' => 'Paid',
            'paid_at' => date('Y-m-d H:i:s')
        ]);

        // Create transaction entry
        $txn_id = 'TXN-PAY-' . strtoupper(substr($tax['tax_type'], 0, 3)) . '-' . mt_rand(1000, 9999);
        $db->table('transactions')->insert([
            'user_id' => $user_id,
            'type' => 'Debit',
            'title' => 'Tax Paid: ' . $tax['tax_type'],
            'category' => 'Tax',
            'amount' => $tax['amount'],
            'status' => 'Completed',
            'transaction_id' => $txn_id,
            'reference_note' => 'Self-paid via Citizen Tax Portal.'
        ]);

        return redirect()->to(base_url('user/pay-taxes'))->with('success', 'Tax payment of ₹' . number_format($tax['amount'], 2) . ' successful!');
    }

    public function my_documents()
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');

        // Fetch all certificates linked to this user
        $data['issued_certificates'] = $db->table('birth_death_register')
            ->where('linked_user_id', $user_id)
            ->where('is_issued', 1)
            ->get()
            ->getResultArray();
            
        $data['cert_count'] = count($data['issued_certificates']);
        return view('user/my_documents', $data);
    }

    public function certificates()
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');

        // Fetch count for sidebar
        $count = $db->table('birth_death_register')
            ->where('linked_user_id', $user_id)
            ->where('is_issued', 1)
            ->countAllResults();
            
        $data['cert_count'] = $count;

        // Fetch issued certificates for this user to display prominent downloads
        $data['issued_certificates'] = $db->table('birth_death_register')
            ->where('linked_user_id', $user_id)
            ->where('is_issued', 1)
            ->get()
            ->getResultArray();

        // Fetch application history
        $data['applications'] = $db->table('applications')
            ->where('user_id', $user_id)
            ->orderBy('applied_at', 'DESC')
            ->get()
            ->getResultArray();

        // DEBUG: Log found certificates count
        $data['debug_user_id'] = $user_id;
        $data['debug_cert_count'] = count($data['issued_certificates']);
        
        return view('user/apply_certificate', $data);
    }


    public function submit_application()
    {
        $db = \Config\Database::connect();
        $formData = $this->request->getPost('data');
        $formData['purpose'] = $this->request->getPost('purpose');

        $data = [
            'user_id'          => session()->get('user_id'),
            'service_type'     => $this->request->getPost('service_type'),
            'status'           => 'Pending',
            'application_data' => json_encode($formData),
            'applied_at'       => date('Y-m-d H:i:s')
        ];
        $db->table('applications')->insert($data);
        return redirect()->to(base_url('user/certificates'))->with('success', 'Application submitted successfully. We will review it shortly.');
    }

    public function profile()
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');
        
        $data['citizen'] = $db->table('citizens')
            ->select('citizens.*, users.name, users.email, users.role')
            ->join('users', 'users.id = citizens.user_id')
            ->where('citizens.user_id', $user_id)
            ->get()
            ->getRowArray();
            
        return view('user/profile', $data);
    }

    public function permissions()
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');
        
        $data['permissions'] = $db->table('permissions')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data['citizen'] = $db->table('citizens')->where('user_id', $user_id)->get()->getRowArray();
            
        return view('user/permissions', $data);
    }

    public function submit_permission()
    {
        $db = \Config\Database::connect();
        $data = [
            'user_id' => session()->get('user_id'),
            'type' => $this->request->getPost('type'),
            'description' => $this->request->getPost('description'),
            'venue' => $this->request->getPost('venue'),
            'event_date' => $this->request->getPost('event_date'),
            'status' => 'Pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $db->table('permissions')->insert($data);
        return redirect()->to('/user/permissions')->with('success', 'Permission request submitted successfully.');
    }

    public function view_certificate($id)
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');
        
        $record = $db->table('birth_death_register')
            ->where('id', $id)
            ->where('linked_user_id', $user_id)
            ->where('is_issued', 1)
            ->get()
            ->getRowArray();
            
        if (!$record) {
            return "Certificate not found or not yet issued to you.";
        }
        
        return view('admin/certificate_template', ['record' => $record]);
    }

    public function delete_certificates_bulk()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');
        $json = $this->request->getJSON();
        $ids = $json->ids ?? [];

        if (empty($ids)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No items selected']);
        }

        // Security: We only UNLINK records that belong to THIS user.
        // We do NOT delete them from birth_death_register because the Admin (Panchayat) 
        // needs to keep official government records for their registry.
        $db->table('birth_death_register')
           ->where('linked_user_id', $user_id)
           ->whereIn('id', $ids)
           ->update(['linked_user_id' => null, 'is_issued' => 0]);

        // Also clean up references in applications table so user can re-apply if needed
        $db->table('applications')
           ->where('user_id', $user_id)
           ->whereIn('certificate_id', $ids)
           ->update(['certificate_id' => null, 'status' => 'Rejected', 'remarks' => 'Removed from citizen vault by user']);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function notices()
    {
        $db = \Config\Database::connect();
        $data['notices'] = $db->table('notices')
            ->where('status', 'Active')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();
        return view('user/notices', $data);
    }

    public function marketplace()
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');
        
        // Ensure sidebar/header has profile info
        $data['citizen'] = $db->table('citizens')
            ->select('citizens.*, users.name, users.email')
            ->join('users', 'users.id = citizens.user_id')
            ->where('citizens.user_id', $user_id)
            ->get()->getRowArray();

        $data['products'] = $db->table('products')
            ->select("products.*, users.name as seller_name, CONCAT(citizens.house_no, ', Ward ', citizens.ward_no, ', ', citizens.village) as seller_address, citizens.family_id as pariwar_id")
            ->join('users', 'users.id = products.user_id')
            ->join('citizens', 'citizens.user_id = products.user_id', 'left')
            ->where('products.status', 'Active')
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();
        return view('user/marketplace', $data);
    }

    public function my_products()
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');

        $data['citizen'] = $db->table('citizens')
            ->select('citizens.*, users.name, users.email')
            ->join('users', 'users.id = citizens.user_id')
            ->where('citizens.user_id', $user_id)
            ->get()->getRowArray();

        $data['products'] = $db->table('products')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();
        return view('user/my_products', $data);
    }

    public function save_product()
    {
        $db = \Config\Database::connect();
        $data = [
            'user_id'       => session()->get('user_id'),
            'title'         => $this->request->getPost('title'),
            'category'      => $this->request->getPost('category'),
            'price'         => $this->request->getPost('price'),
            'unit'          => $this->request->getPost('unit'),
            'description'   => $this->request->getPost('description'),
            'contact_phone' => $this->request->getPost('contact_phone'),
            'status'        => 'Pending' // Requires admin approval
        ];
        $db->table('products')->insert($data);
        return redirect()->to('user/my-products')->with('success', 'Product listed! It will be visible once approved by Admin.');
    }

    public function delete_product($id)
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');
        $db->table('products')->where(['id' => $id, 'user_id' => $user_id])->delete();
        return redirect()->to('user/my-products')->with('success', 'Listing removed.');
    }

    public function utilities()
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');
        
        $data['citizen'] = $db->table('citizens')->where('user_id', $user_id)->get()->getRowArray();
        $data['requests'] = $db->table('utility_requests')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();

        return view('user/utilities', $data);
    }

    public function save_utility_request()
    {
        $db = \Config\Database::connect();
        $data = [
            'user_id'      => session()->get('user_id'),
            'applicant_name' => $this->request->getPost('applicant_name'),
            'father_name'  => $this->request->getPost('father_name'),
            'phone'        => $this->request->getPost('phone'),
            'email'        => $this->request->getPost('email'),
            'aadhar_no'    => $this->request->getPost('aadhar_no'),
            'occupation'   => $this->request->getPost('occupation'),
            'service_type' => $this->request->getPost('service_type'),
            'category'     => $this->request->getPost('category'),
            'address'      => $this->request->getPost('address'),
            'property_id'  => $this->request->getPost('property_id'),
            'pariwar_id'   => $this->request->getPost('pariwar_id'),
            'status'       => 'Pending'
        ];
        $db->table('utility_requests')->insert($data);
        return redirect()->to('user/utilities')->with('success', 'Application submitted successfully. Our field officer will contact you soon.');
    }

    public function agriculture()
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');
        
        $data['mandi_rates'] = $db->table('mandi_rates')->orderBy('updated_at', 'DESC')->get()->getResultArray();
        $data['equipment'] = $db->table('agri_equipment')->where('status', 'Available')->get()->getResultArray();
        $data['my_bookings'] = $db->table('agri_bookings')
            ->select('agri_bookings.*, agri_equipment.name as eq_name')
            ->join('agri_equipment', 'agri_equipment.id = agri_bookings.equipment_id')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();

        return view('user/agriculture', $data);
    }

    public function book_equipment()
    {
        $db = \Config\Database::connect();
        $eq_id = $this->request->getPost('equipment_id');
        $hours = $this->request->getPost('hours_req');
        
        $eq = $db->table('agri_equipment')->where('id', $eq_id)->get()->getRowArray();
        $total = $eq['rate_per_hour'] * $hours;

        $data = [
            'user_id' => session()->get('user_id'),
            'equipment_id' => $eq_id,
            'booking_date' => $this->request->getPost('booking_date'),
            'hours_req' => $hours,
            'total_amount' => $total,
            'status' => 'Pending'
        ];
        
        $db->table('agri_bookings')->insert($data);
        return redirect()->to('user/agriculture')->with('success', 'Booking request submitted. Pay on arrival.');
    }

    public function emergency()
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');

        // Fetch user's ward for hyper-local filtering
        $citizen = $db->table('citizens')->where('user_id', $user_id)->get()->getRowArray();
        $user_ward = $citizen['ward_no'] ?? 'All';

        // Fetch alerts: Active, Not Expired, for ALL or User's Ward
        $now = date('Y-m-d H:i:s');
        $data['active_alerts'] = $db->table('emergency_alerts')
            ->where('is_active', 1)
            ->groupStart()
                ->where('expiry_date >', $now)
                ->orWhere('expiry_date', null)
            ->groupEnd()
            ->groupStart()
                ->where('ward_no', 'All')
                ->orWhere('ward_no', $user_ward)
                ->orWhere('ward_no', 'Ward ' . str_pad($user_ward, 2, '0', STR_PAD_LEFT))
            ->groupEnd()
            ->orderBy('severity', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();
            
        // Fetch Directory Categories
        $data['directory'] = $db->table('health_directory')->where('is_verified', 1)->get()->getResultArray();
        
        // Pass specialized groupings for backward compatibility in view
        $data['hospitals'] = array_filter($data['directory'], fn($item) => $item['category'] == 'Hospital');
        $data['ambulances'] = array_filter($data['directory'], fn($item) => $item['category'] == 'Ambulance');
        $data['donors'] = array_filter($data['directory'], fn($item) => $item['category'] == 'Blood Donor');
        
        return view('user/emergency', $data);
    }
    public function democracy()
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');
        
        $data['polls'] = $db->table('polls')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->getResultArray();
        foreach($data['polls'] as &$poll) {
            $poll['options'] = json_decode($poll['options'], true);
            $poll['has_voted'] = $db->table('poll_votes')->where(['poll_id' => $poll['id'], 'user_id' => $user_id])->countAllResults() > 0;
            $poll['total_votes'] = $db->table('poll_votes')->where('poll_id', $poll['id'])->countAllResults();
        }

        $data['my_suggestions'] = $db->table('suggestions')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')->get()->getResultArray();

        // Accountability Metrics for Citizen Confidence
        $totalSuggestions = count($db->table('suggestions')->get()->getResultArray());
        $responded = count($db->table('suggestions')->where('status !=', 'Pending')->get()->getResultArray());
        $data['accountability_score'] = $totalSuggestions > 0 ? round(($responded / $totalSuggestions) * 100) : 100;
        $data['total_ideas'] = $totalSuggestions;

        return view('user/democracy', $data);
    }

    public function vote_poll($id)
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');
        
        $data = [
            'poll_id'      => $id,
            'user_id'      => $user_id,
            'option_index' => $this->request->getPost('option_index')
        ];

        try {
            $db->table('poll_votes')->insert($data);
            return redirect()->to(base_url('user/democracy'))->with('success', 'Thank you for your vote! Your priority has been recorded.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('user/democracy'))->with('error', 'You have already voted in this poll.');
        }
    }

    public function submit_suggestion()
    {
        $db = \Config\Database::connect();
        $data = [
            'user_id' => session()->get('user_id'),
            'title'   => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'status'  => 'Pending'
        ];
        $db->table('suggestions')->insert($data);
        return redirect()->to(base_url('user/democracy'))->with('success', 'Your suggestion has been submitted for review.');
    }

    public function proceedings()
    {
        $db = \Config\Database::connect();
        $data['proceedings'] = $db->table('proceedings')->orderBy('meeting_date', 'DESC')->get()->getResultArray();
        return view('user/proceedings', $data);
    }

    public function staff_directory()
    {
        $db = \Config\Database::connect();
        $data['staff'] = $db->table('staff')
            ->where('status !=', 'Retired')
            ->orderBy('department', 'ASC')
            ->orderBy('name', 'ASC')
            ->get()->getResultArray();
        return view('user/staff_directory', $data);
    }

    public function elearning()
    {
        $db = \Config\Database::connect();
        $data['resources'] = $db->table('elearning')->where('status', 'Active')->orderBy('category', 'ASC')->get()->getResultArray();
        return view('user/elearning', $data);
    }

    public function village_map()
    {
        $db = \Config\Database::connect();
        $data['assets'] = $db->table('assets')
            ->where('latitude IS NOT NULL')
            ->where('longitude IS NOT NULL')
            ->get()->getResultArray();
        return view('user/village_map', $data);
    }
}
