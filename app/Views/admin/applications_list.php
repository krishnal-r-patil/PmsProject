<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Certificate Approvals - Gram Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --sidebar-width: 280px;
            --primary: #6366f1;
            --dark: #0f172a;
            --dark-sidebar: #1e293b;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-700: #334155;
            --warning: #f59e0b;
            --success: #10b981;
            --danger: #ef4444;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark-sidebar); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 2rem 1.5rem; z-index: 1000; overflow-y: auto; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 0.8rem 1rem; color: #94a3b8; text-decoration: none; border-radius: 8px; transition: all 0.3s; margin-bottom: 0.5rem; }
        .nav-link:hover, .nav-link.active { background-color: #334155; color: white; }
        .nav-link.active { background-color: var(--primary); }

        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; padding: 2rem; }
        
        .header-actions { margin-bottom: 2rem; }
        .header-actions h1 { font-size: 1.8rem; color: var(--dark); }

        .table-card { background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); overflow: hidden; }
        
        table { width: 100%; border-collapse: collapse; }
        th { background: var(--gray-100); padding: 1rem; text-align: left; font-size: 0.85rem; font-weight: 600; color: var(--gray-700); text-transform: uppercase; }
        td { padding: 1rem; border-bottom: 1px solid var(--gray-200); font-size: 0.95rem; color: var(--dark); }
        
        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .bg-pending { background: #fef3c7; color: #92400e; }
        .bg-approved { background: #d1fae5; color: #065f46; }
        .bg-rejected { background: #fee2e2; color: #b91c1c; }

        .action-btns { display: flex; gap: 10px; }
        .btn-action { border: none; padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: 0.3s; }
        .btn-approve { background: #d1fae5; color: #065f46; }
        .btn-approve:hover { background: #10b981; color: white; }
        .btn-reject { background: #fee2e2; color: #b91c1c; }
        .btn-reject:hover { background: #ef4444; color: white; }
    </style>
</head>
<body>

    <div class="sidebar">
        <?= view('admin/partials/sidebar') ?>
    </div>

    <div class="main-content">
        <div class="header-actions">
            <h1>Service Requests & Approvals</h1>
            <p style="color: var(--gray-700);">Review and approve certificate applications from citizens</p>
        </div>

        <?php if(session()->getFlashdata('success')): ?>
            <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; border: 1px solid #6ee7b7;">
                <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Citizen Name</th>
                        <th>Service Type</th>
                        <th>Applied Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($applications)): ?>
                        <tr><td colspan="5" style="text-align:center; padding: 2rem;">No pending applications.</td></tr>
                    <?php else: ?>
                        <?php foreach($applications as $app): ?>
                        <tr>
                            <td style="font-weight: 500;"><?= $app['user_name'] ?></td>
                            <td><?= $app['service_type'] ?></td>
                            <td><?= date('d M Y', strtotime($app['applied_at'])) ?></td>
                            <td>
                                <span class="status-badge bg-<?= strtolower($app['status']) ?>">
                                    <?= $app['status'] ?>
                                </span>
                            </td>
                            <td>
                                <form id="form-<?= $app['id'] ?>" action="<?= base_url('admin/update-status') ?>" method="POST" style="display: flex; gap: 5px;">
                                    <input type="hidden" name="table" value="applications">
                                    <input type="hidden" name="id" value="<?= $app['id'] ?>">
                                    <input type="hidden" name="remarks" id="remarks-<?= $app['id'] ?>" value="">
                                    <button type="submit" name="status" value="Approved" class="btn-action btn-approve" title="Approve"><i class="fas fa-check"></i></button>
                                    <button type="button" onclick="rejectWithReason(<?= $app['id'] ?>)" class="btn-action btn-reject" title="Reject"><i class="fas fa-times"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function rejectWithReason(id) {
            Swal.fire({
                title: 'Reject Application',
                text: 'Please provide a reason for rejection:',
                input: 'textarea',
                inputPlaceholder: 'Enter reason here (e.g., Incomplete document proofs)...',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Yes, Reject it!',
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to provide a reason!'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('form-' + id);
                    const remarksInput = document.getElementById('remarks-' + id);
                    
                    // Create a hidden input for status=Rejected to submit with the form
                    const statusInput = document.createElement('input');
                    statusInput.type = 'hidden';
                    statusInput.name = 'status';
                    statusInput.value = 'Rejected';
                    
                    remarksInput.value = result.value;
                    form.appendChild(statusInput);
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>
