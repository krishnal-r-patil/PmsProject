<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Listings - Village Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #10b981; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 90; }
        .content-padding { padding: 2.5rem; }

        .page-header { display: flex; justify-content: space-between; align-items: end; margin-bottom: 2.5rem; }
        .btn-add { background: var(--dark); color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: 0.3s; text-decoration: none; }
        
        .table-card { background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #e2e8f0; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 1.2rem; background: #f8fafc; color: #64748b; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 1.2rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }

        .status-badge { padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; }
        .status-Pending { background: #fef3c7; color: #d97706; }
        .status-Active { background: #dcfce7; color: #16a34a; }
        .status-Rejected { background: #fee2e2; color: #dc2626; }

        .btn-delete { color: #f43f5e; background: #fff1f2; border: none; padding: 8px; border-radius: 8px; cursor: pointer; transition: 0.3s; }
        .btn-delete:hover { background: #ffe4e6; }

        /* Modal styling */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
        .modal-overlay.open { display: flex; }
        .modal { background: white; width: 600px; border-radius: 28px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }
        .modal-header { padding: 1.5rem 2.5rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #f8fafc; }
        .modal-body { padding: 2.5rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 800; font-size: 0.85rem; color: var(--gray-700); text-transform: uppercase; }
        input, select, textarea { width: 100%; padding: 0.9rem; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 1rem; font-family: inherit; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800;"><i class="fas fa-box-open" style="color: var(--primary);"></i> My Marketplace Listings</div>
            <div style="font-size: 0.85rem; color: #64748b;">Manage your crops, crafts, and professional services.</div>
        </header>

        <div class="content-padding">
            <div class="page-header">
                <div>
                    <h1 style="font-size: 2.2rem; font-weight: 800;">My Products</h1>
                    <p style="color: #64748b;">Keep track of your active sales and new listings.</p>
                </div>
                <div style="display: flex; gap: 12px;">
                    <a href="<?= base_url('user/marketplace') ?>" class="btn-add" style="background: white; color: var(--dark); border: 1px solid var(--gray-200);">
                        <i class="fas fa-store"></i> Go to Village Bazaar
                    </a>
                    <button class="btn-add" onclick="openModal()">
                        <i class="fas fa-plus-circle"></i> Create New Listing
                    </button>
                </div>
            </div>

            <div class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>Product / Service</th>
                            <th>Category</th>
                            <th>Price Details</th>
                            <th>Status</th>
                            <th>Listed On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($products)): ?>
                            <tr><td colspan="6" style="text-align:center; padding: 3rem; color: #64748b;">You haven't listed any products yet.</td></tr>
                        <?php endif; ?>
                        <?php foreach($products as $p): ?>
                        <tr>
                            <td>
                                <div style="font-weight: 800; color: var(--dark);"><?= esc($p['title']) ?></div>
                                <div style="font-size: 0.75rem; color: #94a3b8;"><?= substr(esc($p['description']), 0, 50) ?>...</div>
                                <?php if($p['status'] == 'Rejected' && !empty($p['admin_remarks'])): ?>
                                    <div style="background: #fff1f2; color: #991b1b; padding: 6px 10px; border-radius: 8px; font-size: 0.75rem; margin-top: 8px; border-left: 3px solid #ef4444;">
                                        <i class="fas fa-comment-dots"></i> <strong>Reason:</strong> <?= esc($p['admin_remarks']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><span style="font-weight: 700; color: #64748b;"><?= $p['category'] ?></span></td>
                            <td>
                                <div style="font-weight: 800; color: var(--dark);">₹<?= number_format($p['price'], 2) ?></div>
                                <div style="font-size: 0.75rem; color: #94a3b8;">per <?= $p['unit'] ?></div>
                            </td>
                            <td><span class="status-badge status-<?= $p['status'] ?>"><?= $p['status'] ?></span></td>
                            <td style="font-size: 0.85rem; color: #64748b;"><?= date('d M, Y', strtotime($p['created_at'])) ?></td>
                            <td>
                                <button onclick="confirmDelete(<?= $p['id'] ?>)" class="btn-delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- New Product Modal -->
    <div class="modal-overlay" id="productModal">
        <div class="modal house-shadow">
            <div class="modal-header">
                <h2 style="font-weight: 800;">List Your Item / Service</h2>
                <button style="border:none; background:none; font-size: 1.5rem; cursor:pointer;" onclick="closeModal()">&times;</button>
            </div>
            <form action="<?= base_url('user/marketplace/save') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Listing Title *</label>
                        <input type="text" name="title" placeholder="e.g. Fresh Basmati Rice" required>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label>Category *</label>
                            <select name="category" required>
                                <option value="Crops">Crops & Grains</option>
                                <option value="Vegetables & Fruits">Vegetables & Fruits</option>
                                <option value="Dairy & Poultry">Dairy & Poultry</option>
                                <option value="Processed Food">Processed Food (Honey, Pickles, etc.)</option>
                                <option value="Handicrafts">Handicrafts</option>
                                <option value="Services">Professional Service</option>
                                <option value="Livestock">Livestock</option>
                                <option value="Tools & Equipment">Tools & Machinery</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Contact Phone *</label>
                            <input type="text" name="contact_phone" value="<?= session()->get('user_phone') ?>" required>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label>Price (INR) *</label>
                            <input type="number" name="price" placeholder="500" required>
                        </div>
                        <div class="form-group">
                            <label>Unit (kg, piece, day, etc.) *</label>
                            <input type="text" name="unit" placeholder="kg" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description (Quality, features, etc.) *</label>
                        <textarea name="description" rows="3" placeholder="Tell buyers more about what you are offering..." required></textarea>
                    </div>
                    <button type="submit" class="btn-add" style="width: 100%; justify-content: center; height: 55px; background: var(--primary);">Submit for Approval</button>
                    <p style="text-align: center; font-size: 0.75rem; color: #94a3b8; margin-top: 1rem;">Note: All listings are moderated by the Panchayat Admin for safety.</p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openModal() { document.getElementById('productModal').classList.add('open'); }
        function closeModal() { document.getElementById('productModal').classList.remove('open'); }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Remove Listing?',
                text: "This item will be removed from the marketplace permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f43f5e',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Remove it!',
                background: '#fff',
                borderRadius: '20px'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url('user/marketplace/delete') ?>/" + id;
                }
            })
        }

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Great!', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#10b981' });
        <?php endif; ?>
    </script>
</body>
</html>
