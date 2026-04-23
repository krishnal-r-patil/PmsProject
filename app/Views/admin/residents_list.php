<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parivar Register - Gram Panchayat</title>
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
            --success: #10b981;
            --danger: #ef4444;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark-sidebar); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 2rem 1.5rem; z-index: 1000; overflow-y: auto; }
        .nav-menu { list-style: none; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 0.8rem 1rem; color: #94a3b8; text-decoration: none; border-radius: 8px; transition: all 0.3s; margin-bottom: 0.5rem; }
        .nav-link:hover, .nav-link.active { background-color: #334155; color: white; }
        .nav-link.active { background-color: var(--primary); }

        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; padding: 2rem; }
        
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .header-actions h1 { font-size: 1.8rem; color: var(--dark); }
        
        .btn-add { background: var(--primary); color: white; padding: 0.6rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer; font-size: 0.9rem; }

        /* Flash Messages */
        .alert { padding: 0.85rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 500; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger  { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        .table-card { background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); overflow: hidden; }
        .filters { padding: 1.5rem; border-bottom: 1px solid var(--gray-200); display: flex; gap: 1rem; flex-wrap: wrap; }
        .filter-input { padding: 0.5rem 1rem; border: 1px solid var(--gray-200); border-radius: 6px; font-size: 0.9rem; }

        table { width: 100%; border-collapse: collapse; }
        th { background: var(--gray-100); padding: 1rem; text-align: left; font-size: 0.85rem; font-weight: 600; color: var(--gray-700); text-transform: uppercase; }
        td { padding: 1rem; border-bottom: 1px solid var(--gray-200); font-size: 0.95rem; color: var(--dark); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f8fafc; }
        
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .bg-blue  { background: #dbeafe; color: #1e40af; }
        .bg-green { background: #d1fae5; color: #065f46; }
        .bg-orange { background: #ffedd5; color: #9a3412; }
        .bg-purple { background: #ede9fe; color: #5b21b6; }
        .bg-red    { background: #fee2e2; color: #991b1b; }

        .action-btns { display: flex; gap: 8px; align-items: center; }
        .btn-action { display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; border: none; cursor: pointer; font-size: 0.85rem; text-decoration: none; transition: all 0.2s; }
        .btn-view   { background: #eff6ff; color: #2563eb; }
        .btn-edit   { background: #f0fdf4; color: #16a34a; }
        .btn-delete { background: #fff1f2; color: #e11d48; }
        .btn-view:hover   { background: #2563eb; color: white; }
        .btn-edit:hover   { background: #16a34a; color: white; }
        .btn-delete:hover { background: #e11d48; color: white; }

        /* Delete Confirmation Modal */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 200; align-items: center; justify-content: center; }
        .modal-overlay.active { display: flex; }
        .modal-box { background: white; border-radius: 16px; padding: 2rem; max-width: 420px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3); text-align: center; animation: popIn 0.25s ease; }
        @keyframes popIn { from { transform: scale(0.85); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        .modal-icon { width: 60px; height: 60px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.5rem; color: #e11d48; }
        .modal-title { font-size: 1.2rem; font-weight: 700; color: var(--dark); margin-bottom: 0.5rem; }
        .modal-body  { color: var(--gray-700); font-size: 0.95rem; margin-bottom: 1.5rem; }
        .modal-actions { display: flex; gap: 1rem; justify-content: center; }
        .btn-cancel { padding: 0.6rem 1.4rem; border: 1px solid var(--gray-200); border-radius: 8px; background: white; cursor: pointer; font-weight: 500; color: var(--gray-700); transition: all 0.2s; }
        .btn-cancel:hover { background: var(--gray-100); }
        .btn-confirm-delete { padding: 0.6rem 1.4rem; background: #e11d48; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.2s; }
        .btn-confirm-delete:hover { background: #be123c; }
    </style>
</head>
<body>

    <div class="sidebar">
        <?= view('admin/partials/sidebar') ?>
    </div>

    <div class="main-content">
        <div class="header-actions">
            <div>
                <h1>Parivar Register (Family Records)</h1>
                <p style="color: var(--gray-700);">Detailed records of all residents in Gram Panchayat</p>
            </div>
            <a href="<?= base_url('register') ?>" class="btn-add">
                <i class="fas fa-plus"></i> Add New Member
            </a>
        </div>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="table-card">
            <div class="filters">
                <input type="text" id="searchInput" placeholder="Search by name, Aadhar, or Family ID..." class="filter-input" style="width: 300px;">
                <select id="wardFilter" class="filter-input">
                    <option value="">All Wards</option>
                    <?php
                    $wards = [];
                    if (!empty($residents)) {
                        foreach ($residents as $r) {
                            if (!empty($r['ward_no']) && !in_array($r['ward_no'], $wards)) {
                                $wards[] = $r['ward_no'];
                            }
                        }
                        sort($wards);
                    }
                    foreach ($wards as $w):
                    ?>
                        <option value="<?= esc($w) ?>">Ward <?= esc($w) ?></option>
                    <?php endforeach; ?>
                </select>
                <select id="categoryFilter" class="filter-input">
                    <option value="">Category</option>
                    <option value="General">General</option>
                    <option value="OBC">OBC</option>
                    <option value="SC">SC</option>
                    <option value="ST">ST</option>
                </select>
                <button id="searchBtn" class="btn-add" style="background: var(--dark);">
                    <i class="fas fa-search"></i> Search
                </button>
                <button id="resetBtn" class="filter-input" style="background: white; cursor: pointer;">
                    Reset
                </button>
            </div>
            
            <table id="residentsTable">
                <thead>
                    <tr>
                        <th>Resident Details</th>
                        <th>Family ID</th>
                        <th>Ward/Village</th>
                        <th>Aadhar / Phone</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($residents)): ?>
                        <tr><td colspan="6" style="text-align:center; padding: 2rem; color: var(--gray-700);">
                            <i class="fas fa-users" style="font-size:2rem; display:block; margin-bottom:0.5rem; color:#cbd5e1;"></i>
                            No records found.
                        </td></tr>
                    <?php else: ?>
                        <?php foreach($residents as $r): ?>
                        <?php
                            $catColors = ['General'=>'bg-blue','OBC'=>'bg-green','SC'=>'bg-orange','ST'=>'bg-purple'];
                            $catClass = $catColors[$r['category']] ?? 'bg-blue';
                        ?>
                        <tr class="resident-row">
                            <td>
                                <div class="res-name" style="font-weight: 600;"><?= esc($r['name']) ?></div>
                                <div style="font-size: 0.8rem; color: var(--gray-700);">S/O: <?= esc($r['father_name']) ?></div>
                            </td>
                            <td><span class="badge bg-blue res-family-id"><?= esc($r['family_id']) ?></span></td>
                            <td>
                                <div class="res-ward">Ward <?= esc($r['ward_no']) ?></div>
                                <div style="font-size: 0.8rem; color: var(--gray-700);"><?= esc($r['village']) ?></div>
                            </td>
                            <td>
                                <div class="res-aadhar"><?= esc($r['aadhar_no']) ?></div>
                                <div style="font-size: 0.8rem; color: var(--gray-700);"><?= esc($r['phone']) ?></div>
                            </td>
                            <td><span class="badge <?= $catClass ?> res-category"><?= esc($r['category']) ?></span></td>
                            <td>
                                <div class="action-btns">
                                    <a href="<?= base_url('admin/residents/view/' . $r['id']) ?>"
                                       class="btn-action btn-view" title="View Profile">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/residents/edit/' . $r['id']) ?>"
                                       class="btn-action btn-edit" title="Edit Resident">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="btn-action btn-delete"
                                            title="Delete Resident"
                                            onclick="confirmDelete(<?= $r['id'] ?>, '<?= esc($r['name'], 'js') ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <div class="modal-icon"><i class="fas fa-trash"></i></div>
            <div class="modal-title">Delete Resident?</div>
            <p class="modal-body" id="deleteModalBody">Are you sure you want to delete this resident? This action cannot be undone.</p>
            <div class="modal-actions">
                <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                <a href="#" id="confirmDeleteBtn" class="btn-confirm-delete">Yes, Delete</a>
            </div>
        </div>
    </div>

    <script>
        // ------ Delete Modal ------
        function confirmDelete(id, name) {
            document.getElementById('deleteModalBody').textContent =
                'Are you sure you want to delete "' + name + '"? This action cannot be undone.';
            document.getElementById('confirmDeleteBtn').href = '<?= base_url('admin/residents/delete/') ?>' + id;
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }

        // Close modal on overlay click
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });

        // ------ Filtering ------
        document.getElementById('searchBtn').addEventListener('click', filterResidents);
        document.getElementById('resetBtn').addEventListener('click', () => {
            document.getElementById('searchInput').value = '';
            document.getElementById('wardFilter').value = '';
            document.getElementById('categoryFilter').value = '';
            filterResidents();
        });

        document.getElementById('searchInput').addEventListener('keyup', (e) => {
            if (e.key === 'Enter') filterResidents();
        });

        function filterResidents() {
            const searchText = document.getElementById('searchInput').value.toLowerCase();
            const wardValue  = document.getElementById('wardFilter').value;
            const catValue   = document.getElementById('categoryFilter').value;
            const rows = document.querySelectorAll('.resident-row');

            rows.forEach(row => {
                const name     = row.querySelector('.res-name').textContent.toLowerCase();
                const familyId = row.querySelector('.res-family-id').textContent.toLowerCase();
                const aadhar   = row.querySelector('.res-aadhar').textContent.toLowerCase();
                const ward     = row.querySelector('.res-ward').textContent;
                const category = row.querySelector('.res-category').textContent;

                const matchesText     = name.includes(searchText) || familyId.includes(searchText) || aadhar.includes(searchText);
                const matchesWard     = wardValue === '' || ward.includes(wardValue);
                const matchesCategory = catValue  === '' || category.includes(catValue);

                row.style.display = (matchesText && matchesWard && matchesCategory) ? '' : 'none';
            });
        }
    </script>

</body>
</html>
