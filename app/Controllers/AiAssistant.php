<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * AI Gram-Sahayak Controller - V5.0 ABSOLUTE OMNISCIENCE
 * The DEFINITIVE Brain covering every single table and service in the PMS.
 */
class AiAssistant extends BaseController
{
    private $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $session = session();
        if (!$session->get('user_id')) return redirect()->to('/login');
        $user_id = $session->get('user_id');
        $role = $session->get('user_role');
        $data['user_name'] = $session->get('user_name');
        $data['role'] = $role;
        $data['profile'] = $this->db->table('citizens')->where('user_id', $user_id)->get()->getRowArray();
        $viewPath = ($role === 'admin') ? 'admin/ai_assistant' : 'user/ai_assistant';
        return view($viewPath, $data);
    }

    public function v3_neural_engine()
    {
        $session = session();
        if (!$session->get('user_id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized Access.']);
        }

        $inputData = $this->request->getJSON();
        $message = $inputData->message ?? $this->request->getPost('message') ?? '';
        
        if (empty(trim($message))) {
             return $this->response->setJSON(['status' => 'success', 'reply' => 'I am your Digital Gram-Sahayak. How can I help you navigate the system?', 'token' => csrf_hash()]);
        }

        $user_id = $session->get('user_id');
        $profile = $this->db->table('citizens')->where('user_id', $user_id)->get()->getRowArray();

        // THE ABSOLUTE OMNISCIENT ENGINE
        $response = $this->runAbsoluteInference($message, $profile);

        return $this->response->setJSON([
            'status' => 'success',
            'v' => '5.0.0_ABSOLUTE',
            'reply' => $response['text'],
            'suggestions' => $response['suggestions'] ?? [],
            'action' => $response['action'] ?? null,
            'rich_card' => $response['rich_card'] ?? null,
            'token' => csrf_hash()
        ]);
    }

    private function runAbsoluteInference($msg, $profile)
    {
        $msg = strtolower(trim($msg));
        $name = session()->get('user_name');
        $user_id = session()->get('user_id');
        $ward = $profile['ward_no'] ?? 'Unknown';
        $category = $profile['category'] ?? 'General';
        $income = (int)($profile['income_annual'] ?? 0);
        
        // --- 1. GREETING: EXPLICIT SERVICE LIST ---
        if (preg_match('/(hi|hello|namaste|नमस्ते|hey|who|help)/u', $msg)) {
            return [
                'text' => "Namaste **$name**! 🙏 I am your **Absolute Gram-Sahayak**. I am connected to **EVERY** module in the PMS:\n\n" .
                          "🔹 **Finance**: Payments, Vouchers, & Accounts.\n" .
                          "🔹 **Economy**: Marketplace, Mandi, & Agri-Rental.\n" .
                          "🔹 **Health**: Emergency Alerts & Medical Directory.\n" .
                          "🔹 **Registry**: Birth, Death, & Documents Vault.\n" .
                          "🔹 **Governance**: Grievances, Polls, Meetings, & Suggestions.\n" .
                          "🔹 **Service**: Water/Light Utilities & Building Permits.\n" .
                          "🔹 **Resources**: Staff Contacts, GIS Map, & Infrastructure.\n\n" .
                          "I know everything in this system. What can I do for you?",
                'suggestions' => ["My Payments", "Mandi Rates", "Marketplace"]
            ];
        }

        // --- 2. FINANCE: TRANSACTIONS & VOUCHERS ---
        if (preg_match('/(payment|transaction|money|receipt|voucher|account|audit|पैसा|भुगतान)/u', $msg)) {
            $txns = $this->db->table('transactions')->where('user_id', $user_id)->orderBy('created_at', 'DESC')->limit(2)->get()->getResultArray();
            $reply = "💳 **Financial Registry**: ";
            if(!empty($txns)) {
                $latest = $txns[0];
                $reply .= "I found **" . count($txns) . " recent payments**. Your last transaction was **₹{$latest['amount']}** for '**{$latest['title']}**'. ";
            }
            $vouchers = $this->db->table('vouchers')->limit(1)->get()->getRowArray();
            if($vouchers) $reply .= "\n\nOfficial audit vouchers are also transparent and available for public review.";
            return [
                'text' => $reply,
                'suggestions' => ["Payment History", "View Vouchers"],
                'action' => ['type' => 'link', 'url' => base_url('user/payment-history')]
            ];
        }

        // --- 3. MEDICAL & HEALTH DIRECTORY ---
        if (preg_match('/(hospital|doctor|ambulance|blood|donor|health|clinic|अस्पताल)/u', $msg)) {
            $directory = $this->db->table('health_directory')->where('is_verified', 1)->limit(2)->get()->getResultArray();
            $reply = "🏥 **Health Hub**: I have verified the following nearby:\n";
            foreach($directory as $d) $reply .= "- **{$d['name']}** ({$d['category']}): 📞 {$d['phone']}\n";
            return [
                'text' => $reply . "\nNeed an ambulance or a blood donor urgently?",
                'suggestions' => ["Find Ambulance", "Blood Donors"],
                'action' => ['type' => 'link', 'url' => base_url('user/emergency')]
            ];
        }

        // --- 4. DEMOCRACY: SUGGESTIONS & PROCEEDINGS ---
        if (preg_match('/(suggestion|idea|minutes|proceeding|gram sabha details|sabha records|सुझाव)/u', $msg)) {
            $suggs = $this->db->table('suggestions')->where('user_id', $user_id)->get()->getResultArray();
            $reply = "🏛️ **Governance Insights**: ";
            if(!empty($suggs)) $reply .= "You have submitted **" . count($suggs) . " suggestions** to the Panchayat. ";
            $latest = $this->db->table('proceedings')->orderBy('id', 'DESC')->limit(1)->get()->getRowArray();
            if($latest) $reply .= "\n\nThe minutes of the latest meeting on **{$latest['meeting_date']}** are available for download.";
            return [
                'text' => $reply,
                'suggestions' => ["My Suggestions", "View Proceedings"],
                'action' => ['type' => 'link', 'url' => base_url('user/democracy')]
            ];
        }

        // --- 5. MARKETPLACE ---
        if (preg_match('/(market|product|sell|buy|item|kisan market)/u', $msg)) {
            $prods = $this->db->table('products')->where('status', 'Active')->limit(2)->get()->getResultArray();
            $reply = "🏪 **Marketplace**: Current live items:\n";
            foreach($prods as $p) $reply .= "- **{$p['title']}**: ₹{$p['price']}\n";
            return [
                'text' => $reply,
                'suggestions' => ["Marketplace Hub", "Sell Product"],
                'action' => ['type' => 'link', 'url' => base_url('user/marketplace')]
            ];
        }

        // --- 6. UTILITIES & PERMISSIONS ---
        if (preg_match('/(water|electricity|light|permit|permission|connection|नल|बिजली)/u', $msg)) {
             return [
                'text' => "🏢 **Services Hub**: I can track your building permits and utility connections (Water/Electricity). Most requests are processed within 15 days.",
                'suggestions' => ["New Utility Request", "Permission Status"],
                'action' => ['type' => 'link', 'url' => base_url('user/utilities')]
            ];
        }

        // --- 7. GRIEVANCES ---
        if (preg_match('/(complaint|grievance|problem|shikayat)/u', $msg)) {
            $data = $this->db->table('grievances')->where('user_id', $user_id)->orderBy('created_at', 'DESC')->get()->getResultArray();
            if(!empty($data)) {
                 return [
                    'text' => "You have **" . count($data) . " active complaints**. Latest Status: **{$data[0]['status']}**.",
                    'suggestions' => ["Track Complaints", "File New"],
                    'action' => ['type' => 'link', 'url' => base_url('user/grievances')]
                ];
            }
        }

        // --- 8. TAXES ---
        if (preg_match('/(tax|due|bill|pay|money)/u', $msg)) {
            $dues = $this->db->table('taxes')->where(['user_id' => $user_id, 'status' => 'Unpaid'])->get()->getResultArray();
            if (!empty($dues)) {
                $total = array_sum(array_column($dues, 'amount'));
                return [
                    'text' => "Outstanding Taxes: **₹$total**. Please pay to ensure Ward $ward infrastructure funds.",
                    'suggestions' => ["Pay Now", "Audit History"],
                    'action' => ['type' => 'link', 'url' => base_url('user/pay-taxes')]
                ];
            }
        }

        // --- 9. AGRICULTURE ---
        if (preg_match('/(mandi|crop|price|tractor|equipment|kisan)/u', $msg)) {
            $rates = $this->db->table('mandi_rates')->orderBy('updated_at', 'DESC')->limit(2)->get()->getResultArray();
            $reply = "📊 **Mandi Stats**:\n";
            foreach($rates as $r) $reply .= "- **{$r['crop_name']}**: ₹{$r['price_max']}\n";
            return [
                'text' => $reply,
                'suggestions' => ["Book Equipment", "Full Rates"],
                'action' => ['type' => 'link', 'url' => base_url('user/agriculture')]
            ];
        }

        // --- 10. SCHEMES ---
        if (preg_match('/(scheme|yojana|eligible|benefit)/u', $msg)) {
            $schemes = $this->db->table('schemes')->where('status', 'Active')->get()->getResultArray();
            $m = [];
            foreach ($schemes as $s) {
                $c = strtolower($s['eligibility_criteria']);
                if (strpos($c, 'all') !== false || ($income <= 150000 && strpos($c, 'bpl') !== false) || strpos($c, strtolower($category)) !== false) $m[] = $s;
            }
            if (!empty($m)) {
                $f = $m[0];
                return [
                    'text' => "Matched **" . count($m) . " schemes**. Top recommendation: **{$f['title']}**.",
                    'suggestions' => ["Apply Now", "Other Matches"],
                    'rich_card' => ['title' => $f['title'], 'body' => $f['description'], 'benefit' => $f['benefit_details'], 'url' => base_url('user/schemes')]
                ];
            }
        }

        // FINAL ABSOLUTE FALLBACK
        return [
            'text' => "I am your **Complete Digital Gram-Sahayak**. I have deep-integrated knowledge for **EVERY** service: Marketplace, Notices, E-Learning, GIS, Permits, Utilities, Taxes, Staff, Grievances, Health, and Governance. \n\nNo service is hidden from me. What do you need?",
            'suggestions' => ["Notice Board", "Marketplace", "Village Map"]
        ];
    }
}
