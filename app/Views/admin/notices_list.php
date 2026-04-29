<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Notice Board - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; --accent: #8b5cf6; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 90; }
        .content-padding { padding: 2.5rem; }

        .page-header { display: flex; justify-content: space-between; align-items: end; margin-bottom: 2.5rem; }
        .btn-add { background: var(--dark); color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: 0.3s; text-decoration: none; }
        .btn-add:hover { background: #1e293b; transform: translateY(-2px); }

        .notice-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem; }
        .notice-card { background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #e2e8f0; position: relative; display: flex; flex-direction: column; transition: 0.3s; }
        .notice-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        
        .type-badge { position: absolute; top: 1.5rem; right: 1.5rem; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }
        .type-Notice { background: #eff6ff; color: #2563eb; }
        .type-Tender { background: #fef3c7; color: #d97706; }
        .type-News { background: #f0fdf4; color: #16a34a; }

        .notice-title { font-size: 1.25rem; font-weight: 800; color: var(--dark); line-height: 1.3; margin-bottom: 1rem; margin-top: 0.5rem; }
        .notice-content { color: #64748b; font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem; flex-grow: 1; }

        .meta-list { border-top: 1px solid #f1f5f9; padding-top: 1rem; margin-top: auto; }
        .meta-item { display: flex; align-items: center; gap: 8px; color: #94a3b8; font-size: 0.75rem; font-weight: 600; margin-bottom: 5px; }
        .meta-item i { width: 15px; color: var(--primary); }

        .card-actions { display: flex; gap: 10px; margin-top: 1.5rem; }
        .btn-delete { padding: 0.6rem; border: none; border-radius: 8px; background: #fee2e2; color: #dc2626; cursor: pointer; transition: 0.3s; }
        .btn-delete:hover { background: #fecaca; }

        /* Modal styling */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
        .modal-overlay.open { display: flex; }
        .modal { background: white; width: 550px; border-radius: 24px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }
        .modal-header { padding: 1.25rem 2rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #f8fafc; }
        .modal-body { padding: 2rem; }
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; margin-bottom: 0.4rem; font-weight: 800; font-size: 0.8rem; color: var(--gray-700); text-transform: uppercase; }
        input, select, textarea { width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 1rem; font-family: inherit; }
        textarea { resize: none; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800;"><i class="fas fa-bullhorn" style="color: var(--primary);"></i> Digital Notice Board Management</div>
            <div style="font-size: 0.85rem; color: #64748b;">Public announcements and government tenders.</div>
        </header>

        <div class="content-padding">
            <div class="page-header">
                <div>
                    <h1 style="font-size: 2.2rem; font-weight: 800;">Notices & Tenders</h1>
                    <p style="color: #64748b;">Post updates that will be visible to all residents.</p>
                </div>
                <button class="btn-add" onclick="openModal()">
                    <i class="fas fa-plus-circle"></i> Create New Post
                </button>
            </div>

            <div class="notice-grid">
                <?php foreach($notices as $n): ?>
                <div class="notice-card">
                    <span class="type-badge type-<?= $n['type'] ?>"><?= $n['type'] ?></span>
                    <h2 class="notice-title"><?= esc($n['title']) ?></h2>
                    <p class="notice-content"><?= esc($n['content']) ?></p>

                    <div class="meta-list">
                        <div class="meta-item">
                            <i class="far fa-calendar-alt"></i> Posted on: <?= date('d M, Y', strtotime($n['created_at'])) ?>
                        </div>
                        <?php if($n['expiry_date']): ?>
                        <div class="meta-item">
                            <i class="far fa-clock"></i> Expires: <?= date('d M, Y', strtotime($n['expiry_date'])) ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-actions">
                        <button class="btn-delete" onclick="confirmDelete(<?= $n['id'] ?>)">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- New Notice Modal -->
    <div class="modal-overlay" id="noticeModal">
        <div class="modal">
            <div class="modal-header">
                <h2 style="font-weight: 800;">Create New Announcement</h2>
                <button style="border:none; background:none; font-size: 1.5rem; cursor:pointer;" onclick="closeModal()">&times;</button>
            </div>
            <form action="<?= base_url('admin/notices/save') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title *</label>
                        <input type="text" name="title" placeholder="e.g. Village Cleanup Drive" required>
                    </div>
                    <div class="form-group">
                        <label>Type *</label>
                        <select name="type" required>
                            <option value="Notice">Notice</option>
                            <option value="Tender">Tender</option>
                            <option value="News">News / Update</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Content *</label>
                        <textarea name="content" rows="4" placeholder="Detailed description of the announcement..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Expiry Date (Optional)</label>
                        <input type="date" name="expiry_date">
                    </div>
                    <button type="submit" class="btn-add" style="width: 100%; justify-content: center; height: 50px; background: var(--primary);">Publish Now</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openModal() { document.getElementById('noticeModal').classList.add('open'); }
        function closeModal() { document.getElementById('noticeModal').classList.remove('open'); }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This announcement will be permanently removed!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                background: '#fff',
                borderRadius: '20px'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url('admin/notices/delete') ?>/" + id;
                }
            })
        }

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Great!', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#2563eb' });
        <?php endif; ?>
    </script>
</body>
</html>
