<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welfare Schemes - Gram Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #2563eb;
            --dark: #0f172a;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-700: #334155;
            --indigo: #6366f1;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; display: flex; align-items: center; gap: 10px; color: white; text-decoration: none; }
        .sidebar-brand span { color: var(--primary); }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 0.8rem 1rem; color: #94a3b8; text-decoration: none; border-radius: 8px; transition: all 0.3s; margin-bottom: 0.5rem; }
        .nav-link:hover, .nav-link.active { background-color: #334155; color: white; }
        .nav-link.active { background-color: var(--primary); }

        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; padding: 2rem; }
        
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .header-actions h1 { font-size: 1.8rem; color: var(--dark); }
        
        .btn-add { background: var(--primary); color: white; padding: 0.6rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 8px; }

        .scheme-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 1.5rem; }
        .scheme-card { background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.3s; }
        .scheme-card:hover { transform: translateY(-5px); }

        .scheme-tag { background: #eef2ff; color: var(--indigo); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; padding: 4px 12px; border-radius: 20px; margin-bottom: 1rem; display: inline-block; }
        .scheme-title { font-size: 1.4rem; font-weight: 700; color: var(--dark); margin-bottom: 1rem; }
        .scheme-info { margin-bottom: 1.5rem; }
        .info-label { font-size: 0.8rem; font-weight: 700; color: var(--gray-700); margin-bottom: 4px; display: block; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-text { font-size: 0.95rem; color: var(--dark); margin-bottom: 12px; display: block; line-height: 1.5; }

        .actions { border-top: 1px solid var(--gray-200); padding-top: 1.5rem; display: flex; gap: 1rem; }
        .btn-link { text-decoration: none; font-weight: 600; font-size: 0.9rem; color: var(--primary); }
    </style>
</head>
<body>

    <div class="sidebar">
        <?= view('admin/partials/sidebar') ?>
    </div>

    <div class="main-content">
        <div class="header-actions">
            <div>
                <h1>Government Welfare Schemes</h1>
                <p style="color: var(--gray-700);">Managing central and state schemes for beneficiaries</p>
            </div>
            <button class="btn-add" onclick="openSchemeModal()">
                <i class="fas fa-plus"></i> Add New Scheme
            </button>
        </div>

        <div class="scheme-grid">
            <?php foreach($schemes as $s): ?>
            <div class="scheme-card">
                <span class="scheme-tag">Public Welfare</span>
                <div class="scheme-title"><?= esc($s['title']) ?></div>
                
                <div class="scheme-info">
                    <span class="info-label">Eligibility Criteria</span>
                    <span class="info-text"><?= esc($s['eligibility_criteria']) ?></span>
                    
                    <span class="info-label">Current Benefits</span>
                    <span class="info-text"><?= esc($s['benefit_details']) ?></span>

                    <span class="info-label">Benefit Amount</span>
                    <span class="info-text" style="color: #059669; font-weight: 700;">₹<?= number_format($s['benefit_amount'], 2) ?></span>
                </div>

                <div class="actions">
                    <button class="btn-link" style="border:none; background:none; cursor:pointer;" onclick="editScheme(<?= htmlspecialchars(json_encode($s)) ?>)">Edit Details</button>
                    <a href="<?= base_url('admin/scheme-applications') ?>" class="btn-link">View Applications</a>
                    <a href="javascript:void(0)" onclick="confirmDelete('<?= base_url('admin/schemes/delete/'.$s['id']) ?>')" class="btn-link" style="color: #ef4444; margin-left: auto;">Delete</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal -->
    <div id="schemeDetailModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; padding: 2rem;">
        <div style="background: white; width: 100%; max-width: 600px; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);">
            <div style="padding: 1.5rem 2rem; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
                <h2 id="modalTitle" style="font-size: 1.25rem; font-weight: 800;">Define Welfare Scheme</h2>
                <button onclick="closeSchemeModal()" style="border:none; background:none; font-size: 1.5rem; cursor:pointer;">&times;</button>
            </div>
            <form action="<?= base_url('admin/schemes/save') ?>" method="POST" style="padding: 2rem;">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="schemeId">
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; font-size: 0.85rem; color: #4b5563;">Scheme Title *</label>
                    <input type="text" name="title" id="schemeTitle" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 10px;">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; font-size: 0.85rem; color: #4b5563;">Benefit Amount (₹) *</label>
                        <input type="number" step="0.01" name="benefit_amount" id="schemeAmount" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 10px;">
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; font-size: 0.85rem; color: #4b5563;">Status</label>
                        <select name="status" id="schemeStatus" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 10px;">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; font-size: 0.85rem; color: #4b5563;">Eligibility Criteria</label>
                    <textarea name="eligibility_criteria" id="schemeEligibility" rows="2" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 10px;"></textarea>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; font-size: 0.85rem; color: #4b5563;">Benefit Details</label>
                    <textarea name="benefit_details" id="schemeBenefits" rows="2" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 10px;"></textarea>
                </div>
                <button type="submit" style="width: 100%; padding: 1rem; background: #0f172a; color: white; border: none; border-radius: 12px; font-weight: 800; cursor: pointer;">Save Scheme</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openSchemeModal() {
            document.getElementById('modalTitle').innerText = "Register New Scheme";
            document.getElementById('schemeId').value = "";
            document.getElementById('schemeTitle').value = "";
            document.getElementById('schemeAmount').value = "0";
            document.getElementById('schemeEligibility').value = "";
            document.getElementById('schemeBenefits').value = "";
            document.getElementById('schemeDetailModal').style.display = 'flex';
        }

        function editScheme(s) {
            document.getElementById('modalTitle').innerText = "Edit Scheme Record";
            document.getElementById('schemeId').value = s.id;
            document.getElementById('schemeTitle').value = s.title;
            document.getElementById('schemeAmount').value = s.benefit_amount;
            document.getElementById('schemeStatus').value = s.status;
            document.getElementById('schemeEligibility').value = s.eligibility_criteria;
            document.getElementById('schemeBenefits').value = s.benefit_details;
            document.getElementById('schemeDetailModal').style.display = 'flex';
        }

        function closeSchemeModal() { document.getElementById('schemeDetailModal').style.display = 'none'; }

        function confirmDelete(url) {
            Swal.fire({
                title: 'Decommission Scheme?',
                text: "This will remove the scheme from citizen portals, but won't affect past applicants.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Yes, Decommission'
            }).then((result) => {
                if (result.isConfirmed) { window.location.href = url; }
            });
        }

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Ledger Updated', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#2563eb' });
        <?php endif; ?>
    </script>
</body>
</html>

