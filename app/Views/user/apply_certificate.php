<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for E-Certificates - Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; display: flex; align-items: center; gap: 10px; color: white; text-decoration: none; }
        .sidebar-brand span { color: var(--primary); }
        .nav-menu { list-style: none; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 0.8rem 1rem; color: #94a3b8; text-decoration: none; border-radius: 8px; transition: all 0.3s; margin-bottom: 0.5rem; }
        .nav-link:hover, .nav-link.active { background-color: #334155; color: white; }
        .nav-link.active { background-color: var(--primary); }

        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); }
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .content-body { padding: 2rem; }

        .form-card { background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); max-width: 600px; margin: 0 auto; }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem; }
        select, input, textarea { width: 100%; padding: 0.9rem; border: 1px solid var(--gray-200); border-radius: 10px; font-size: 1rem; }
        .btn-submit { width: 100%; padding: 1rem; background: var(--primary); color: white; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; font-size: 1rem; }

        .table-section { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 2rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th { text-align: left; padding: 1rem; background: var(--gray-100); color: var(--gray-700); font-size: 0.85rem; }
        td { padding: 1rem; border-bottom: 1px solid var(--gray-200); font-size: 0.95rem; }
    </style>
</head>
<body>
    <div class="sidebar">
        <?= view('user/partials/sidebar') ?>
    </div>

    <div class="main-content">
        <header>
            <div style="font-weight: 600;">E-Certificate Application Portal</div>
            <div>Welcome, <strong><?= session()->get('user_name') ?></strong></div>
        </header>

        <div class="content-body">
            <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
                <a href="<?= base_url('user/dashboard') ?>" style="color: var(--primary); text-decoration: none; font-weight: 600;"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                <div style="font-size: 0.7rem; color: #cbd5e1; cursor: help;" title="Debug: UID:<?= $debug_user_id ?? '?' ?> | CC:<?= $debug_cert_count ?? '0' ?>">
                    <i class="fas fa-bug"></i>
                </div>
            </div>

            <!-- Apply for New Certificate Section -->
            <div class="form-card" style="margin-bottom: 3rem;">
                <h1 style="margin-bottom: 0.5rem; color: var(--dark);">Request New E-Certificate</h1>
                <p style="color: #64748b; margin-bottom: 2rem;">Fill the details below to apply for a digital document issuance.</p>
                
                <form action="<?= base_url('user/submit-application') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label>Select Service *</label>
                        <select name="service_type" required onchange="toggleFormHelp(this.value)">
                            <option value="">-- Select Certificate Type --</option>
                            <option value="Birth Certificate">Birth Certificate</option>
                            <option value="Death Certificate">Death Certificate</option>
                            <option value="Income Certificate">Income Certificate</option>
                            <option value="Caste Certificate">Caste Certificate</option>
                            <option value="Domicile Certificate">Domicile Certificate</option>
                        </select>
                    </div>

                    <div id="form-help-text" style="background: #f8fafc; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; display: none; font-size: 0.85rem; border-left: 4px solid var(--primary);">
                        <i class="fas fa-info-circle"></i> Please provide the details of the registered event so we can find your record.
                    </div>

                    <div class="form-group">
                        <label>Reason for Request *</label>
                        <textarea name="purpose" rows="2" placeholder="e.g. For Passport, School, Legal work..." required></textarea>
                    </div>

                    <div id="dynamic-fields" style="display: none; border-top: 1px solid var(--gray-200); padding-top: 1.5rem; margin-top: 1rem;">
                        <div class="form-group">
                            <label>Name of the Person (for the certificate) *</label>
                            <input type="text" name="data[person_name]" placeholder="Full Name" required>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label>Gender *</label>
                                <select name="data[gender]">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Date of Event *</label>
                                <input type="date" name="data[date_of_event]" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label id="place-label">Place of Event (Hospital/Home address) *</label>
                            <input type="text" name="data[place_of_event]" id="place-input" placeholder="Complete location address" required>
                        </div>

                        <div class="form-group">
                            <label id="ward-label">Village Ward Number *</label>
                            <input type="text" name="data[village_ward]" id="ward-input" placeholder="Enter ward number" required>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label>Social Category *</label>
                                <select name="data[category]" required>
                                    <option value="General">General</option>
                                    <option value="SC">SC</option>
                                    <option value="ST">ST</option>
                                    <option value="OBC">OBC</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Caste Name *</label>
                                <input type="text" name="data[caste_name]" placeholder="e.g. Gurjar, Maratha, etc." required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Religion *</label>
                            <input type="text" name="data[religion]" placeholder="e.g. Hindu, Muslim, etc." required>
                        </div>

                        <div class="form-group">
                            <label>Financial Year *</label>
                            <select name="data[financial_year]" required>
                                <option value="2024-25">2024-25</option>
                                <option value="2025-26" selected>2025-26</option>
                                <option value="2026-27">2026-27</option>
                            </select>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label>Father's Name *</label>
                                <input type="text" name="data[father_name]" placeholder="Full Name of Father" required>
                            </div>
                            <div class="form-group">
                                <label>Mother's Name *</label>
                                <input type="text" name="data[mother_name]" placeholder="Full Name of Mother" required>
                            </div>
                        </div>

                        <!-- Specific Fields -->
                        <div id="birth-only" style="display: none;">
                            <div class="form-group">
                                <label>Weight at Birth (in kg)</label>
                                <input type="number" step="0.01" name="data[weight_at_birth]" placeholder="e.g. 3.2">
                            </div>
                        </div>

                        <div id="death-only" style="display: none;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div class="form-group">
                                    <label>Age of Deceased (Years) *</label>
                                    <input type="number" name="data[age_at_event]" placeholder="Age at time of death">
                                </div>
                                <div class="form-group">
                                    <label>Cause of Death</label>
                                    <input type="text" name="data[cause_of_death]" placeholder="Medical reason if known">
                                </div>
                            </div>
                        </div>

                        <div id="income-only" style="display: none;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div class="form-group">
                                    <label>Profession / Occupation *</label>
                                    <input type="text" name="data[profession]" id="profession-input" placeholder="e.g. Farmer, Shopkeeper">
                                </div>
                                <div class="form-group">
                                    <label>Annual Income (₹) *</label>
                                    <input type="number" name="data[annual_income]" id="income-input" placeholder="Total household income">
                                </div>
                            </div>
                        </div>

                        <div id="domicile-only" style="display: none;">
                            <div class="form-group">
                                <label>Duration of Stay in MP (Years) *</label>
                                <input type="number" name="data[stay_duration]" placeholder="e.g. 15">
                            </div>
                            <div class="form-group">
                                <label>Identification Mark / Aadhar No *</label>
                                <input type="text" name="data[id_proof_no]" placeholder="For verification purpose">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">Submit Application</button>
                </form>
            </div>

            <!-- Issued Documents Section -->
            <?php if(!empty($issued_certificates)): ?>
            <div class="table-section" style="border-top: 5px solid #10b981;">
                <h2 style="color: #065f46;"><i class="fas fa-certificate" style="margin-right: 10px;"></i> My Ready Digital Certificates</h2>
                <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 1rem;">These documents are officially issued and ready for download.</p>
                <table>
                    <thead>
                        <tr>
                            <th>Reg No</th>
                            <th>Certificate</th>
                            <th>Subject</th>
                            <th>Issued On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($issued_certificates as $cert): ?>
                        <tr>
                            <td style="font-family: monospace; font-weight: 700;"><?= $cert['registration_no'] ?></td>
                            <td><strong><?= $cert['type'] ?> Certificate</strong></td>
                            <td><?= $cert['person_name'] ?></td>
                            <td><?= date('d M Y', strtotime($cert['created_at'])) ?></td>
                            <td>
                                <a href="<?= base_url('user/certificate/view/'.$cert['id']) ?>" target="_blank" style="background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; font-weight: 700;">
                                    Download PDF
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
            <div class="table-section" style="margin-top: 3rem;">
                <h2 style="color: var(--dark); margin-bottom: 1.5rem;"><i class="fas fa-history"></i> My Application History</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Service Type</th>
                            <th>Applied On</th>
                            <th>Current Status</th>
                            <th>Remarks / Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($applications)): ?>
                            <tr><td colspan="4" style="text-align: center; color: #94a3b8; padding: 2rem;">No applications found.</td></tr>
                        <?php else: ?>
                            <?php foreach($applications as $app): ?>
                            <tr>
                                <td style="font-weight: 600;"><?= $app['service_type'] ?></td>
                                <td><?= date('d M Y', strtotime($app['applied_at'])) ?></td>
                                <td>
                                    <span class="badge badge-<?= strtolower($app['status']) ?>" style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">
                                        <?= $app['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if($app['status'] == 'Approved' && !empty($app['certificate_id'])): ?>
                                        <a href="<?= base_url('user/certificate/view/'.$app['certificate_id']) ?>" target="_blank" style="color: #2563eb; font-weight: 700; text-decoration: none;">
                                            <i class="fas fa-download"></i> Download PDF
                                        </a>
                                    <?php elseif($app['status'] == 'Rejected'): ?>
                                        <span style="color: #ef4444; font-size: 0.8rem; font-weight: 700;">Action Required</span>
                                    <?php else: ?>
                                        <span style="color: #64748b; font-size: 0.85rem; font-style: italic;">Verification in progress...</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <style>
                .badge-pending { background: #fef3c7; color: #92400e; }
                .badge-approved { background: #dcfce7; color: #166534; }
                .badge-rejected { background: #fee2e2; color: #991b1b; }
            </style>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleFormHelp(val) {
            const helpText = document.getElementById('form-help-text');
            const dynamicFields = document.getElementById('dynamic-fields');
            
            helpText.style.display = val ? 'block' : 'none';
            dynamicFields.style.display = val ? 'block' : 'none';
            
            // Dynamic Labels based on certificate type
            const wardLabel = document.getElementById('ward-label');
            const wardInput = document.getElementById('ward-input');
            const placeLabel = document.getElementById('place-label');
            const placeInput = document.getElementById('place-input');

            if (val === 'Birth Certificate' || val === 'Death Certificate') {
                wardLabel.innerText = "Complete Address Details *";
                wardInput.placeholder = "e.g. Ward No, Village Name, District";
                placeLabel.innerText = "Place of Event (Hospital/Home address) *";
                placeInput.placeholder = "Full address of hospital or home";
            } else {
                wardLabel.innerText = "Residential Ward Number *";
                wardInput.placeholder = "Your registered village ward";
                placeLabel.innerText = "Full Residential Address *";
                placeInput.placeholder = "House No, Street, Village, District";
            }

            // Remove required from all conditional sections first
            const conditionalInputs = document.querySelectorAll('#income-only input, #domicile-only input');
            conditionalInputs.forEach(input => input.required = false);

            document.getElementById('birth-only').style.display = (val === 'Birth Certificate') ? 'block' : 'none';
            document.getElementById('death-only').style.display = (val === 'Death Certificate') ? 'block' : 'none';
            
            if (val === 'Income Certificate') {
                document.getElementById('income-only').style.display = 'block';
                document.getElementById('profession-input').required = true;
                document.getElementById('income-input').required = true;
            } else {
                document.getElementById('income-only').style.display = 'none';
            }

            document.getElementById('caste-only').style.display = (val === 'Caste Certificate') ? 'block' : 'none';
            document.getElementById('domicile-only').style.display = (val === 'Domicile Certificate') ? 'block' : 'none';
        }

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Submitted!',
                text: '<?= session()->getFlashdata('success') ?>',
                confirmButtonColor: '#2563eb'
            });
        <?php endif; ?>
    </script>
</body>
</html>
