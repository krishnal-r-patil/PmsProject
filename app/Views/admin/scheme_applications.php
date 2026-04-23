<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheme Applications - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
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
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-approved { background: #dcfce7; color: #166534; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }

        .btn-action { background: var(--primary); color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 0.8rem; }
        
        /* Modal */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: white; width: 550px; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); overflow: hidden; }
        .modal-header { padding: 1.5rem; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center; background: #f8fafc; }
        .modal-body { padding: 2rem; }
        
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
                <i class="fas fa-award" style="color: var(--primary);"></i> Welfare Schemes Administration
            </div>
            <div class="user-profile">
                <span style="font-size: 0.85rem; color: #64748b;"><?= session()->get('user_name') ?> (Admin)</span>
                <div class="user-avatar"><?= substr(session()->get('user_name'), 0, 1) ?></div>
            </div>
        </header>

        <div class="content-body">
            <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
                <div>
                    <h1>Scheme Applications</h1>
                    <p style="color: #64748b;">Review and process welfare enrollment requests.</p>
                </div>
                <div style="position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                    <input type="text" id="appSearch" placeholder="Search by name or scheme..." 
                           style="padding: 0.8rem 1rem 0.8rem 2.8rem; width: 350px; border-radius: 12px; border: 1px solid var(--gray-200); box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                </div>
            </div>

            <div class="card">
                <table id="appTable">
                    <thead>
                        <tr>
                            <th>Citizen Name</th>
                            <th>Scheme Category</th>
                            <th>Date Applied</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($applications)): ?>
                            <tr><td colspan="5" style="text-align: center; color: #94a3b8; padding: 3rem;">No scheme applications currently pending.</td></tr>
                        <?php else: ?>
                            <?php foreach($applications as $app): ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 700; color: var(--dark);"><?= esc($app['citizen_name']) ?></div>
                                    <div style="font-size: 0.75rem; color: #64748b;">Member ID: #<?= $app['user_id'] ?></div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: var(--primary);"><?= esc($app['scheme_title']) ?></div>
                                </td>
                                <td><?= date('d M Y', strtotime($app['applied_at'])) ?></td>
                                <td>
                                    <span class="badge badge-<?= strtolower($app['status']) ?>">
                                        <?= $app['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn-action" 
                                            onclick='openSchemeModal(this)'
                                            data-citizen="<?= esc($app['citizen_name']) ?>"
                                            data-id="<?= $app['id'] ?>"
                                            data-details='<?= htmlspecialchars($app['application_details'] ?: "{}") ?>'>
                                        Review Application
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal-overlay" id="schemeModal">
        <div class="modal">
            <div class="modal-header">
                <h2>Process Scheme Application</h2>
                <button style="border:none; background:none; font-size: 1.5rem; cursor:pointer;" onclick="closeModal()">&times;</button>
            </div>
            <form id="scheme-form" action="" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body" style="padding: 1.5rem;">
                    <div style="background: #f8fafc; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; border-left: 5px solid var(--primary);">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div>
                                <div style="font-size: 0.7rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Applicant Name</div>
                                <div id="modal-app-name" style="font-weight: 600; color: var(--dark); border-bottom: 1px dotted #ccc;"></div>
                            </div>
                            <div>
                                <div style="font-size: 0.7rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Aadhar Number</div>
                                <div id="modal-aadhar" style="font-weight: 600; color: var(--dark); border-bottom: 1px dotted #ccc;"></div>
                            </div>
                            <div>
                                <div style="font-size: 0.7rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Annual Income</div>
                                <div id="modal-income" style="font-weight: 600; color: #065f46; border-bottom: 1px dotted #ccc;"></div>
                            </div>
                            <div>
                                <div style="font-size: 0.7rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Category</div>
                                <div id="modal-category" style="font-weight: 600; color: var(--dark); border-bottom: 1px dotted #ccc;"></div>
                            </div>
                        </div>
                        <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
                            <div style="font-size: 0.7rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Remarks from Citizen</div>
                            <div id="modal-app-remarks" style="font-size: 0.9rem; color: var(--gray-700); font-style: italic;"></div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
                        <div class="form-group">
                            <label>Admin Decision *</label>
                            <select name="status" required onchange="toggleRemarks(this.value)">
                                <option value="Approved">Approve Enrollment</option>
                                <option value="Rejected">Reject Application</option>
                            </select>
                        </div>
                        <div class="form-group" id="remarks-group" style="display: none;">
                            <label>Rejection Reason / Next Steps *</label>
                            <textarea name="remarks" rows="3" placeholder="Explain the reason for rejection..."></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">Finalize Decision</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleRemarks(val) {
            document.getElementById('remarks-group').style.display = (val === 'Rejected') ? 'block' : 'none';
        }

        function openSchemeModal(btn) {
            try {
                const data = JSON.parse(btn.getAttribute('data-details'));
                const citizenName = btn.getAttribute('data-citizen');
                const appId = btn.getAttribute('data-id');

                document.getElementById('modal-app-name').innerText = data.applicant_name || citizenName;
                document.getElementById('modal-aadhar').innerText = data.aadhar_no || 'N/A';
                document.getElementById('modal-income').innerText = '₹' + (data.annual_income || '0');
                document.getElementById('modal-category').innerText = data.category || 'N/A';
                document.getElementById('modal-app-remarks').innerText = data.applicant_remarks || 'No specific remarks provided.';
                
                // Reset form visibility
                document.getElementById('remarks-group').style.display = 'none';
                document.querySelector('select[name="status"]').value = 'Approved';

                document.getElementById('scheme-form').action = "<?= base_url('admin/scheme-applications/process') ?>/" + appId;
                document.getElementById('schemeModal').classList.add('open');
            } catch (e) {
                console.error("Data Parse Error", e);
                 Swal.fire({
                    icon: 'error',
                    title: 'Data Load Error',
                    text: 'Error loading application details. Field may be empty.',
                    confirmButtonColor: '#2563eb'
                });
            }
        }

        function closeModal() { document.getElementById('schemeModal').classList.remove('open'); }

        // Live Search Logic
        document.getElementById('appSearch').addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('#appTable tbody tr');
            
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Action Completed', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#2563eb' });
        <?php endif; ?>
    </script>
</body>
</html>
