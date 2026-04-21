<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grievance Management - E-Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; --danger: #ef4444; --warning: #f59e0b; --success: #10b981; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }
        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; padding: 2rem; }
        .header-actions { margin-bottom: 2rem; }
        .header-actions h1 { font-size: 1.8rem; color: var(--dark); }
        .table-card { background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { background: var(--gray-100); padding: 1.25rem 1rem; text-align: left; font-size: 0.85rem; font-weight: 600; color: var(--gray-700); text-transform: uppercase; }
        td { padding: 1.25rem 1rem; border-bottom: 1px solid var(--gray-200); font-size: 0.95rem; color: var(--dark); vertical-align: middle; }
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-approved { background: #d1fae5; color: #065f46; }
    </style>
</head>
<body>
    <div class="sidebar">
        <?= view('admin/partials/sidebar') ?>
    </div>
    <div class="main-content">
        <div class="header-actions">
            <h1>Citizen Grievance Cell</h1>
            <p style="color: var(--gray-700);">Resolving and tracking community complaints</p>
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
                        <th>Complaint ID</th>
                        <th>Description</th>
                        <th>Date Filed</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($grievances)): ?>
                        <tr><td colspan="5" style="text-align:center; padding: 3rem; color: #94a3b8;">No pending grievances.</td></tr>
                    <?php else: ?>
                        <?php foreach($grievances as $g): ?>
                        <tr>
                            <td>#GRV-<?= $g['id'] ?></td>
                            <td style="font-weight: 500; font-size: 0.85rem; max-width: 300px;"><?= $g['description'] ?></td>
                            <td><?= date('d M Y', strtotime($g['created_at'])) ?></td>
                            <td><span class="badge badge-<?= strtolower($g['status']) ?>"><?= $g['status'] ?></span></td>
                            <td>
                                <form id="form-<?= $g['id'] ?>" action="<?= base_url('admin/update-status') ?>" method="POST" style="display: flex; gap: 5px;">
                                    <input type="hidden" name="table" value="grievances">
                                    <input type="hidden" name="id" value="<?= $g['id'] ?>">
                                    <input type="hidden" name="remarks" id="remarks-<?= $g['id'] ?>" value="">
                                    <button type="submit" name="status" value="Approved" title="Resolve" style="background:#10b981; color:white; border:none; padding:6px 10px; border-radius:6px; cursor:pointer;"><i class="fas fa-check"></i></button>
                                    <button type="button" onclick="rejectWithReason(<?= $g['id'] ?>)" title="Dismiss" style="background:#ef4444; color:white; border:none; padding:6px 10px; border-radius:6px; cursor:pointer;"><i class="fas fa-times"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function rejectWithReason(id) {
            Swal.fire({
                title: 'Dismiss Grievance',
                text: 'Please provide a reason or resolution note:',
                input: 'textarea',
                inputPlaceholder: 'Enter note here...',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Yes, Process it!',
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
