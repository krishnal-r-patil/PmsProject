<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Directory - Gram Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }
        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; display: flex; align-items: center; gap: 10px; color: white; text-decoration: none; }
        .sidebar-brand span { color: var(--primary); }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 0.8rem 1rem; color: #94a3b8; text-decoration: none; border-radius: 8px; transition: all 0.3s; margin-bottom: 0.5rem; }
        .nav-link:hover, .nav-link.active { background-color: #334155; color: white; }
        .nav-link.active { background-color: var(--primary); }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); padding: 2.5rem; }
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; }
        .asset-table-card { background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 1.25rem 1rem; background: var(--gray-100); color: var(--gray-700); font-size: 0.85rem; font-weight: 700; text-transform: uppercase; }
        td { padding: 1.25rem 1rem; border-bottom: 1px solid var(--gray-200); font-size: 0.95rem; }
        .asset-icon { width: 40px; height: 40px; border-radius: 10px; background: #eff6ff; color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
        .status-pill { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
        .status-Functional { background: #d1fae5; color: #065f46; }
        .status-Needs-Repair { background: #fee2e2; color: #b91c1c; }
        .btn-add { background: var(--primary); color: white; padding: 0.8rem 1.5rem; border-radius: 10px; text-decoration: none; font-weight: 600; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="sidebar">
        <?= view('admin/partials/sidebar') ?>
    </div>
    <div class="main-content">
        <div class="header-actions">
            <div>
                <h1>Panchayat Asset Register</h1>
                <p>Tracking movable and immovable assets of Gram Panchayat</p>
            </div>
            <button class="btn-add"><i class="fas fa-plus"></i> Register New Asset</button>
        </div>
        <div class="asset-table-card">
            <table>
                <thead>
                    <tr>
                        <th>Asset Details</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Value (In ₹)</th>
                        <th>Condition Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($assets as $a): ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div class="asset-icon"><i class="fas fa-<?= $a['asset_type'] == 'Building' ? 'home' : ($a['asset_type'] == 'Vehicle' ? 'truck' : 'map') ?>"></i></div>
                                <div>
                                    <div style="font-weight: 700;"><?= $a['asset_name'] ?></div>
                                    <div style="font-size: 0.8rem; color: var(--gray-700);">ID: #AST-<?= $a['id'] ?></div>
                                </div>
                            </div>
                        </td>
                        <td><?= $a['asset_type'] ?></td>
                        <td><?= $a['location'] ?></td>
                        <td style="font-weight: 600;">₹<?= number_format($a['cost']) ?></td>
                        <td><span class="status-pill status-<?= str_replace(' ', '-', $a['current_status']) ?>"><?= $a['current_status'] ?></span></td>
                        <td><a href="#" style="color: var(--primary); font-weight: 600;">Details</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
