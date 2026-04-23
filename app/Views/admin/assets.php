<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panchayat Asset Register - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; --success: #10b981; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 90; }
        .content-padding { padding: 2.5rem; }

        .btn-register { background: var(--dark); color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: 0.3s; }
        .btn-register:hover { background: #1e293b; transform: translateY(-2px); }

        .card { background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 1.25rem 1.5rem; background: #f8fafc; color: #64748b; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; border-bottom: 1px solid var(--gray-200); }
        td { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--gray-200); font-size: 0.95rem; }

        .asset-icon { width: 40px; height: 40px; border-radius: 10px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; color: var(--primary); }
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
        .status-Functional { background: #dcfce7; color: #166534; }
        .status-Needs-Repair { background: #fef9c3; color: #854d0e; }
        .status-Dilapidated { background: #fee2e2; color: #991b1b; }

        /* Modal */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: white; width: 550px; border-radius: 24px; overflow: hidden; }
        .modal-header { padding: 1.5rem 2rem; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center; background: #f8fafc; }
        .modal-body { padding: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--gray-700); font-size: 0.9rem; }
        input, select, textarea { width: 100%; padding: 0.8rem; border: 1px solid var(--gray-200); border-radius: 10px; font-size: 1rem; }
        .btn-submit { background: var(--primary); color: white; padding: 1rem; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; width: 100%; transition: 0.3s; margin-top: 1rem; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 700;"><i class="fas fa-city" style="color: var(--primary);"></i> Official Panchayat Asset Inventory</div>
            <div style="font-size: 0.85rem; color: #64748b;">Managing public resources and village property.</div>
        </header>

        <div class="content-padding">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
                <div>
                    <h1 style="font-size: 2rem; font-weight: 800;">Gram Panchayat Asset Register</h1>
                    <p style="color: #64748b;">Monitoring the health and valuation of all public assets.</p>
                </div>
                <button class="btn-register" onclick="openModal()">
                    <i class="fas fa-plus-circle"></i> Register New Asset
                </button>
            </div>

            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Asset Details</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Valuation (INR)</th>
                            <th>Condition Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($assets as $a): 
                            $icon = 'cube';
                            if($a['asset_type'] == 'Building') $icon = 'building';
                            if($a['asset_type'] == 'Vehicle') $icon = 'truck-pickup';
                            if($a['asset_type'] == 'Land') $icon = 'mountain';
                            if($a['asset_type'] == 'Water Body') $icon = 'water';
                            if($a['asset_type'] == 'Equipment') $icon = 'tools';
                        ?>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <div class="asset-icon"><i class="fas fa-<?= $icon ?>"></i></div>
                                    <div>
                                        <div style="font-weight: 700; color: var(--dark);"><?= esc($a['asset_name']) ?></div>
                                        <div style="font-size: 0.75rem; color: #94a3b8;">ID: #AST-<?= $a['id'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><span style="font-weight: 600; color: #64748b; font-size: 0.85rem;"><?= $a['asset_type'] ?></span></td>
                            <td><i class="fas fa-location-dot" style="color: #94a3b8; font-size:0.8rem;"></i> <?= esc($a['location']) ?></td>
                            <td style="font-weight: 800; color: var(--dark);">₹<?= number_format($a['cost'], 2) ?></td>
                            <td>
                                <span class="badge status-<?= str_replace(' ', '-', $a['current_status']) ?>">
                                    <?= $a['current_status'] ?>
                                </span>
                            </td>
                            <td>
                                <button onclick="openEditModal(<?= $a['id'] ?>, '<?= $a['current_status'] ?>')" style="border:none; background:#f1f5f9; padding:6px 12px; border-radius:8px; font-size:0.8rem; font-weight:700; cursor:pointer;">Update Status</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Asset Registration Modal -->
    <div class="modal-overlay" id="assetModal">
        <div class="modal">
            <div class="modal-header">
                <h2 style="font-weight: 800;"><i class="fas fa-plus-circle"></i> Register Official Asset</h2>
                <button style="border:none; background:none; font-size: 1.5rem; cursor:pointer;" onclick="closeModal()">&times;</button>
            </div>
            <form action="<?= base_url('admin/assets/save') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Asset Name *</label>
                        <input type="text" name="asset_name" placeholder="e.g. Primary Health Center" required>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label>Asset Category *</label>
                            <select name="asset_type" required>
                                <option value="Building">Building / Infrastructure</option>
                                <option value="Vehicle">Vehicle / Logistics</option>
                                <option value="Equipment">Equipment / Tools</option>
                                <option value="Land">Vacant Land / Garden</option>
                                <option value="Water Body">Water Body / Well</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Location / Ward *</label>
                            <input type="text" name="location" placeholder="e.g. Ward 4 Junction" required>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label>Initial Valuation (INR) *</label>
                            <input type="number" name="cost" placeholder="Money value..." required>
                        </div>
                        <div class="form-group">
                            <label>Current Status *</label>
                            <select name="current_status" required>
                                <option value="Functional">Functional</option>
                                <option value="Needs Repair">Needs Repair</option>
                                <option value="Dilapidated">Dilapidated / Damaged</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">Add to Inventory</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div class="modal-overlay" id="editModal">
        <div class="modal" style="width: 400px;">
            <div class="modal-header">
                <h2 style="font-weight: 800;">Update Asset Health</h2>
                <button style="border:none; background:none; font-size: 1.5rem; cursor:pointer;" onclick="closeEditModal()">&times;</button>
            </div>
            <form action="<?= base_url('admin/assets/update-status') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="asset-id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Condition Status *</label>
                        <select name="current_status" id="asset-status" required>
                            <option value="Functional">Functional</option>
                            <option value="Needs Repair">Needs Repair</option>
                            <option value="Dilapidated">Dilapidated / Damaged</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-submit">Confirm Update</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openModal() { document.getElementById('assetModal').classList.add('open'); }
        function closeModal() { document.getElementById('assetModal').classList.remove('open'); }

        function openEditModal(id, status) {
            document.getElementById('asset-id').value = id;
            document.getElementById('asset-status').value = status;
            document.getElementById('editModal').classList.add('open');
        }
        function closeEditModal() { document.getElementById('editModal').classList.remove('open'); }

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Asset Updated', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#2563eb' });
        <?php endif; ?>
    </script>
</body>
</html>
