<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Directory – Gram Panchayat Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 280px;
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --dark: #0f172a;
            --card-bg: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-600: #475569;
            --gray-700: #334155;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; min-height: 100vh; }

        .sidebar { width: var(--sidebar-width); background-color: #1e293b; height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 2rem 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; display: flex; flex-direction: column; }

        /* Header */
        .top-header { background: white; padding: 1.25rem 2.5rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 90; }
        .page-title-area h1 { font-size: 1.6rem; font-weight: 800; color: var(--dark); }
        .page-title-area p { font-size: 0.9rem; color: var(--gray-400); margin-top: 2px; }
        .btn-add-staff { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 0.75rem 1.5rem; border-radius: 12px; border: none; cursor: pointer; font-weight: 700; font-size: 0.95rem; display: flex; align-items: center; gap: 10px; transition: all 0.3s; box-shadow: 0 4px 15px rgba(99,102,241,0.35); }
        .btn-add-staff:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(99,102,241,0.45); }

        .content-area { padding: 2rem 2.5rem; flex: 1; }

        /* Flash messages */
        .alert { padding: 1rem 1.5rem; border-radius: 14px; margin-bottom: 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 12px; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        /* Stats Row */
        .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 2rem; }
        .stat-card { background: white; border-radius: 18px; padding: 1.5rem; box-shadow: 0 2px 12px rgba(0,0,0,0.04); border: 1px solid var(--gray-200); display: flex; align-items: center; gap: 1rem; }
        .stat-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
        .stat-icon.indigo { background: rgba(99,102,241,0.1); color: var(--primary); }
        .stat-icon.green  { background: rgba(16,185,129,0.1); color: var(--success); }
        .stat-icon.yellow { background: rgba(245,158,11,0.1); color: var(--warning); }
        .stat-icon.blue   { background: rgba(59,130,246,0.1); color: var(--info); }
        .stat-val { font-size: 1.8rem; font-weight: 800; color: var(--dark); line-height: 1; }
        .stat-lbl { font-size: 0.8rem; color: var(--gray-400); font-weight: 600; text-transform: uppercase; margin-top: 3px; }

        /* Filters */
        .filter-bar { background: white; border-radius: 16px; padding: 1.25rem 1.5rem; margin-bottom: 1.5rem; display: flex; gap: 1rem; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.04); flex-wrap: wrap; }
        .filter-bar input, .filter-bar select { padding: 0.65rem 1rem; border: 2px solid var(--gray-200); border-radius: 10px; font-size: 0.9rem; font-family: 'Outfit', sans-serif; outline: none; transition: all 0.2s; color: var(--dark); }
        .filter-bar input:focus, .filter-bar select:focus { border-color: var(--primary); }
        .filter-bar input { flex: 1; min-width: 200px; }

        /* Staff Grid */
        .staff-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(310px, 1fr)); gap: 1.5rem; }

        .staff-card { background: white; border-radius: 22px; padding: 1.75rem; box-shadow: 0 2px 12px rgba(0,0,0,0.04); border: 1px solid var(--gray-200); transition: all 0.3s; position: relative; overflow: hidden; }
        .staff-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--primary), var(--primary-dark)); opacity: 0; transition: opacity 0.3s; }
        .staff-card:hover { transform: translateY(-5px); box-shadow: 0 12px 35px rgba(0,0,0,0.1); border-color: rgba(99,102,241,0.2); }
        .staff-card:hover::before { opacity: 1; }

        .card-header-row { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem; }
        .staff-avatar { width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; font-weight: 800; color: white; flex-shrink: 0; }
        .staff-info .staff-name { font-size: 1.1rem; font-weight: 800; color: var(--dark); }
        .staff-info .staff-desig { font-size: 0.8rem; color: var(--primary); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 3px; }

        .staff-dept-badge { display: inline-block; background: var(--gray-100); color: var(--gray-600); font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 8px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem; }

        .info-grid { display: grid; gap: 0.6rem; margin-bottom: 1.25rem; }
        .info-row { display: flex; align-items: center; gap: 10px; font-size: 0.875rem; color: var(--gray-600); }
        .info-row i { width: 20px; color: var(--gray-400); text-align: center; }
        .info-row strong { color: var(--dark); font-weight: 600; }

        .status-pill { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
        .status-Active   { background: #dcfce7; color: #166534; }
        .status-On-Leave { background: #fef3c7; color: #92400e; }
        .status-Retired  { background: #f1f5f9; color: #64748b; }
        .status-dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; }

        .card-actions { display: flex; gap: 0.75rem; padding-top: 1.25rem; border-top: 1px solid var(--gray-100); margin-top: auto; }
        .btn-sm { flex: 1; text-align: center; padding: 0.6rem 1rem; border-radius: 10px; border: none; cursor: pointer; font-weight: 700; font-size: 0.82rem; display: flex; align-items: center; justify-content: center; gap: 7px; transition: all 0.2s; font-family: 'Outfit', sans-serif; }
        .btn-edit   { background: #eff6ff; color: #1d4ed8; }
        .btn-edit:hover   { background: #dbeafe; }
        .btn-delete { background: #fff0f0; color: #dc2626; }
        .btn-delete:hover { background: #fee2e2; }

        .empty-state { text-align: center; padding: 5rem 2rem; grid-column: 1/-1; }
        .empty-state i { font-size: 4rem; color: var(--gray-200); margin-bottom: 1.5rem; display: block; }
        .empty-state h3 { color: var(--gray-400); font-size: 1.2rem; }

        /* ── MODAL ── */
        .modal-overlay { position: fixed; inset: 0; background: rgba(15,23,42,0.6); z-index: 1000; display: none; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
        .modal-overlay.open { display: flex; }
        .modal-box { background: white; border-radius: 24px; width: 100%; max-width: 620px; max-height: 90vh; overflow-y: auto; padding: 2.5rem; box-shadow: 0 25px 60px rgba(0,0,0,0.2); animation: modalIn 0.3s cubic-bezier(0.34,1.56,0.64,1); }
        @keyframes modalIn { from { transform: scale(0.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        .modal-title { font-size: 1.4rem; font-weight: 800; color: var(--dark); margin-bottom: 2rem; display: flex; align-items: center; gap: 12px; }
        .modal-title i { color: var(--primary); }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
        .form-grid .full-width { grid-column: 1 / -1; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group label { font-size: 0.82rem; font-weight: 700; color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.5px; }
        .form-group input, .form-group select, .form-group textarea { padding: 0.75rem 1rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 0.94rem; font-family: 'Outfit', sans-serif; outline: none; transition: all 0.2s; color: var(--dark); }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(99,102,241,0.1); }
        .form-group textarea { resize: vertical; min-height: 80px; }

        .modal-footer { display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--gray-100); }
        .btn-cancel { background: var(--gray-100); color: var(--gray-600); padding: 0.75rem 1.5rem; border-radius: 12px; border: none; cursor: pointer; font-weight: 700; font-family: 'Outfit', sans-serif; font-size: 0.94rem; }
        .btn-save   { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 0.75rem 2rem; border-radius: 12px; border: none; cursor: pointer; font-weight: 700; font-family: 'Outfit', sans-serif; font-size: 0.94rem; box-shadow: 0 4px 12px rgba(99,102,241,0.35); }
        .btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,0.45); }
    </style>
</head>
<body>
<div class="sidebar">
    <?= view('admin/partials/sidebar') ?>
</div>

<div class="main-content">
    <!-- Header -->
    <div class="top-header">
        <div class="page-title-area">
            <h1><i class="fas fa-id-badge" style="color:var(--primary); margin-right:10px;"></i>Staff Service</h1>
            <p>Manage Panchayat employees, secretaries and field workers</p>
        </div>
        <button class="btn-add-staff" onclick="openAddModal()">
            <i class="fas fa-user-plus"></i> Add New Staff
        </button>
    </div>

    <div class="content-area">
        <!-- Flash Messages via SweetAlert2 (Handled in Script) -->
        <?php if(session()->getFlashdata('success')): ?>
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Success!',
                        html: '<?= session()->getFlashdata('success') ?>',
                        icon: 'success',
                        confirmButtonColor: '#6366f1',
                        timer: 3000
                    });
                };
            </script>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Error!',
                        text: '<?= session()->getFlashdata('error') ?>',
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                };
            </script>
        <?php endif; ?>

        <!-- Stats -->
        <?php
            $total    = count($staff);
            $active   = count(array_filter($staff, fn($s) => $s['status'] === 'Active'));
            $on_leave = count(array_filter($staff, fn($s) => $s['status'] === 'On Leave'));
            $retired  = count(array_filter($staff, fn($s) => $s['status'] === 'Retired'));
        ?>
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon indigo"><i class="fas fa-users"></i></div>
                <div><div class="stat-val"><?= $total ?></div><div class="stat-lbl">Total Staff</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
                <div><div class="stat-val"><?= $active ?></div><div class="stat-lbl">Active</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow"><i class="fas fa-user-clock"></i></div>
                <div><div class="stat-val"><?= $on_leave ?></div><div class="stat-lbl">On Leave</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-user-tie"></i></div>
                <div><div class="stat-val"><?= $retired ?></div><div class="stat-lbl">Retired</div></div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar">
            <i class="fas fa-search" style="color:var(--gray-400);"></i>
            <input type="text" id="searchInput" placeholder="Search by name or designation..." onkeyup="filterCards()">
            <select id="filterDept" onchange="filterCards()">
                <option value="">All Departments</option>
                <option>Administration</option>
                <option>Sanitation</option>
                <option>Education</option>
                <option>Health</option>
                <option>Agriculture</option>
                <option>Revenue</option>
                <option>Other</option>
            </select>
            <select id="filterStatus" onchange="filterCards()">
                <option value="">All Status</option>
                <option>Active</option>
                <option>On Leave</option>
                <option>Retired</option>
            </select>
        </div>

        <!-- Staff Cards Grid -->
        <div class="staff-grid" id="staffGrid">
            <?php if(empty($staff)): ?>
                <div class="empty-state">
                    <i class="fas fa-users-slash"></i>
                    <h3>No staff members recorded yet.</h3>
                    <p style="color:var(--gray-400); margin-top:8px;">Click "Add New Staff" to register the first employee.</p>
                </div>
            <?php else: ?>
                <?php
                    $avatarColors = ['#6366f1','#8b5cf6','#ec4899','#14b8a6','#f59e0b','#10b981','#3b82f6','#ef4444'];
                    $i = 0;
                    foreach($staff as $s):
                        $color = $avatarColors[$i % count($avatarColors)];
                        $i++;
                        $statusSlug = str_replace(' ', '-', $s['status']);
                ?>
                <div class="staff-card"
                     data-name="<?= strtolower($s['name']) ?> <?= strtolower($s['designation']) ?>"
                     data-dept="<?= $s['department'] ?>"
                     data-status="<?= $s['status'] ?>">

                    <div class="card-header-row">
                        <div class="staff-avatar" style="background: <?= $color ?>;">
                            <?= strtoupper(substr($s['name'], 0, 1)) ?>
                        </div>
                        <div class="staff-info">
                            <div class="staff-name"><?= esc($s['name']) ?></div>
                            <div class="staff-desig"><?= esc($s['designation']) ?></div>
                        </div>
                    </div>

                    <div class="staff-dept-badge"><i class="fas fa-building" style="margin-right:5px;"></i><?= esc($s['department']) ?></div>

                    <div class="info-grid">
                        <div class="info-row"><i class="fas fa-phone-alt"></i> <?= esc($s['phone']) ?></div>
                        <?php if(!empty($s['email'])): ?>
                        <div class="info-row"><i class="fas fa-envelope"></i> <?= esc($s['email']) ?></div>
                        <?php endif; ?>
                        <?php if(!empty($s['ward_no'])): ?>
                        <div class="info-row"><i class="fas fa-map-marker-alt"></i> Ward <?= esc($s['ward_no']) ?></div>
                        <?php endif; ?>
                        <div class="info-row"><i class="fas fa-calendar-alt"></i> Joined: <strong><?= date('d M Y', strtotime($s['joining_date'])) ?></strong></div>
                        <?php if(!empty($s['salary'])): ?>
                        <div class="info-row"><i class="fas fa-indian-rupee-sign"></i> Salary: <strong>₹<?= number_format($s['salary']) ?>/mo</strong></div>
                        <?php endif; ?>
                    </div>

                    <span class="status-pill status-<?= $statusSlug ?>">
                        <span class="status-dot"></span> <?= esc($s['status']) ?>
                    </span>

                    <div class="card-actions">
                        <button class="btn-sm btn-edit" onclick='openEditModal(<?= json_encode($s) ?>)'>
                            <i class="fas fa-pen"></i> Edit
                        </button>
                        <button class="btn-sm btn-delete" onclick="askConfirm('<?= base_url('admin/staff/delete/'.$s['id']) ?>', 'Remove <?= esc($s['name']) ?> from staff records?')">
                            <i class="fas fa-trash-alt"></i> Remove
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ── ADD MODAL ── -->
<div class="modal-overlay" id="addModal">
    <div class="modal-box">
        <div class="modal-title">
            <i class="fas fa-user-plus"></i> Register New Staff Member
        </div>
        <form action="<?= base_url('admin/staff/add') ?>" method="POST" id="addStaffForm">
            <?= csrf_field() ?>
            <div class="form-grid">
                <div class="form-group full-width">
                    <label>Full Name *</label>
                    <input type="text" name="name" placeholder="e.g. Ramesh Kumar Sharma" required>
                </div>
                <div class="form-group">
                    <label>Designation *</label>
                    <input type="text" name="designation" placeholder="e.g. Panchayat Secretary" required>
                </div>
                <div class="form-group">
                    <label>Department *</label>
                    <select name="department" required>
                        <option value="">-- Select --</option>
                        <option>Administration</option>
                        <option>Sanitation</option>
                        <option>Education</option>
                        <option>Health</option>
                        <option>Agriculture</option>
                        <option>Revenue</option>
                        <option>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Phone Number *</label>
                    <input type="text" name="phone" placeholder="10-digit mobile" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="official@mail.com">
                </div>
                <div class="form-group">
                    <label>Assigned Ward No.</label>
                    <input type="text" name="ward_no" placeholder="e.g. 3">
                </div>
                <div class="form-group">
                    <label>Date of Joining *</label>
                    <input type="date" name="joining_date" required>
                </div>
                <div class="form-group">
                    <label>Monthly Salary (₹)</label>
                    <input type="number" name="salary" placeholder="e.g. 18000">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="Active">Active</option>
                        <option value="On Leave">On Leave</option>
                        <option value="Retired">Retired</option>
                    </select>
                </div>
                <div class="form-group full-width">
                    <label>Residential Address</label>
                    <textarea name="address" placeholder="Full address of the staff member..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('addModal')">Cancel</button>
                <button type="submit" class="btn-save"><i class="fas fa-save"></i> Save Staff Record</button>
            </div>
        </form>
    </div>
</div>

<!-- ── EDIT MODAL ── -->
<div class="modal-overlay" id="editModal">
    <div class="modal-box">
        <div class="modal-title">
            <i class="fas fa-pen-to-square"></i> Edit Staff Record
        </div>
        <form id="editForm" method="POST">
            <?= csrf_field() ?>
            <div class="form-grid">
                <div class="form-group full-width">
                    <label>Full Name *</label>
                    <input type="text" name="name" id="edit_name" required>
                </div>
                <div class="form-group">
                    <label>Designation *</label>
                    <input type="text" name="designation" id="edit_designation" required>
                </div>
                <div class="form-group">
                    <label>Department *</label>
                    <select name="department" id="edit_department" required>
                        <option>Administration</option>
                        <option>Sanitation</option>
                        <option>Education</option>
                        <option>Health</option>
                        <option>Agriculture</option>
                        <option>Revenue</option>
                        <option>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Phone Number *</label>
                    <input type="text" name="phone" id="edit_phone" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" id="edit_email">
                </div>
                <div class="form-group">
                    <label>Assigned Ward No.</label>
                    <input type="text" name="ward_no" id="edit_ward_no">
                </div>
                <div class="form-group">
                    <label>Date of Joining *</label>
                    <input type="date" name="joining_date" id="edit_joining_date" required>
                </div>
                <div class="form-group">
                    <label>Monthly Salary (₹)</label>
                    <input type="number" name="salary" id="edit_salary">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="edit_status">
                        <option value="Active">Active</option>
                        <option value="On Leave">On Leave</option>
                        <option value="Retired">Retired</option>
                    </select>
                </div>
                <div class="form-group full-width">
                    <label>Residential Address</label>
                    <textarea name="address" id="edit_address"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('editModal')">Cancel</button>
                <button type="submit" class="btn-save"><i class="fas fa-save"></i> Update Record</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function openAddModal() {
    document.getElementById('addModal').classList.add('open');
}
function openEditModal(s) {
    document.getElementById('edit_name').value        = s.name;
    document.getElementById('edit_designation').value = s.designation;
    document.getElementById('edit_department').value  = s.department;
    document.getElementById('edit_phone').value       = s.phone;
    document.getElementById('edit_email').value       = s.email || '';
    document.getElementById('edit_ward_no').value     = s.ward_no || '';
    document.getElementById('edit_joining_date').value= s.joining_date;
    document.getElementById('edit_salary').value      = s.salary || '';
    document.getElementById('edit_status').value      = s.status;
    document.getElementById('edit_address').value     = s.address || '';
    document.getElementById('editForm').action        = '<?= base_url('admin/staff/edit/') ?>' + s.id;
    document.getElementById('editModal').classList.add('open');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
}
// Form Submission Popups
document.getElementById('addStaffForm').onsubmit = function() {
    Swal.fire({
        title: 'Registering...',
        text: 'Adding new staff member to the registry.',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });
};

document.getElementById('editForm').onsubmit = function() {
    Swal.fire({
        title: 'Updating...',
        text: 'Saving changes to the staff record.',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });
};

// Close on overlay click
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) overlay.classList.remove('open');
    });
});

function filterCards() {
    const q      = document.getElementById('searchInput').value.toLowerCase();
    const dept   = document.getElementById('filterDept').value;
    const status = document.getElementById('filterStatus').value;
    document.querySelectorAll('.staff-card').forEach(card => {
        const matchName   = card.dataset.name.includes(q);
        const matchDept   = !dept   || card.dataset.dept   === dept;
        const matchStatus = !status || card.dataset.status === status;
        card.style.display = (matchName && matchDept && matchStatus) ? '' : 'none';
    });
}

function askConfirm(url, msg) {
    Swal.fire({
        title: 'Confirm Removal',
        text: msg,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'Yes, Remove',
        cancelButtonText: 'Cancel',
        backdrop: 'rgba(15,23,42,0.5)'
    }).then(r => { if(r.isConfirmed) window.location.href = url; });
    return false;
}
</script>
</body>
</html>
