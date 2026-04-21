<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Categories - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #6366f1; --dark: #0f172a; --gray-50: #f8fafc; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-50); display: flex; color: var(--dark); }
        .sidebar { width: 280px; position: fixed; height: 100vh; }
        .main-content { margin-left: 280px; width: calc(100% - 280px); min-height: 100vh; padding: 2.5rem; }
        
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; }
        .btn-add { background: var(--primary); color: white; padding: 0.8rem 1.5rem; border-radius: 12px; border: none; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3); }

        .cat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem; }
        .cat-card { background: white; border-radius: 20px; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03); transition: 0.3s; border: 1px solid var(--gray-200); position: relative; overflow: hidden; }
        .cat-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
        
        .cat-icon { width: 50px; height: 50px; background: rgba(99, 102, 241, 0.1); color: var(--primary); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; margin-bottom: 1.5rem; }
        .cat-name { font-size: 1.25rem; font-weight: 800; margin-bottom: 0.5rem; }
        .cat-desc { font-size: 0.9rem; color: #64748b; line-height: 1.6; margin-bottom: 1.5rem; }
        
        .cat-meta { display: flex; gap: 20px; padding-top: 1.5rem; border-top: 1px solid var(--gray-100); }
        .meta-item { display: flex; flex-direction: column; }
        .meta-label { font-size: 0.65rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
        .meta-val { font-size: 0.95rem; font-weight: 700; color: var(--gray-700); }

        /* Modal */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 2rem; }
        .modal-overlay.open { display: flex; }
        .modal { background: white; width: 100%; max-width: 550px; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); overflow: hidden; }
        .modal-header { padding: 1.5rem 2rem; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center; background: var(--gray-50); }
        .modal-body { padding: 2rem; }
        
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.6rem; font-weight: 700; font-size: 0.85rem; color: var(--gray-700); }
        input, select, textarea { width: 100%; padding: 0.9rem 1.2rem; border: 1px solid var(--gray-200); border-radius: 12px; font-size: 0.95rem; outline: none; transition: 0.2s; }
        input:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }
        
        .btn-submit { background: var(--dark); color: white; padding: 1rem; border: none; border-radius: 14px; font-weight: 800; cursor: pointer; width: 100%; font-size: 1rem; transition: 0.3s; }
        .btn-submit:hover { background: #1e293b; }

        .actions-abs { position: absolute; top: 20px; right: 20px; display: flex; gap: 8px; }
        .icon-btn { width: 32px; height: 32px; border-radius: 8px; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; background: var(--gray-50); color: #64748b; }
        .icon-btn:hover { background: var(--gray-100); color: var(--primary); }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>

    <div class="main-content">
        <div class="page-header">
            <div>
                <h1 style="font-size: 2rem; font-weight: 800;">Service Categories</h1>
                <p style="color: #64748b;">Configure processing time, prefixes, and fees for citizen services.</p>
            </div>
            <button class="btn-add" onclick="openModal()">
                <i class="fas fa-plus-circle"></i> Add Category
            </button>
        </div>

        <div class="cat-grid">
            <?php foreach($categories as $cat): ?>
            <div class="cat-card">
                <div class="actions-abs">
                    <button class="icon-btn" title="Edit" onclick="editCategory(<?= htmlspecialchars(json_encode($cat)) ?>)"><i class="fas fa-edit"></i></button>
                    <button class="icon-btn" title="Delete" onclick="confirmDelete('<?= base_url('admin/categories/delete/'.$cat['id']) ?>')" style="color: #ef4444;"><i class="fas fa-trash-alt"></i></button>
                </div>
                <div class="cat-icon"><i class="fas fa-certificate"></i></div>
                <div class="cat-name"><?= esc($cat['name']) ?></div>
                <div class="cat-desc"><?= esc($cat['description']) ?></div>
                <div class="cat-meta">
                    <div class="meta-item">
                        <span class="meta-label">Prefix</span>
                        <span class="meta-val"><?= esc($cat['prefix']) ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">TAT (Days)</span>
                        <span class="meta-val"><?= esc($cat['processing_days']) ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Fee</span>
                        <span class="meta-val">₹<?= number_format($cat['fees'], 2) ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal-overlay" id="categoryModal">
        <div class="modal">
            <div class="modal-header">
                <h2 id="modalTitle">New Service Category</h2>
                <button style="border:none; background:none; font-size: 1.5rem; cursor:pointer;" onclick="closeModal()">&times;</button>
            </div>
            <form action="<?= base_url('admin/categories/save') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="catId">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category Name *</label>
                        <input type="text" name="name" id="catName" required placeholder="e.g. Income Certificate">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Prefix *</label>
                            <input type="text" name="prefix" id="catPrefix" required placeholder="e.g. INC">
                        </div>
                        <div class="form-group">
                            <label>Processing Days *</label>
                            <input type="number" name="processing_days" id="catDays" required value="7">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Service Fee (₹) *</label>
                        <input type="number" step="0.01" name="fees" id="catFees" required value="0">
                    </div>
                    <div class="form-group">
                        <label>Service Description</label>
                        <textarea name="description" id="catDesc" rows="3" placeholder="Explain the purpose of this service..."></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Save Category</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openModal() {
            document.getElementById('modalTitle').innerText = "New Service Category";
            document.getElementById('catId').value = "";
            document.getElementById('catName').value = "";
            document.getElementById('catPrefix').value = "";
            document.getElementById('catDays').value = "7";
            document.getElementById('catFees').value = "0";
            document.getElementById('catDesc').value = "";
            document.getElementById('categoryModal').classList.add('open');
        }

        function editCategory(cat) {
            document.getElementById('modalTitle').innerText = "Edit Category";
            document.getElementById('catId').value = cat.id;
            document.getElementById('catName').value = cat.name;
            document.getElementById('catPrefix').value = cat.prefix;
            document.getElementById('catDays').value = cat.processing_days;
            document.getElementById('catFees').value = cat.fees;
            document.getElementById('catDesc').value = cat.description;
            document.getElementById('categoryModal').classList.add('open');
        }

        function closeModal() { document.getElementById('categoryModal').classList.remove('open'); }

        function confirmDelete(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Deleting this category won't delete existing certificates, but will prevent new ones from using this setup.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (result.isConfirmed) { window.location.href = url; }
            });
        }

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Success', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#6366f1' });
        <?php endif; ?>
    </script>
</body>
</html>
