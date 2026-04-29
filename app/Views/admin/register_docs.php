<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birth &amp; Death Register - Gram Panchayat</title>
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
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); padding: 2.5rem; }

        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .tab-container { display: flex; gap: 20px; margin-bottom: 2rem; border-bottom: 1px solid var(--gray-200); }
        .tab { padding: 1rem 2rem; cursor: pointer; font-weight: 600; color: var(--gray-700); border-bottom: 3px solid transparent; transition: 0.3s; }
        .tab.active { color: var(--primary); border-bottom-color: var(--primary); }

        .table-card { background: white; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 1.25rem 1rem; background: #f8fafc; color: var(--gray-700); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; border-bottom: 1px solid var(--gray-200); }
        td { padding: 1.25rem 1rem; border-bottom: 1px solid var(--gray-200); font-size: 0.9rem; vertical-align: top; }
        tr.hidden-row { display: none; }

        .reg-no { font-family: monospace; background: var(--gray-100); padding: 2px 6px; border-radius: 4px; font-weight: 600; font-size: 0.8rem; }
        .type-pill { padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }
        .pill-birth { background: #dcfce7; color: #166534; }
        .pill-death { background: #fee2e2; color: #991b1b; }
        .pill-stillbirth { background: #fef9c3; color: #854d0e; }

        .btn-add { background: var(--primary); color: white; padding: 0.8rem 1.5rem; border-radius: 10px; text-decoration: none; font-weight: 600; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 0.95rem; }
        .btn-outline { border: 1px solid var(--primary); color: var(--primary); background: transparent; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.8rem; font-weight: 600; transition: 0.3s; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-outline:hover { background: var(--primary); color: white; }

        .details-list { list-style: none; margin-top: 5px; }
        .details-list li { font-size: 0.75rem; color: var(--gray-700); display: flex; align-items: center; gap: 5px; margin-bottom: 2px; }

        /* Alert */
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #86efac; padding: 1rem 1.5rem; border-radius: 10px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; font-weight: 600; }

        /* Modal */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.55); z-index: 999; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: white; border-radius: 16px; width: 640px; max-width: 96vw; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: slideIn 0.3s ease; }
        @keyframes slideIn { from { transform: translateY(-30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header { padding: 1.5rem 2rem; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center; }
        .modal-header h2 { font-size: 1.2rem; color: var(--dark); }
        .modal-body { padding: 2rem; }
        .modal-close { background: none; border: none; font-size: 1.4rem; cursor: pointer; color: #94a3b8; transition: 0.2s; }
        .modal-close:hover { color: var(--dark); }

        /* Form */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }
        .form-group label { font-size: 0.8rem; font-weight: 700; color: var(--gray-700); text-transform: uppercase; letter-spacing: 0.3px; }
        .form-group input, .form-group select, .form-group textarea {
            padding: 0.75rem 1rem; border: 1px solid var(--gray-200); border-radius: 8px;
            font-size: 0.95rem; font-family: 'Inter', sans-serif; transition: 0.3s; outline: none;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
        }
        .conditional-field { display: none; }
        .modal-footer { padding: 1.5rem 2rem; border-top: 1px solid var(--gray-200); display: flex; justify-content: flex-end; gap: 1rem; }
        .btn-cancel { padding: 0.75rem 1.5rem; border: 1px solid var(--gray-200); border-radius: 8px; background: white; font-weight: 600; cursor: pointer; }
        .btn-save { padding: 0.75rem 1.5rem; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 1rem; display: flex; align-items: center; gap: 8px; }
        .btn-save:hover { background: #1d4ed8; }

        /* Hide checkboxes by default */
        .export-col { display: none; }
        .export-mode .export-col { display: table-cell; }
        .export-mode th.export-col { display: table-cell; }
        
        #export-actions-active { display: none; }
    </style>
</head>
<body>
    <div class="sidebar">
        <?= view('admin/partials/sidebar') ?>
    </div>

    <div class="main-content">

        <?php if(session()->getFlashdata('success')): ?>
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            <?= session()->getFlashdata('success') ?>
        </div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
        <div style="background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; padding:1rem 1.5rem; border-radius:10px; margin-bottom:1.5rem; display:flex; align-items:center; gap:10px; font-weight:600;">
            <i class="fas fa-exclamation-circle"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>

        <div class="header-actions">
            <div>
                <h1 style="font-size: 1.8rem; color: var(--dark);">Vital Statistics Register (<?= date('Y') ?>)</h1>
                <p style="color: var(--gray-700);">Official Civil Registration System (CRS) - Gram Panchayat Office</p>
            </div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <div id="export-actions-default">
                    <button type="button" class="btn-outline" onclick="enterExportMode()">
                        <i class="fas fa-file-export"></i> Export Register
                    </button>
                </div>
                <div id="export-actions-active" style="display: none; gap: 10px;">
                    <button type="button" class="btn-cancel" onclick="exitExportMode()" style="padding: 0.5rem 1rem;">
                        Cancel
                    </button>
                    <button type="button" class="btn-save" onclick="submitExport()" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                        <i class="fas fa-download"></i> Download Selected
                    </button>
                </div>
                
                <div style="position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem;"></i>
                    <input type="text" id="regSearch" placeholder="Search registry..." 
                           style="padding: 0.8rem 1rem 0.8rem 2.6rem; width: 250px; border-radius: 10px; border: 1px solid var(--gray-200); font-size: 0.9rem; outline: none;">
                </div>
                
                <button class="btn-add" id="btn-new-registration" onclick="openModal()">
                    <i class="fas fa-plus-circle"></i> New Registration
                </button>
            </div>
        </div>

        <div class="tab-container">
            <div class="tab active" id="tab-all"       onclick="filterTab('all')">All Records</div>
            <div class="tab"        id="tab-birth"     onclick="filterTab('Birth')">Live Births</div>
            <div class="tab"        id="tab-death"     onclick="filterTab('Death')">Deaths</div>
        </div>

        <form id="export-form" action="<?= base_url('admin/register-docs/export') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="table-card">
                <table id="crs-table">
                    <thead>
                        <tr>
                            <th width="40" class="export-col"><input type="checkbox" id="select-all" onclick="toggleSelectAll()"></th>
                            <th width="180">Reg No &amp; Status</th>
                            <th>Person Details</th>
                            <th>Parentage / Informant</th>
                            <th>Event Details</th>
                            <th>Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(empty($records)): ?>
                    <tr><td colspan="6" style="text-align:center; padding: 3rem; color: #94a3b8;">No records found. Click "New Registration" to add the first entry.</td></tr>
                    <?php else: ?>
                    <?php foreach($records as $r): ?>
                    <tr class="crs-row" data-type="<?= $r['type'] ?>">
                        <td class="export-col"><input type="checkbox" name="selected_ids[]" value="<?= $r['id'] ?>" class="record-checkbox"></td>
                        <td>
                            <div class="reg-no"><?= esc($r['registration_no']) ?></div>
                            <div style="margin-top: 8px;">
                                <span class="type-pill pill-<?= strtolower(str_replace(' ', '', $r['type'])) ?>">
                                    <?= esc($r['type']) ?>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 700; font-size: 1rem; color: var(--dark);"><?= esc($r['person_name']) ?></div>
                            <div style="font-size: 0.8rem; color: var(--gray-700); margin-top: 4px;">
                                <i class="fas fa-venus-mars"></i> <?= esc($r['gender']) ?> | 
                                <i class="fas fa-clock"></i> <?= $r['age_at_event'] ?> Years
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 600; font-size: 0.85rem;"><?= esc($r['father_mother_name']) ?></div>
                            <ul class="details-list">
                                <li><i class="fas fa-user-tag"></i> Informant: <?= esc($r['informant_name'] ?? 'Self/Family') ?></li>
                            </ul>
                        </td>
                        <td>
                            <div style="font-weight: 600;"><?= date('d M Y', strtotime($r['date_of_event'])) ?></div>
                            <?php if($r['type'] == 'Death'): ?>
                                <div style="font-size: 0.75rem; color: #ef4444;"><i class="fas fa-notes-medical"></i> Cause: <?= esc($r['cause_of_death']) ?></div>
                            <?php else: ?>
                                <div style="font-size: 0.75rem; color: #10b981;"><i class="fas fa-weight"></i> Weight: <?= $r['weight_at_birth'] ?> kg</div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="font-size: 0.85rem; font-weight: 600;"><?= esc($r['place_of_event']) ?></div>
                            <div style="font-size: 0.75rem; color: var(--gray-700);"><?= esc($r['village_ward']) ?></div>
                        </td>
                        <td>
                            <div style="display: flex; flex-direction: column; gap: 5px;">
                                <a href="<?= base_url('admin/register-docs/certificate/'.$r['id']) ?>" target="_blank" class="btn-outline" style="padding: 4px 8px;"><i class="fas fa-eye"></i> View/Print</a>
                                
                                <?php if($r['is_issued']): ?>
                                    <span style="font-size: 0.65rem; color: #10b981; font-weight: 700; text-align: center;"><i class="fas fa-check-circle"></i> Sent to User</span>
                                <?php else: ?>
                                    <button type="button" class="btn-outline" style="padding: 4px 8px; border-color: #f59e0b; color: #f59e0b;" onclick="openIssueModal(<?= $r['id'] ?>, '<?= esc($r['person_name']) ?>')">
                                        <i class="fas fa-paper-plane"></i> Send to User
                                    </button>
                                <?php endif; ?>
                                
                                <button type="button" class="btn-outline" style="padding: 4px 8px; border-color: var(--gray-200); color: var(--gray-700);" onclick="openEditModal(<?= $r['id'] ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        </form>
    </div>

    <!-- ===================== NEW REGISTRATION MODAL ===================== -->
    <div class="modal-overlay" id="registrationModal">
        <div class="modal">
            <div class="modal-header">
                <h2><i class="fas fa-file-medical" style="color: var(--primary);"></i> &nbsp;<span id="modal-title">New CRS Registration</span></h2>
                <button class="modal-close" onclick="closeModal()" id="btn-close-modal">&times;</button>
            </div>
            <form action="<?= base_url('admin/register-docs/save') ?>" method="POST" id="crs-form">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="edit-id">
                <div class="modal-body">
                    <div class="form-grid">

                        <!-- Type -->
                        <div class="form-group">
                            <label>Registration Type *</label>
                            <select name="type" id="reg-type" required onchange="toggleFields(this.value)">
                                <option value="">-- Select Type --</option>
                                <option value="Birth">Birth</option>
                                <option value="Death">Death</option>
                            </select>
                        </div>

                        <!-- Date -->
                        <div class="form-group">
                            <label>Date of Event *</label>
                            <input type="date" name="date_of_event" required max="<?= date('Y-m-d') ?>">
                        </div>

                        <!-- Person Name -->
                        <div class="form-group full">
                            <label>Person Name *</label>
                            <input type="text" name="person_name" placeholder="e.g. Baby of Sita / Ramesh Kumar" required>
                        </div>

                        <!-- Gender -->
                        <div class="form-group">
                            <label>Gender *</label>
                            <select name="gender" required>
                                <option value="">-- Select --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Age -->
                        <div class="form-group">
                            <label>Age at Event (Years)</label>
                            <input type="number" name="age_at_event" min="0" max="130" value="0">
                        </div>

                        <!-- Father/Mother -->
                        <div class="form-group full">
                            <label>Father / Mother / Spouse Name</label>
                            <input type="text" name="father_mother_name" placeholder="e.g. Ramesh & Sita Kumar / W/o Ramesh">
                        </div>

                        <!-- Informant -->
                        <div class="form-group full">
                            <label>Informant Name &amp; Relationship</label>
                            <input type="text" name="informant_name" placeholder="e.g. Ramesh Kumar (Father)">
                        </div>

                        <!-- Place -->
                        <div class="form-group">
                            <label>Place of Event *</label>
                            <input type="text" name="place_of_event" placeholder="e.g. CHC Burhanpur" required>
                        </div>

                        <!-- Ward -->
                        <div class="form-group">
                            <label>Ward / Village *</label>
                            <input type="text" name="village_ward" placeholder="e.g. Ward 01" required>
                        </div>

                        <!-- Birth-only field -->
                        <div class="form-group conditional-field" id="field-weight">
                            <label>Birth Weight (kg)</label>
                            <input type="number" name="weight_at_birth" step="0.01" min="0.5" max="10" placeholder="e.g. 3.20">
                        </div>

                        <!-- Death-only field -->
                        <div class="form-group conditional-field full" id="field-cause">
                            <label>Cause of Death</label>
                            <input type="text" name="cause_of_death" placeholder="e.g. Cardiac Arrest">
                        </div>

                        <!-- Remarks -->
                        <div class="form-group full">
                            <label>Remarks (Optional)</label>
                            <textarea name="remarks" rows="2" placeholder="Any additional notes..."></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-save" id="btn-submit-registration">
                        <i class="fas fa-save"></i> <span id="btn-text">Save Registration</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===================== ISSUE CERTIFICATE MODAL ===================== -->
    <div class="modal-overlay" id="issueModal">
        <div class="modal" style="width: 400px;">
            <div class="modal-header">
                <h2><i class="fas fa-paper-plane"></i> Issue Certificate</h2>
                <button class="modal-close" onclick="closeIssueModal()">&times;</button>
            </div>
            <form id="issue-form" action="" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <p style="font-size: 0.9rem; margin-bottom: 1.5rem; color: var(--gray-700);">
                        Select the registered user who should receive the certificate for <strong><span id="issue-target-name"></span></strong>.
                    </p>
                    <div class="form-group">
                        <label>Registered Recipient</label>
                        <select name="user_id" class="issue-select" required style="width: 100%;">
                            <option value="">-- Select Citizen --</option>
                            <?php foreach($users as $u): ?>
                                <option value="<?= $u['id'] ?>"><?= esc($u['name']) ?> (<?= esc($u['email']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeIssueModal()">Cancel</button>
                    <button type="submit" class="btn-save">Send Certificate</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // --- Popups ---
        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                html: '<?= session()->getFlashdata('success') ?>',
                confirmButtonColor: '#2563eb'
            });
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Operation Failed',
                text: '<?= session()->getFlashdata('error') ?>',
                confirmButtonColor: '#ef4444'
            });
        <?php endif; ?>

        // --- Modal ---
        function openModal() {
            document.getElementById('crs-form').reset();
            document.getElementById('edit-id').value = "";
            document.getElementById('crs-form').action = "<?= base_url('admin/register-docs/save') ?>";
            document.getElementById('modal-title').innerText = "New CRS Registration";
            document.getElementById('btn-text').innerText = "Save Registration";
            document.getElementById('reg-type').disabled = false;
            document.getElementById('registrationModal').classList.add('open');
        }

        async function openEditModal(id) {
            try {
                const response = await fetch("<?= base_url('admin/register-docs/get') ?>/" + id);
                const data = await response.json();
                
                const form = document.getElementById('crs-form');
                form.action = "<?= base_url('admin/register-docs/update') ?>/" + id;
                document.getElementById('edit-id').value = id;
                document.getElementById('modal-title').innerText = "Edit Registration (" + (data.registration_no || '') + ")";
                document.getElementById('btn-text').innerText = "Update Record";
                
                // Set values
                form.elements['type'].value = data.type || '';
                form.elements['type'].disabled = true; // Don't allow changing type after creation
                form.elements['date_of_event'].value = data.date_of_event || '';
                form.elements['person_name'].value = data.person_name || '';
                form.elements['gender'].value = data.gender || '';
                form.elements['age_at_event'].value = data.age_at_event || 0;
                form.elements['father_mother_name'].value = data.father_mother_name || '';
                form.elements['informant_name'].value = data.informant_name || '';
                form.elements['place_of_event'].value = data.place_of_event || '';
                form.elements['village_ward'].value = data.village_ward || '';
                form.elements['remarks'].value = data.remarks || '';
                form.elements['cause_of_death'].value = data.cause_of_death || '';
                form.elements['weight_at_birth'].value = data.weight_at_birth || '';
                
                toggleFields(data.type);
                document.getElementById('registrationModal').classList.add('open');
            } catch (error) {
                console.error("Error fetching data:", error);
                Swal.fire('Error', 'Could not fetch record data', 'error');
            }
        }

        function closeModal() { document.getElementById('registrationModal').classList.remove('open'); }
        
        function openIssueModal(id, name) {
            document.getElementById('issue-target-name').innerText = name;
            document.getElementById('issue-form').action = "<?= base_url('admin/register-docs/issue') ?>/" + id;
            document.getElementById('issueModal').classList.add('open');
        }
        function closeIssueModal() {
            document.getElementById('issueModal').classList.remove('open');
        }

        // Close on overlay click
        document.getElementById('registrationModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
        document.getElementById('issueModal').addEventListener('click', function(e) {
            if (e.target === this) closeIssueModal();
        });

        // --- Conditional Fields ---
        function toggleFields(type) {
            const weight = document.getElementById('field-weight');
            const cause  = document.getElementById('field-cause');
            weight.style.display = (type === 'Birth') ? 'flex' : 'none';
            cause.style.display  = (type === 'Death') ? 'flex' : 'none';
        }

        // --- Tab Filtering ---
        function filterTab(type) {
            // Update active tab
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            const tabMap = { all: 'tab-all', Birth: 'tab-birth', Death: 'tab-death' };
            document.getElementById(tabMap[type]).classList.add('active');

            // Show/hide rows
            document.querySelectorAll('.crs-row').forEach(row => {
                if (type === 'all' || row.dataset.type === type) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // --- Selection Logic ---
        function toggleSelectAll() {
            const master = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.record-checkbox');
            checkboxes.forEach(cb => {
                const row = cb.closest('.crs-row');
                if (row.style.display !== 'none') {
                    cb.checked = master.checked;
                }
            });
        }

        function submitExport() {
            const checkboxes = document.querySelectorAll('.record-checkbox:checked');
            if (checkboxes.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Selection',
                    text: 'Please select at least one record to export.',
                    confirmButtonColor: '#2563eb'
                });
                return;
            }
            document.getElementById('export-form').submit();
        }

        // --- Export Mode UI Toggles ---
        function enterExportMode() {
            document.body.classList.add('export-mode');
            document.getElementById('export-actions-default').style.display = 'none';
            document.getElementById('export-actions-active').style.display = 'flex';
        }

        function exitExportMode() {
            document.body.classList.remove('export-mode');
            document.getElementById('export-actions-default').style.display = 'block';
            document.getElementById('export-actions-active').style.display = 'none';
            
            // Uncheck all
            document.getElementById('select-all').checked = false;
            document.querySelectorAll('.record-checkbox').forEach(cb => cb.checked = false);
        }

        // --- Success/Error Popups ---
        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                html: '<?= session()->getFlashdata('success') ?>',
                confirmButtonColor: '#2563eb'
            });
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '<?= session()->getFlashdata('error') ?>',
                confirmButtonColor: '#2563eb'
            });
        <?php endif; ?>
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.issue-select').select2({
                placeholder: "-- Search Recipient --",
                allowClear: true,
                dropdownParent: $('#issueModal')
            });
        });

        // Live Search for Registry Tables
        document.getElementById('regSearch').addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const activeType = document.querySelector('.tab.active').innerText.replace(' Records', '');
            const rows = document.querySelectorAll('tbody tr:not(.hidden-row)');
            
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
