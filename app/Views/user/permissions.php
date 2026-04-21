<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work & Event Permissions - Panchayat Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --primary-light: #eff6ff; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; --success: #10b981; --warning: #f59e0b; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 1000; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; display: flex; align-items: center; gap: 10px; color: white; text-decoration: none; }
        .sidebar-brand span { color: var(--primary); }
        .nav-menu { list-style: none; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 0.8rem 1rem; color: #94a3b8; text-decoration: none; border-radius: 8px; transition: all 0.3s; margin-bottom: 0.5rem; }
        .nav-link:hover, .nav-link.active { background-color: #334155; color: white; }
        .nav-link.active { background-color: var(--primary); }

        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); }
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .content-body { padding: 2.5rem; }

        .permission-grid { display: grid; grid-template-columns: 1fr 1.5fr; gap: 2rem; }
        .card { background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .card h2 { font-size: 1.25rem; margin-bottom: 1.5rem; color: var(--dark); border-bottom: 2px solid var(--gray-100); padding-bottom: 0.5rem; }

        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--gray-700); margin-bottom: 0.5rem; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.75rem; border: 1px solid var(--gray-200); border-radius: 8px; outline: none; transition: 0.3s; font-size: 0.95rem; }
        .form-group input:focus { border-color: var(--primary); }

        .btn-primary { background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; width: 100%; transition: 0.3s; }
        .btn-primary:hover { background: #1d4ed8; }

        .status-badge { padding: 0.4rem 0.9rem; border-radius: 20px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.02rem; }
        .status-pending { background: #fef3c7; color: #d97706; border: 1px solid #fcd34d; }
        .status-approved { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .status-rejected { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th { text-align: left; padding: 1rem; border-bottom: 2px solid var(--gray-100); color: #64748b; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05rem; }
        td { padding: 1rem; border-bottom: 1px solid var(--gray-100); font-size: 0.9rem; vertical-align: middle; }

        .empty-state { text-align: center; padding: 3rem; color: #94a3b8; }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; display: block; }
    </style>
</head>
<body>
    <div class="sidebar">
        <?= view('user/partials/sidebar') ?>
    </div>

    <div class="main-content">
        <header>
            <div style="font-weight: 700; font-size: 1.1rem; color: var(--dark);">Official Work & Event Permissions</div>
            <div>Welcome, <strong><?= session()->get('user_name') ?></strong></div>
        </header>

        <div class="content-body">
            <?php if(session()->getFlashdata('success')): ?>
                <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; border: 1px solid #6ee7b7;">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="permission-grid">
                <!-- Apply Form -->
                <div class="card">
                    <h2><i class="fas fa-edit"></i> Request Permission</h2>
                    <form action="<?= base_url('user/submit-permission') ?>" method="POST">
                        <div class="form-group">
                            <label>Applicant Name</label>
                            <input type="text" value="<?= session()->get('user_name') ?>" disabled style="background: var(--gray-100);">
                        </div>
                        <div class="form-group">
                            <label>Permission Category</label>
                            <select name="type" required>
                                <option value="">Select Category...</option>
                                <option value="Social Event / Wedding">Social Event / Wedding</option>
                                <option value="Construction Work">Construction Work</option>
                                <option value="Religious Festival">Religious Festival</option>
                                <option value="Village Fair / Mela">Village Fair / Mela</option>
                                <option value="Commercial Activity">Commercial Activity</option>
                                <option value="Other Utility Work">Other Utility Work</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Venue / Location</label>
                            <input type="text" name="venue" placeholder="e.g. Community Hall, Ward 4 Street, Plot 45" required>
                        </div>
                        <div class="form-group">
                            <label>Scheduled Date</label>
                            <input type="date" name="event_date" required min="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="form-group">
                            <label>Purpose / Description</label>
                            <textarea name="description" rows="4" placeholder="Briefly describe the work or event for which permission is required..." required></textarea>
                        </div>
                        <button type="submit" class="btn-primary">Submit Permission Application</button>
                    </form>
                </div>

                <!-- My Requests -->
                <div class="card">
                    <h2><i class="fas fa-history"></i> My Permission History</h2>
                    <?php if(empty($permissions)): ?>
                        <div class="empty-state">
                            <i class="fas fa-file-signature"></i>
                            <p>You haven't requested any permissions yet.</p>
                        </div>
                    <?php else: ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Service Type</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($permissions as $req): ?>
                                    <tr>
                                        <td><strong><?= date('d M Y', strtotime($req['event_date'])) ?></strong></td>
                                        <td>
                                            <div style="font-weight: 600; color: var(--dark);"><?= $req['type'] ?></div>
                                            <div style="font-size: 0.75rem; color: #64748b; font-style: italic; line-height: 1.2;">
                                                <strong>Note:</strong> <?= $req['description'] ?>
                                            </div>
                                        </td>
                                        <td><span style="color: #64748b; font-size: 0.8rem;"><i class="fas fa-map-pin"></i> <?= $req['venue'] ?></span></td>
                                        <td>
                                            <span class="status-badge status-<?= strtolower($req['status']) ?>">
                                                <?= $req['status'] ?>
                                            </span>
                                            <?php if($req['status'] == 'Rejected' && !empty($req['remarks'])): ?>
                                                <div style="font-size: 0.7rem; color: #ef4444; margin-top: 8px; font-style: italic; max-width: 150px;">
                                                    <strong>Reason:</strong> <?= $req['remarks'] ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
