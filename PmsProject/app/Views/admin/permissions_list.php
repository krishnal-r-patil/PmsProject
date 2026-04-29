<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permission Approvals - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; --bg-body: #f8fafc; --success: #10b981; --danger: #ef4444; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg-body); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; display: flex; align-items: center; gap: 10px; color: white; text-decoration: none; }
        .sidebar-brand span { color: var(--primary); }
        .nav-menu { list-style: none; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 0.8rem 1rem; color: #94a3b8; text-decoration: none; border-radius: 8px; transition: all 0.3s; margin-bottom: 0.5rem; }
        .nav-link:hover, .nav-link.active { background-color: #334155; color: white; }
        .nav-link.active { background-color: var(--primary); }

        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); }
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .content-body { padding: 2.5rem; }

        .table-card { background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 1rem; background: #f8fafc; border-bottom: 1px solid var(--gray-200); color: #64748b; font-size: 0.85rem; text-transform: uppercase; font-weight: 600; }
        td { padding: 1.2rem 1rem; border-bottom: 1px solid var(--gray-200); font-size: 0.95rem; }
        
        .badge { padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
        .badge-pending { background: #fef3c7; color: #d97706; }
        .badge-approved { background: #d1fae5; color: #059669; }
        .badge-rejected { background: #fee2e2; color: #dc2626; }

        .btn-action { padding: 0.5rem; border-radius: 6px; border: none; cursor: pointer; color: white; transition: 0.3s; display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; }
        .btn-approve { background: var(--success); }
        .btn-reject { background: var(--danger); }
        .btn-approve:hover { background: #059669; }
        .btn-reject:hover { background: #dc2626; }
    </style>
</head>
<body>
    <div class="sidebar">
        <?= view('admin/partials/sidebar') ?>
    </div>

    <div class="main-content">
        <header>
            <div style="font-weight: 700; font-size: 1.1rem;">Official Permissions Management</div>
            <div>Mode: <strong>Administrator</strong></div>
        </header>

        <div class="content-body">
            <?php if(session()->getFlashdata('success')): ?>
                <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; border: 1px solid #6ee7b7;">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>Applicant</th>
                            <th>Request Type</th>
                            <th>Event Date</th>
                            <th>Location/Venue</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($permissions)): ?>
                            <tr><td colspan="6" style="text-align:center; padding: 3rem; color: #94a3b8;">No permission requests found.</td></tr>
                        <?php else: ?>
                            <?php foreach($permissions as $req): ?>
                            <tr>
                                <td><div style="font-weight: 600; color: var(--dark);"><?= $req['user_name'] ?></div></td>
                                <td>
                                    <div style="font-weight: 600; color: var(--dark); font-size: 0.95rem; margin-bottom: 2px;"><?= $req['type'] ?></div>
                                    <div style="font-size: 0.8rem; color: #64748b; font-style: italic; line-height: 1.2; max-width: 250px;">
                                        <strong>Purpose:</strong> <?= $req['description'] ?>
                                    </div>
                                </td>
                                <td><strong><?= date('d M Y', strtotime($req['event_date'])) ?></strong></td>
                                <td><i class="fas fa-map-marker-alt" style="color: #64748b;"></i> <?= $req['venue'] ?></td>
                                <td><span class="badge badge-<?= strtolower($req['status']) ?>"><?= $req['status'] ?></span></td>
                                <td>
                                    <form id="form-<?= $req['id'] ?>" action="<?= base_url('admin/update-status') ?>" method="POST" style="display: flex; gap: 8px;">
                                        <input type="hidden" name="table" value="permissions">
                                        <input type="hidden" name="id" value="<?= $req['id'] ?>">
                                        <input type="hidden" name="remarks" id="remarks-<?= $req['id'] ?>" value="">
                                        <button type="submit" name="status" value="Approved" title="Approve" class="btn-action btn-approve"><i class="fas fa-check"></i></button>
                                        <button type="button" onclick="rejectWithReason(<?= $req['id'] ?>)" title="Reject" class="btn-action btn-reject"><i class="fas fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function rejectWithReason(id) {
            Swal.fire({
                title: 'Reject Permission',
                text: 'Please provide a reason for rejection:',
                input: 'textarea',
                inputPlaceholder: 'Enter reason here (e.g., Security concerns, Invalid venue)...',
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
