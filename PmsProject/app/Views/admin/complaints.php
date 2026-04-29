<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Complaints - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { 
            --sidebar-width: 280px; 
            --primary: #6366f1; 
            --dark: #0f172a; 
            --dark-sidebar: #1e293b;
            --gray-100: #f1f5f9; 
            --gray-200: #e2e8f0; 
            --gray-700: #334155; 
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark-sidebar); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 2rem 1.5rem; z-index: 1000; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 90; }
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-avatar { width: 35px; height: 35px; background: #eff6ff; color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; }

        .content-body { padding: 2.5rem; }
        .page-header { margin-bottom: 2rem; }
        .page-header h1 { font-size: 1.8rem; color: var(--dark); }

        .card { background: white; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 1.25rem 1.5rem; background: #f8fafc; color: var(--gray-700); font-size: 0.85rem; border-bottom: 1px solid var(--gray-200); }
        td { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--gray-200); font-size: 0.95rem; }

        .badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
        .badge-open { background: #fee2e2; color: #dc2626; }
        .badge-in-progress { background: #fef3c7; color: #92400e; }
        .badge-resolved { background: #dcfce7; color: #166534; }
        .badge-rejected { background: #f1f5f9; color: #64748b; }

        .btn-action { background: var(--primary); color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 0.8rem; }
        
        /* Modal */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: white; width: 600px; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); overflow: hidden; }
        .modal-header { padding: 1.5rem; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center; background: #f8fafc; }
        .modal-body { padding: 2rem; }
        
        .info-row { margin-bottom: 1.5rem; }
        .info-label { font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; }
        .info-value { font-size: 1rem; color: var(--dark); line-height: 1.5; font-weight: 500; }

        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 700; font-size: 0.85rem; color: var(--gray-700); }
        select, textarea { width: 100%; padding: 0.8rem; border: 1px solid var(--gray-200); border-radius: 10px; font-size: 0.95rem; }

        .btn-submit { background: var(--dark); color: white; padding: 1rem 2rem; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; width: 100%; transition: 0.3s; }
        .btn-submit:hover { background: #1e293b; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 600; color: var(--gray-700);">
                <i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i> Citizen Grievance Management
            </div>
            <div class="user-profile">
                <span style="font-size: 0.85rem; color: #64748b;"><?= session()->get('user_name') ?> (Admin)</span>
                <div class="user-avatar"><?= substr(session()->get('user_name'), 0, 1) ?></div>
            </div>
        </header>

        <div class="content-body">
            <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
                <div>
                    <h1>Active Complaints Hub</h1>
                    <p style="color: var(--gray-700);">Review, investigate, and resolve citizen issues effectively.</p>
                </div>
                <div style="position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                    <input type="text" id="compSearch" placeholder="Search complaints..." 
                           style="padding: 0.8rem 1rem 0.8rem 2.8rem; width: 350px; border-radius: 12px; border: 1px solid var(--gray-200); box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                </div>
            </div>

            <div class="card">
                <table id="complaintsTable">
                    <thead>
                        <tr>
                            <th>Citizen</th>
                            <th>Complaint Details</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($complaints)): ?>
                            <tr><td colspan="5" style="text-align: center; color: #94a3b8; padding: 3rem;">No active complaints found.</td></tr>
                        <?php else: ?>
                            <?php foreach($complaints as $c): ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 700; color: var(--dark);"><?= esc($c['citizen_name']) ?></div>
                                    <div style="font-size: 0.75rem; color: #64748b;">ID: #<?= $c['id'] ?></div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: var(--dark);"><?= esc($c['title']) ?></div>
                                    <div style="font-size: 0.8rem; color: #64748b;"><?= date('d M Y', strtotime($c['created_at'])) ?></div>
                                </td>
                                <td><span style="font-size: 0.85rem; font-weight: 600; color: var(--primary);"><i class="fas fa-tag"></i> <?= $c['category'] ?></span></td>
                                <td>
                                    <span class="badge badge-<?= strtolower(str_replace(' ', '-', $c['status'])) ?>">
                                        <?= $c['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn-action" onclick='openGrievanceModal(<?= json_encode($c) ?>)'>View & Resolve</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Grievance Modal -->
    <div class="modal-overlay" id="grievanceModal">
        <div class="modal">
            <div class="modal-header">
                <h2>Complaint Investigation</h2>
                <button style="border:none; background:none; font-size: 1.5rem; cursor:pointer;" onclick="closeModal()">&times;</button>
            </div>
            <form id="grievance-form" action="" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="info-row">
                        <div class="info-label">Description from Citizen</div>
                        <div class="info-value" id="view-desc"></div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--gray-200);">
                        <div class="form-group">
                            <label>Update Status</label>
                            <select name="status" id="status-select" required>
                                <option value="In-Progress">Change to In-Progress</option>
                                <option value="Resolved">Accept & Resolve</option>
                                <option value="Rejected">Reject Complaint</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Admin Remarks / Result</label>
                            <textarea name="remarks" id="view-remarks" rows="3" placeholder="Explain the action taken or reason for rejection..."></textarea>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-submit">Submit Resolution</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openGrievanceModal(item) {
            document.getElementById('view-desc').innerText = item.description;
            document.getElementById('view-remarks').value = item.remarks || '';
            document.getElementById('status-select').value = item.status;
            document.getElementById('grievance-form').action = "<?= base_url('admin/complaints/process') ?>/" + item.id;
            document.getElementById('grievanceModal').classList.add('open');
        }

        function closeModal() { document.getElementById('grievanceModal').classList.remove('open'); }

        // Live Search Logic
        document.getElementById('compSearch').addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('#complaintsTable tbody tr');
            
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Updated!', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#2563eb' });
        <?php endif; ?>
    </script>
</body>
</html>
