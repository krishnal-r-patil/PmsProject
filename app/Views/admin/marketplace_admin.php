<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderate Marketplace - Admin</title>
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

        .page-header { margin-bottom: 2.5rem; }
        
        .table-card { background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #e2e8f0; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 1.2rem; background: #f8fafc; color: #64748b; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 1.2rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }

        .status-badge { padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; }
        .status-Pending { background: #fef3c7; color: #d97706; }
        .status-Active { background: #dcfce7; color: #16a34a; }
        .status-Rejected { background: #fee2e2; color: #dc2626; }

        .action-btns { display: flex; gap: 8px; }
        .btn-approve { background: #dcfce7; color: #166534; border: none; padding: 8px 12px; border-radius: 8px; font-weight: 700; cursor: pointer; text-decoration: none; font-size: 0.8rem; }
        .btn-reject { background: #fee2e2; color: #dc2626; border: none; padding: 8px 12px; border-radius: 8px; font-weight: 700; cursor: pointer; text-decoration: none; font-size: 0.8rem; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800;"><i class="fas fa-tasks" style="color: var(--primary);"></i> Marketplace Moderation</div>
            <div style="font-size: 0.85rem; color: #64748b;">Approving and managing village listings.</div>
        </header>

        <div class="content-padding">
            <div class="page-header" style="display: flex; justify-content: space-between; align-items: end;">
                <div>
                    <h1 style="font-size: 2.2rem; font-weight: 800;">Marketplace Moderation</h1>
                    <p style="color: #64748b;">Review, approve, or post official village listings.</p>
                </div>
                <button class="btn-approve" style="background: var(--dark); color: white; padding: 0.8rem 1.5rem; display: flex; align-items: center; gap: 8px; font-size: 0.95rem;" onclick="openModal()">
                    <i class="fas fa-plus-circle"></i> Create Official Listing
                </button>
            </div>

            <div class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>Seller / Product</th>
                            <th>Category</th>
                            <th>Pricing</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $p): ?>
                        <tr>
                            <td>
                                <div style="font-weight: 800; color: var(--dark);"><?= esc($p['title']) ?></div>
                                <div style="font-size: 0.75rem; color: #94a3b8;">Seller: <?= esc($p['seller_name']) ?> (<?= $p['contact_phone'] ?>)</div>
                                <?php if($p['status'] == 'Rejected' && !empty($p['admin_remarks'])): ?>
                                    <div style="font-size: 0.7rem; color: #ef4444; margin-top: 5px; font-weight: 600;">
                                        <i class="fas fa-comment"></i> Reason: <?= esc($p['admin_remarks']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><span style="font-weight: 700; color: #64748b;"><?= $p['category'] ?></span></td>
                            <td>
                                <div style="font-weight: 800; color: var(--dark);">₹<?= number_format($p['price'], 2) ?></div>
                                <div style="font-size: 0.75rem; color: #94a3b8;">per <?= $p['unit'] ?></div>
                            </td>
                            <td><span class="status-badge status-<?= $p['status'] ?>"><?= $p['status'] ?></span></td>
                            <td>
                                <div class="action-btns">
                                    <?php if($p['status'] == 'Pending'): ?>
                                        <a href="<?= base_url('admin/marketplace/approve/'.$p['id']) ?>" class="btn-approve"><i class="fas fa-check"></i> Approve</a>
                                        <button onclick="rejectWithReason(<?= $p['id'] ?>)" class="btn-reject" style="border:none;"><i class="fas fa-times"></i> Reject</button>
                                    <?php endif; ?>
                                    <?php if($p['status'] == 'Active'): ?>
                                        <button onclick="rejectWithReason(<?= $p['id'] ?>)" class="btn-reject" style="border:none;"><i class="fas fa-ban"></i> Archive</button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- New Product Modal -->
    <div class="modal-overlay" id="productModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        <div class="modal" style="background: white; width: 600px; border-radius: 28px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
            <div class="modal-header" style="padding: 1.5rem 2.5rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
                <h2 style="font-weight: 800;">Create Official Listing</h2>
                <button style="border:none; background:none; font-size: 1.5rem; cursor:pointer;" onclick="closeModal()">&times;</button>
            </div>
            <form action="<?= base_url('admin/marketplace/save') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body" style="padding: 2.5rem;">
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 800; font-size: 0.85rem; color: var(--gray-700); text-transform: uppercase;">Listing Title *</label>
                        <input type="text" name="title" placeholder="e.g. Village Fair Stalls" required style="width: 100%; padding: 0.9rem; border: 1px solid #e2e8f0; border-radius: 12px;">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 800; font-size: 0.85rem; color: var(--gray-700); text-transform: uppercase;">Category *</label>
                            <select name="category" required style="width: 100%; padding: 0.9rem; border: 1px solid #e2e8f0; border-radius: 12px;">
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
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 800; font-size: 0.85rem; color: var(--gray-700); text-transform: uppercase;">Contact Phone *</label>
                            <input type="text" name="contact_phone" placeholder="Contact number" required style="width: 100%; padding: 0.9rem; border: 1px solid #e2e8f0; border-radius: 12px;">
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 800; font-size: 0.85rem; color: var(--gray-700); text-transform: uppercase;">Price (INR) *</label>
                            <input type="number" name="price" placeholder="0" required style="width: 100%; padding: 0.9rem; border: 1px solid #e2e8f0; border-radius: 12px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 800; font-size: 0.85rem; color: var(--gray-700); text-transform: uppercase;">Unit *</label>
                            <input type="text" name="unit" placeholder="piece / event" required style="width: 100%; padding: 0.9rem; border: 1px solid #e2e8f0; border-radius: 12px;">
                        </div>
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 800; font-size: 0.85rem; color: var(--gray-700); text-transform: uppercase;">Description *</label>
                        <textarea name="description" rows="3" placeholder="Description of the product or service..." required style="width: 100%; padding: 0.9rem; border: 1px solid #e2e8f0; border-radius: 12px; font-family: inherit; resize: none;"></textarea>
                    </div>
                    <button type="submit" style="width: 100%; justify-content: center; height: 55px; background: var(--dark); color: white; border: none; border-radius: 12px; font-weight: 700; cursor: pointer;">Publish Official Listing</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openModal() { document.getElementById('productModal').style.display = 'flex'; }
        function closeModal() { document.getElementById('productModal').style.display = 'none'; }

        async function rejectWithReason(id) {
            const { value: reason } = await Swal.fire({
                title: 'Rejection/Archive Reason',
                input: 'textarea',
                inputLabel: 'Why are you rejecting or archiving this listing?',
                inputPlaceholder: 'Type your reason here...',
                inputAttributes: {
                    'aria-label': 'Type your reason here'
                },
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Submit Rejection',
                background: '#fff',
                borderRadius: '20px'
            })

            if (reason) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "<?= base_url('admin/marketplace/reject') ?>/" + id;
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = "<?= csrf_token() ?>";
                csrfInput.value = "<?= csrf_hash() ?>";
                form.appendChild(csrfInput);

                const reasonInput = document.createElement('input');
                reasonInput.type = 'hidden';
                reasonInput.name = 'reason';
                reasonInput.value = reason;
                form.appendChild(reasonInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Great!', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#10b981' });
        <?php endif; ?>
    </script>
</body>
</html>
