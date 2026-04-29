<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning Management – Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #6366f1; --primary-dark: #4f46e5; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }
        .sidebar { width: 280px; background-color: #1e293b; height: 100vh; position: fixed; padding: 2rem 1.5rem; color: white; }
        .main-content { margin-left: 280px; width: calc(100% - 280px); padding: 2.5rem; }
        .top-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; }
        .btn-add { background: var(--primary); color: white; padding: 0.8rem 1.5rem; border-radius: 12px; border: none; cursor: pointer; font-weight: 700; display: flex; align-items: center; gap: 10px; }
        .card { background: white; border-radius: 18px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 1.5rem; }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid var(--gray-200); }
        th { font-weight: 700; color: var(--gray-700); }
        .badge { padding: 4px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
        .badge-Scholarship { background: #dcfce7; color: #166534; }
        .badge-PMKVY { background: #fee2e2; color: #991b1b; }
        .badge-Course { background: #eff6ff; color: #1d4ed8; }
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
        .modal.open { display: flex; }
        .modal-content { background: white; padding: 2.5rem; border-radius: 24px; width: 100%; max-width: 550px; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 6px; font-weight: 700; font-size: 0.85rem; color: var(--gray-700); }
        input, select, textarea { width: 100%; padding: 0.8rem; border: 2px solid var(--gray-200); border-radius: 12px; font-family: inherit; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>
    <div class="main-content">
        <div class="top-header">
            <div>
                <h1 style="font-weight: 800;">E-Learning & Skills Registry</h1>
                <p style="color: #64748b;">Manage educational resources and vocational training info.</p>
            </div>
            <button class="btn-add" onclick="document.getElementById('addModal').classList.add('open')">
                <i class="fas fa-plus"></i> Add New Resource
            </button>
        </div>
        
        <?php if(session()->getFlashdata('success')): ?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Success!',
                        html: '<?= session()->getFlashdata('success') ?>',
                        icon: 'success',
                        confirmButtonColor: '#6366f1',
                        timer: 3000
                    });
                };
            </script>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Error!',
                        text: '<?= session()->getFlashdata('error') ?>',
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                };
            </script>
        <?php endif; ?>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Provider</th>
                        <th>Deadline</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($resources as $r): ?>
                    <tr>
                        <td><strong><?= esc($r['title']) ?></strong></td>
                        <td><span class="badge badge-<?= strpos($r['category'], 'Course') !== false ? 'Course' : $r['category'] ?>"><?= $r['category'] ?></span></td>
                        <td><?= esc($r['provider']) ?></td>
                        <td><?= $r['deadline'] ? date('d M Y', strtotime($r['deadline'])) : 'Open' ?></td>
                        <td>
                            <a href="#" onclick='openEditModal(<?= json_encode($r) ?>)' style="text-decoration: none; color: var(--primary); font-weight: 700; margin-right: 15px;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="#" onclick="return askDelete('<?= base_url('admin/elearning/delete/'.$r['id']) ?>', 'Delete this resource?')" style="text-decoration: none; color: #ef4444; font-weight: 700;">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ADD MODAL -->
    <div class="modal" id="addModal">
        <div class="modal-content">
            <h2 style="margin-bottom: 1.5rem; font-weight: 800;"><i class="fas fa-plus-circle" style="color: var(--primary);"></i> Add Resource</h2>
            <form action="<?= base_url('admin/elearning/save') ?>" method="POST" id="elearningForm">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label>Resource Title</label>
                    <input type="text" name="title" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" required>
                        <option>Scholarship</option>
                        <option>Online Course</option>
                        <option>Vocational Training</option>
                        <option>PMKVY</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" required rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Provider (Organization)</label>
                    <input type="text" name="provider" required>
                </div>
                <div class="form-group">
                    <label>External Link</label>
                    <input type="url" name="link" placeholder="https://...">
                </div>
                <div class="form-group">
                    <label>Deadline (Optional)</label>
                    <input type="date" name="deadline">
                </div>
                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="button" class="btn-add" style="background: var(--gray-200); color: var(--gray-700);" onclick="document.getElementById('addModal').classList.remove('open')">Cancel</button>
                    <button type="submit" class="btn-add" style="flex: 1; justify-content: center;">Save Resource</button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <h2 style="margin-bottom: 1.5rem; font-weight: 800;"><i class="fas fa-edit" style="color: var(--primary);"></i> Edit Resource</h2>
            <form id="editForm" method="POST">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label>Resource Title</label>
                    <input type="text" name="title" id="edit_title" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" id="edit_category" required>
                        <option>Scholarship</option>
                        <option>Online Course</option>
                        <option>Vocational Training</option>
                        <option>PMKVY</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="edit_description" required rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Provider (Organization)</label>
                    <input type="text" name="provider" id="edit_provider" required>
                </div>
                <div class="form-group">
                    <label>External Link</label>
                    <input type="url" name="link" id="edit_link" placeholder="https://...">
                </div>
                <div class="form-group">
                    <label>Deadline (Optional)</label>
                    <input type="date" name="deadline" id="edit_deadline">
                </div>
                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="button" class="btn-add" style="background: var(--gray-200); color: var(--gray-700);" onclick="document.getElementById('editModal').classList.remove('open')">Cancel</button>
                    <button type="submit" class="btn-add" style="flex: 1; justify-content: center;">Update Resource</button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('elearningForm').onsubmit = function() {
            Swal.fire({
                title: 'Saving...',
                text: 'Adding resource to the portal.',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
        };

        document.getElementById('editForm').onsubmit = function() {
            Swal.fire({
                title: 'Updating...',
                text: 'Saving changes to the resource.',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
        };

        function openEditModal(r) {
            document.getElementById('edit_title').value = r.title;
            document.getElementById('edit_category').value = r.category;
            document.getElementById('edit_description').value = r.description;
            document.getElementById('edit_provider').value = r.provider;
            document.getElementById('edit_link').value = r.link || '';
            document.getElementById('edit_deadline').value = r.deadline || '';
            document.getElementById('editForm').action = '<?= base_url('admin/elearning/update/') ?>' + r.id;
            document.getElementById('editModal').classList.add('open');
        }

        function askDelete(url, msg) {
            Swal.fire({
                title: 'Are you sure?',
                text: msg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                backdrop: 'rgba(15,23,42,0.5)'
            }).then(r => { if(r.isConfirmed) window.location.href = url; });
            return false;
        }
    </script>
</body>
</html>
