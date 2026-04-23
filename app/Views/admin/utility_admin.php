<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utility Operations Desk - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #3b82f6; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; --bg: #f8fafc; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--bg); display: flex; }
        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        header { background: white; padding: 1.2rem 2.5rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 90; }
        .content-padding { padding: 3rem; }

        .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2.5rem; }
        .stat-card { background: white; padding: 1.5rem; border-radius: 20px; border: 1px solid var(--gray-200); display: flex; align-items: center; gap: 15px; }

        .request-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 2rem; }
        .req-card { background: white; border-radius: 28px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.01); transition: 0.3s; position: relative; }
        .req-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05); border-color: var(--primary); }
        
        .card-header { padding: 1.5rem; display: flex; justify-content: space-between; align-items: start; background: #f8fafc; border-bottom: 1px solid #f1f5f9; }
        .service-pill { padding: 6px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; background: #eff6ff; color: #2563eb; }
        
        .card-body { padding: 1.5rem; }
        .citizen-tag { display: flex; align-items: center; gap: 10px; margin-bottom: 1rem; }
        .citizen-avatar { width: 40px; height: 40px; background: #e2e8f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #64748b; }
        
        .workflow-steps { display: flex; justify-content: space-between; position: relative; margin: 2rem 0; padding: 0 10px; }
        .workflow-steps::before { content: ''; position: absolute; top: 12px; left: 0; right: 0; height: 2px; background: #f1f5f9; z-index: 1; }
        .step { width: 25px; height: 25px; border-radius: 50%; background: #f1f5f9; z-index: 2; display: flex; align-items: center; justify-content: center; font-size: 0.6rem; color: #94a3b8; border: 2px solid white; box-shadow: 0 0 0 2px #f1f5f9; }
        .step.active { background: var(--primary); color: white; box-shadow: 0 0 0 2px var(--primary); }
        .step.done { background: #10b981; color: white; box-shadow: 0 0 0 2px #10b981; }
        
        .op-footer { padding: 1.5rem; background: #f8fafc; border-top: 1px solid #f1f5f9; display: flex; gap: 10px; }
        .btn-op { flex: 1; padding: 0.8rem; border: none; border-radius: 12px; font-weight: 800; font-size: 0.8rem; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 6px; }
        .btn-main { background: var(--dark); color: white; }
        .btn-main:hover { background: var(--primary); }
        .btn-danger { background: #fff1f2; color: #e11d48; }

        .info-bit { font-size: 0.85rem; color: #64748b; margin-top: 5px; display: flex; align-items: center; gap: 6px; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800;"><i class="fas fa-bolt" style="color: #f59e0b;"></i> Utility Operations Hub</div>
            <div class="header-actions" style="display: flex; gap: 15px;">
                <div style="background: #ecfdf5; color: #059669; padding: 6px 15px; border-radius: 50px; font-size: 0.8rem; font-weight: 800;">
                    <i class="fas fa-signal"></i> System Online
                </div>
            </div>
        </header>

        <div class="content-padding">
            <div style="display: flex; justify-content: space-between; align-items: end; margin-bottom: 2.5rem;">
                <div>
                    <h1 style="font-size: 2.4rem; font-weight: 800; letter-spacing: -1px;">Utility Moderation</h1>
                    <p style="color: #64748b;">Process and monitor infrastructure connection requests.</p>
                </div>
                <div style="font-weight: 800; color: #94a3b8; font-size: 0.9rem;">TOTAL REQUESTS: <?= count($requests) ?></div>
            </div>

            <div class="request-grid">
                <?php foreach($requests as $r): ?>
                <div class="req-card">
                    <div class="card-header">
                        <div>
                            <span class="service-pill" style="
                                <?php if($r['service_type'] == 'Electricity') echo 'background: #fffbeb; color: #d97706;'; ?>
                                <?php if($r['service_type'] == 'Water') echo 'background: #eff6ff; color: #2563eb;'; ?>
                                <?php if($r['service_type'] == 'Gas') echo 'background: #fff1f2; color: #e11d48;'; ?>
                            ">
                                <i class="fas 
                                    <?php if($r['service_type'] == 'Electricity') echo 'fa-bolt'; ?>
                                    <?php if($r['service_type'] == 'Water') echo 'fa-faucet'; ?>
                                    <?php if($r['service_type'] == 'Gas') echo 'fa-fire'; ?>
                                    <?php if($r['service_type'] == 'Internet') echo 'fa-wifi'; ?>
                                "></i> <?= $r['service_type'] ?>
                            </span>
                            <div style="margin-top: 10px; font-weight: 800; color: var(--dark); font-size: 1.1rem;"><?= $r['category'] ?> Connection</div>
                        </div>
                        <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 700;">#UTIL-<?= str_pad($r['id'], 4, '0', STR_PAD_LEFT) ?></div>
                    </div>
                    
                    <div class="card-body">
                        <div class="citizen-tag">
                            <div class="citizen-avatar"><i class="fas fa-user"></i></div>
                            <div>
                                <div style="font-weight: 800; color: var(--dark);"><?= esc($r['citizen_name']) ?></div>
                                <div style="font-size: 0.75rem; color: #94a3b8;">Prop ID: <?= $r['property_id'] ?></div>
                            </div>
                        </div>

                        <div class="workflow-steps">
                            <div class="step <?= in_array($r['status'], ['Pending','Verified','Installation','Active']) ? 'done' : '' ?>"><i class="fas fa-check"></i></div>
                            <div class="step <?= in_array($r['status'], ['Verified','Installation','Active']) ? 'done' : ($r['status'] == 'Pending' ? 'active' : '') ?>">2</div>
                            <div class="step <?= in_array($r['status'], ['Installation','Active']) ? 'done' : ($r['status'] == 'Verified' ? 'active' : '') ?>">3</div>
                            <div class="step <?= $r['status'] == 'Active' ? 'done' : ($r['status'] == 'Installation' ? 'active' : '') ?>">4</div>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.65rem; color: #94a3b8; font-weight: 800; margin-top: -15px;">
                            <span>APPLIED</span>
                            <span>VERIFIED</span>
                            <span>INSTALL</span>
                            <span>ACTIVE</span>
                        </div>

                        <div style="margin-top: 1.5rem; background: #f8fafc; padding: 1.2rem; border-radius: 15px; border: 1px solid #f1f5f9;">
                            <div class="info-bit" style="font-weight: 700; color: var(--dark); margin-bottom: 8px;"><i class="fas fa-id-card"></i> Profile Dossier</div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                                <div class="info-bit"><i class="fas fa-user-friends"></i> S/o: <?= esc($r['father_name']) ?></div>
                                <div class="info-bit"><i class="fas fa-fingerprint"></i> Aadhar: <?= esc($r['aadhar_no']) ?></div>
                                <div class="info-bit"><i class="fas fa-phone"></i> <?= esc($r['phone']) ?></div>
                                <div class="info-bit"><i class="fas fa-briefcase"></i> <?= esc($r['occupation']) ?></div>
                            </div>
                            <hr style="margin: 10px 0; opacity: 0.1;">
                            <div class="info-bit"><i class="fas fa-map-marker-alt"></i> <?= esc($r['address']) ?></div>
                            <div class="info-bit"><i class="fas fa-calendar-alt"></i> Applied: <?= date('d M, Y', strtotime($r['created_at'])) ?></div>
                        </div>
                    </div>

                    <div class="op-footer">
                        <?php if($r['status'] == 'Pending'): ?>
                            <button onclick="updateStatus(<?= $r['id'] ?>, 'Verified')" class="btn-op btn-main"><i class="fas fa-user-check"></i> Verify</button>
                            <button onclick="updateStatus(<?= $r['id'] ?>, 'Rejected')" class="btn-op btn-danger"><i class="fas fa-times"></i> Reject</button>
                        <?php elseif($r['status'] == 'Verified'): ?>
                            <button onclick="updateStatus(<?= $r['id'] ?>, 'Installation')" class="btn-op btn-main" style="background: #8b5cf6;"><i class="fas fa-tools"></i> Dispatch Team</button>
                        <?php elseif($r['status'] == 'Installation'): ?>
                            <button onclick="updateStatus(<?= $r['id'] ?>, 'Active')" class="btn-op btn-main" style="background: #10b981;"><i class="fas fa-power-off"></i> Activate Service</button>
                        <?php else: ?>
                            <div style="width: 100%; text-align: center; font-weight: 800; color: #10b981; font-size: 0.8rem;"><i class="fas fa-check-double"></i> SERVICE FULLY OPERATIONAL</div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        async function updateStatus(id, status) {
            let label = "Approve and move to next stage?";
            if(status === 'Rejected') label = "Provide reason for rejection:";
            if(status === 'Installation') label = "Add installation team details:";
            if(status === 'Active') label = "Final activation notes (Consumer ID, etc.):";

            const { value: remarks } = await Swal.fire({
                title: 'Update Pipeline: ' + status,
                input: 'textarea',
                inputLabel: label,
                inputPlaceholder: 'Enter official remarks here...',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                background: '#fff',
                borderRadius: '30px',
                confirmButtonText: 'Confirm Update'
            });

            if (remarks !== undefined) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "<?= base_url('admin/utilities/update') ?>/" + id + "/" + status;
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = "<?= csrf_token() ?>";
                csrf.value = "<?= csrf_hash() ?>";
                form.appendChild(csrf);

                const remarkInput = document.createElement('input');
                remarkInput.type = 'hidden';
                remarkInput.name = 'remarks';
                remarkInput.value = remarks;
                form.appendChild(remarkInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Pipeline Updated!', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#3b82f6' });
        <?php endif; ?>
    </script>
</body>
</html>
