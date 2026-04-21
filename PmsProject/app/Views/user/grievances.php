<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints Cell - Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 2rem; position: sticky; top: 0; z-index: 90; }
        
        .content-body { padding: 0 2.5rem 2.5rem; }
        .form-card { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 2rem; border-top: 4px solid var(--primary); }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem; color: var(--gray-700); }
        input, select, textarea { width: 100%; padding: 0.9rem; border: 1px solid var(--gray-200); border-radius: 10px; font-size: 1rem; }
        .btn-submit { background: var(--dark); color: white; padding: 1rem 1.5rem; border: none; border-radius: 12px; cursor: pointer; font-weight: 700; width: 100%; transition: 0.3s; }
        .btn-submit:hover { background: #1e293b; }

        .grievance-item { background: white; padding: 1.5rem; border-radius: 16px; margin-bottom: 1.25rem; border-left: 5px solid var(--primary); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .status-badge { float: right; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
        .status-open { background: #fee2e2; color: #dc2626; }
        .status-in-progress { background: #fef3c7; color: #92400e; }
        .status-resolved { background: #dcfce7; color: #166534; }
        .status-rejected { background: #f1f5f9; color: #64748b; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 600; color: var(--gray-700);"><i class="fas fa-bullhorn" style="color: #ef4444;"></i> Citizen Helpdesk & Grievance Cell</div>
            <div>Welcome, <strong><?= session()->get('user_name') ?></strong></div>
        </header>

        <div class="content-body">
            <h1 style="margin-bottom: 0.5rem; color: var(--dark);">Official Complaints Registry</h1>
            <p style="color: #64748b; margin-bottom: 2.5rem;">Report village issues directly to the Ward Member and Sarpanch.</p>

            <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 2.5rem;">
                <!-- Lodge Complaint Form -->
                <div>
                    <div class="form-card">
                        <h2 style="margin-bottom: 1.5rem; font-size: 1.25rem;"><i class="fas fa-edit"></i> Submit New Grievance</h2>
                        <form action="<?= base_url('user/submit-grievance') ?>" method="POST">
                            <?= csrf_field() ?>
                            <div class="form-group">
                                <label>Subject / Title *</label>
                                <input type="text" name="title" placeholder="e.g., Water leakage in Ward 04" required>
                            </div>
                            <div class="form-group">
                                <label>Department / Category *</label>
                                <select name="category" class="grievance-select" required style="width: 100%;">
                                    <optgroup label="Essential Services">
                                        <option value="Water">Water Supply (Leakage/Shortage)</option>
                                        <option value="Electricity">Electricity & Street Lights (Repairs)</option>
                                        <option value="Sanitation">Sanitation & Garbage Disposal</option>
                                        <option value="Drainage">Drainage & Sewage Issues</option>
                                    </optgroup>
                                    <optgroup label="Infrastructure & Land">
                                        <option value="Roads">Potholes & Road Repairs</option>
                                        <option value="Encroachment">Illegal Land Encroachment</option>
                                        <option value="Public Property">Panchayat Building/Park Repair</option>
                                        <option value="Street Cleanup">Jungle/Grass Cutting on Streets</option>
                                    </optgroup>
                                    <optgroup label="Government Schemes">
                                        <option value="Ration">Ration Card / PDS Issues</option>
                                        <option value="Housing">Housing Scheme (PM-Awas / Mukhyamantri Awas)</option>
                                        <option value="MNREGA">Employment / MNREGA Payments</option>
                                        <option value="Pension">Social Security Pension (Old Age/Widow)</option>
                                    </optgroup>
                                    <optgroup label="Health & Welfare">
                                        <option value="Health">Public Health / PHC Services</option>
                                        <option value="Anganwadi">Anganwadi & Nutrition Services</option>
                                        <option value="Education">Primary School / Education Quality</option>
                                        <option value="Agriculture">Agricultural Assistance & Fertilizer</option>
                                        <option value="Livestock">Animal Husbandry / Livestock Health</option>
                                    </optgroup>
                                    <optgroup label="Administration">
                                        <option value="Certificates">Birth/Death/Income Certificate Issues</option>
                                        <option value="Corruption">Report Corruption / Misbehavior</option>
                                        <option value="Taxes">Property Tax / Payment Issues</option>
                                        <option value="Other">Other Administrative Issues</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Complaint Description *</label>
                                <textarea name="description" rows="5" placeholder="Explain the location and nature of the problem..." required></textarea>
                            </div>
                            <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Lodge Official Complaint</button>
                        </form>
                    </div>
                </div>

                <!-- Submission History List -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h2 style="font-size: 1.25rem;"><i class="fas fa-history"></i> Tracking My Complaints</h2>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.8rem;"></i>
                            <input type="text" id="grievanceSearch" placeholder="Search my history..." 
                                   style="padding: 0.5rem 1rem 0.5rem 2rem; width: 220px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.8rem;">
                        </div>
                    </div>
                    
                    <div id="grievance-list">
                    <?php if(empty($grievances)): ?>
                        <div style="background: white; padding: 4rem; text-align: center; border-radius: 16px; color: #94a3b8; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <i class="fas fa-folder-open" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                            <p>No complaints lodged yet.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($grievances as $g): 
                            $statusClass = strtolower(str_replace(' ', '-', $g['status']));
                        ?>
                            <div class="grievance-item">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                                    <div style="font-weight: 700; font-size: 1.1rem; color: var(--dark);"><?= esc($g['title']) ?></div>
                                    <span class="status-badge status-<?= $statusClass ?>">
                                        <?= $g['status'] ?>
                                    </span>
                                </div>
                                <div style="font-size: 0.8rem; color: #64748b; margin-bottom: 1rem;">
                                    <i class="fas fa-tag"></i> <?= $g['category'] ?> | <i class="fas fa-calendar"></i> <?= date('d M Y', strtotime($g['created_at'])) ?>
                                </div>
                                <p style="font-size: 0.95rem; line-height: 1.6; color: var(--gray-700);"><?= nl2br(esc($g['description'])) ?></p>
                                
                                <?php if(!empty($g['remarks'])): ?>
                                    <div style="margin-top: 1.25rem; padding: 1rem; background: #f8fafc; border-radius: 12px; border-left: 4px solid var(--dark);">
                                        <div style="font-size: 0.75rem; font-weight: 700; color: var(--dark); text-transform: uppercase; margin-bottom: 6px;">Panchayat Response:</div>
                                        <p style="font-size: 0.85rem; color: var(--gray-700); font-style: italic;"><?= esc($g['remarks']) ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Official Submission Received',
                text: '<?= session()->getFlashdata('success') ?>',
                confirmButtonColor: '#0f172a',
                timer: 4000
            });
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Submission Failed',
                text: '<?= session()->getFlashdata('error') ?>',
                confirmButtonColor: '#ef4444'
            });
        <?php endif; ?>
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.grievance-select').select2({
                placeholder: "-- Search Category --",
                allowClear: true
            });
        });

        // Live Search for History
        document.getElementById('grievanceSearch').addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const items = document.querySelectorAll('#grievance-list .grievance-item');
            
            items.forEach(item => {
                const text = item.innerText.toLowerCase();
                item.style.display = text.includes(query) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
