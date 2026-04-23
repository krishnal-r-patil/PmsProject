<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utility Connections - E-Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #3b82f6; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }
        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 90; }
        .content-padding { padding: 2.5rem; }

        .service-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 3rem; }
        .util-card { background: white; padding: 2rem; border-radius: 20px; text-align: center; border: 1px solid #e2e8f0; transition: 0.3s; cursor: pointer; }
        .util-card:hover { transform: translateY(-5px); border-color: var(--primary); box-shadow: 0 10px 20px rgba(59, 130, 246, 0.1); }
        .util-icon { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1.2rem; }

        .table-card { background: white; border-radius: 24px; padding: 1.5rem; border: 1px solid #e2e8f0; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 1.2rem; background: #f8fafc; color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; border-radius: 12px; }
        td { padding: 1.2rem; border-bottom: 1px solid #f1f5f9; }

        .status-badge { padding: 6px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }
        .status-Pending { background: #fef3c7; color: #d97706; }
        .status-Active { background: #dcfce7; color: #16a34a; }
        .status-Rejected { background: #fee2e2; color: #dc2626; }
        .status-Installation { background: #eff6ff; color: #2563eb; }

        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px); }
        .modal { background: white; width: 550px; border-radius: 30px; overflow: hidden; animation: slideUp 0.3s ease; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-size: 0.8rem; font-weight: 800; color: var(--gray-700); text-transform: uppercase; }
        input, select, textarea { width: 100%; padding: 0.9rem; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; outline: none; transition: 0.3s; }
        input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        .btn-submit { width: 100%; padding: 1rem; border: none; background: var(--dark); color: white; border-radius: 15px; font-weight: 700; cursor: pointer; transition: 0.3s; }
        .btn-submit:hover { background: var(--primary); }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800;"><i class="fas fa-bolt" style="color: #f59e0b;"></i> Utility Connections (Authenticated Hub)</div>
            <div style="display: flex; gap: 12px; align-items: center;">
                <div style="background: #ecfdf5; color: #059669; padding: 6px 15px; border-radius: 50px; font-size: 0.75rem; font-weight: 800;">
                    <i class="fas fa-signal"></i> Panchayat System Online
                </div>
                <div style="font-size: 0.85rem; color: #64748b;">Logged in as: <b><?= session()->get('user_name') ?></b></div>
            </div>
        </header>

        <div class="content-padding">
            <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">New Connection Services</h2>
            <p style="color: #64748b; margin-bottom: 2.5rem;">Select a service below to start your digital application.</p>

            <div class="service-grid">
                <div class="util-card" onclick="openApplyModal('Electricity')">
                    <div class="util-icon" style="background: #fffbeb; color: #d97706;"><i class="fas fa-bolt"></i></div>
                    <div style="font-weight: 800; color: var(--dark);">Electricity</div>
                </div>
                <div class="util-card" onclick="openApplyModal('Water')">
                    <div class="util-icon" style="background: #eff6ff; color: #2563eb;"><i class="fas fa-faucet"></i></div>
                    <div style="font-weight: 800; color: var(--dark);">Water Supply</div>
                </div>
                <div class="util-card" onclick="openApplyModal('Gas')">
                    <div class="util-icon" style="background: #fff1f2; color: #e11d48;"><i class="fas fa-fire"></i></div>
                    <div style="font-weight: 800; color: var(--dark);">Gas Pipeline</div>
                </div>
                <div class="util-card" onclick="openApplyModal('Internet')">
                    <div class="util-icon" style="background: #f5f3ff; color: #7c3aed;"><i class="fas fa-wifi"></i></div>
                    <div style="font-weight: 800; color: var(--dark);">Broadband</div>
                </div>
                <div class="util-card" onclick="openApplyModal('Sewerage')">
                    <div class="util-icon" style="background: #ecfdf5; color: #059669;"><i class="fas fa-soap"></i></div>
                    <div style="font-weight: 800; color: var(--dark);">Sewerage</div>
                </div>
                <div class="util-card" onclick="openApplyModal('Phone')">
                    <div class="util-icon" style="background: #f8fafc; color: #475569;"><i class="fas fa-phone"></i></div>
                    <div style="font-weight: 800; color: var(--dark);">Landline</div>
                </div>
            </div>

            <h3 style="font-weight: 800; margin-bottom: 1.5rem;">My Application History</h3>
            <div class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>Service Type</th>
                            <th>Category</th>
                            <th>Property / Service ID</th>
                            <th>Applied On</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($requests)): ?>
                            <tr><td colspan="5" style="text-align:center; padding: 3rem; color: #94a3b8;">No applications found. Start a new connection above.</td></tr>
                        <?php endif; ?>
                        <?php foreach($requests as $r): ?>
                        <tr>
                            <td>
                                <div style="font-weight: 800; color: var(--dark);"><?= $r['service_type'] ?></div>
                                <div style="font-size: 0.75rem; color: #94a3b8;"><?= esc($r['address']) ?></div>
                            </td>
                            <td><span style="font-weight: 600; color: #64748b;"><?= $r['category'] ?></span></td>
                            <td><code style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px; font-weight: 700;"><?= $r['property_id'] ?></code></td>
                            <td style="font-size: 0.85rem; color: #64748b;"><?= date('d M, Y', strtotime($r['created_at'])) ?></td>
                            <td><span class="status-badge status-<?= $r['status'] ?>"><?= $r['status'] ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Application Modal -->
    <div class="modal-overlay" id="applyModal">
        <div class="modal">
            <div style="padding: 1.5rem 2rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <h2 id="modalTitle" style="font-weight: 800; font-size: 1.2rem;">New Connection</h2>
                <button onclick="closeModal()" style="border:none; background:none; font-size: 1.5rem; cursor:pointer;">&times;</button>
            </div>
            <form action="<?= base_url('user/utilities/save') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="service_type" id="hiddenService">
                <div style="padding: 2rem; max-height: 70vh; overflow-y: auto;">
                    <div style="background: #f8fafc; padding: 1.5rem; border-radius: 20px; border: 1px solid #e2e8f0; margin-bottom: 2rem;">
                        <h4 style="font-size: 0.7rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.2rem;">Applicant Identity (Verified from Profile)</h4>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="applicant_name" value="<?= session()->get('user_name') ?>" readonly style="background: white;">
                            </div>
                            <div class="form-group">
                                <label>Father/Husband Name</label>
                                <input type="text" name="father_name" value="<?= $citizen['father_name'] ?? '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phone" value="<?= $citizen['phone'] ?? '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="email" value="<?= session()->get('user_email') ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Aadhar Number</label>
                                <input type="text" name="aadhar_no" value="<?= $citizen['aadhar_no'] ?? '' ?>" readonly style="background: white;">
                            </div>
                            <div class="form-group">
                                <label>Occupation</label>
                                <input type="text" name="occupation" value="<?= $citizen['occupation'] ?? '' ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Application Category *</label>
                        <select name="category" required>
                            <option value="Domestic">Domestic (House)</option>
                            <option value="Commercial">Commercial (Shop/Office)</option>
                            <option value="Industrial">Industrial (Factory)</option>
                            <option value="Irrigation">Irrigation (Farm)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pariwar / Family ID *</label>
                        <input type="text" name="pariwar_id" value="<?= $citizen['family_id'] ?? '' ?>" readonly style="background: #f8fafc;">
                    </div>
                    <div class="form-group">
                        <label>Property Tax ID / House No*</label>
                        <input type="text" name="property_id" placeholder="e.g. PROP-9901 or H-12" value="<?= $citizen['house_no'] ?? '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Installation Address *</label>
                        <textarea name="address" rows="2" required><?= ($citizen['house_no'] ?? '') . ', Ward ' . ($citizen['ward_no'] ?? '') . ', ' . ($citizen['village'] ?? '') ?></textarea>
                    </div>
                    <p style="font-size: 0.75rem; color: #94a3b8; margin-bottom: 1.5rem;"><i class="fas fa-info-circle"></i> Note: A one-time survey fee may be applicable upon field verification.</p>
                    <button type="submit" class="btn-submit">Submit Official Application</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openApplyModal(service) {
            document.getElementById('modalTitle').innerText = "Apply for " + service + " Connection";
            document.getElementById('hiddenService').value = service;
            document.getElementById('applyModal').style.display = 'flex';
        }
        function closeModal() {
            document.getElementById('applyModal').style.display = 'none';
        }
        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Submitted!', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#3b82f6' });
        <?php endif; ?>
    </script>
</body>
</html>
