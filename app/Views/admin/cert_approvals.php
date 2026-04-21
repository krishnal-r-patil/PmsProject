<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Certificate Approvals - Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 90; }
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-avatar { width: 35px; height: 35px; background: #eff6ff; color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; }

        .content-body { padding: 2rem; }
        .page-header { margin-bottom: 2rem; }
        .page-header h1 { font-size: 1.8rem; color: var(--dark); }

        .card { background: white; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 1.25rem 1.5rem; background: #f8fafc; color: var(--gray-700); font-size: 0.85rem; border-bottom: 1px solid var(--gray-200); }
        td { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--gray-200); font-size: 0.95rem; }

        .badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-approved { background: #dcfce7; color: #166534; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }

        .btn-action { background: var(--primary); color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.3s; font-size: 0.8rem; }
        .btn-action:hover { background: #1d4ed8; }
        .btn-outline { background: white; border: 1px solid var(--gray-200); color: var(--gray-700); padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.3s; font-size: 0.8rem; }
        
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: white; width: 580px; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); max-height: 92vh; display: flex; flex-direction: column; overflow: hidden; position: relative; }
        .modal-header { padding: 1.5rem; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; background: white; z-index: 10; }
        .modal-body { padding: 1.5rem; overflow-y: auto; flex-grow: 1; padding-bottom: 3rem; }
        .modal-footer { padding: 1.25rem 1.5rem; border-top: 1px solid var(--gray-200); display: flex; justify-content: flex-end; gap: 10px; flex-shrink: 0; background: #f8fafc; z-index: 10; }
        .modal form { display: flex; flex-direction: column; height: 100%; overflow: hidden; }

        .review-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; background: #f8fafc; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; }
        .review-item label { display: block; font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 4px; }
        .review-item span { font-weight: 600; color: var(--dark); }

        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--gray-700); font-size: 0.85rem; }
        select, textarea { width: 100%; padding: 0.8rem; border: 1px solid var(--gray-200); border-radius: 10px; font-size: 0.95rem; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 600; color: var(--gray-700); font-size: 0.9rem;">
                <i class="fas fa-certificate" style="color: var(--primary);"></i> E-Certificate Issuance Hub
            </div>
            <div class="user-profile">
                <span style="font-size: 0.85rem; color: #64748b;"><?= session()->get('user_name') ?> (Admin)</span>
                <div class="user-avatar"><?= substr(session()->get('user_name'), 0, 1) ?></div>
            </div>
        </header>

        <div class="content-body">
            <div class="page-header">
                <h1>Certificate Approval Center</h1>
                <p style="color: var(--gray-700);">Review application details and generate official documents.</p>
            </div>

        <!-- Flash messages handled by SweetAlert below -->

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th width="200">Applicant</th>
                        <th>Person/Event Info</th>
                        <th>Applied On</th>
                        <th>Status</th>
                        <th width="180">Action</th>
                        <th width="150">Delivery</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($apps)): ?>
                        <tr><td colspan="5" style="text-align: center; color: #94a3b8; padding: 3rem;">No certificate applications found.</td></tr>
                    <?php else: ?>
                        <?php foreach($apps as $a): 
                            $details = json_decode($a['application_data'], true);
                        ?>
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: var(--dark);"><?= esc($a['user_name']) ?></div>
                                <div style="font-size: 0.75rem; color: #64748b;">Applicant ID: #<?= $a['user_id'] ?></div>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: var(--primary);"><?= esc($a['service_type']) ?></div>
                                <div style="font-size: 0.85rem; margin-top: 4px;">For: <strong><?= esc($details['person_name'] ?? 'N/A') ?></strong></div>
                                <div style="font-size: 0.75rem; color: #64748b; font-style: italic;">"<?= esc($details['purpose'] ?? '') ?>"</div>
                            </td>
                            <td><?= date('d M Y', strtotime($a['applied_at'])) ?></td>
                            <td>
                                <span class="badge badge-<?= strtolower($a['status']) ?>">
                                    <?= $a['status'] ?>
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px; align-items: center;">
                                    <?php if($a['status'] == 'Pending'): ?>
                                        <button class="btn-action" style="padding: 6px 12px; font-size: 0.8rem;" onclick='openReviewModal(<?= json_encode($a) ?>)'>
                                            Review &amp; Approve
                                        </button>
                                    <?php else: ?>
                                        <button class="btn-outline" style="padding: 6px 12px; font-size: 0.8rem;" onclick='openReviewModal(<?= json_encode($a) ?>)'>
                                            View Details
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <?php if($a['status'] == 'Approved' && !empty($a['certificate_id'])): ?>
                                    <div style="font-size: 0.75rem; color: #10b981; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                                        <i class="fas fa-check-circle"></i> Sent to User
                                    </div>
                                    <a href="<?= base_url('admin/register-docs/certificate/'.$a['certificate_id']) ?>" target="_blank" style="font-size: 0.65rem; color: var(--primary); text-decoration: none; font-weight: 600;">[Preview Sent File]</a>
                                <?php elseif($a['status'] == 'Rejected'): ?>
                                    <div style="font-size: 0.75rem; color: #ef4444; font-weight: 700;">
                                        Rejected
                                    </div>
                                <?php else: ?>
                                    <div style="font-size: 0.75rem; color: #64748b; font-style: italic;">
                                        Pending
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Review Modal -->
    <div class="modal-overlay" id="reviewModal">
        <div class="modal">
            <div class="modal-header">
                <h2>Application Review</h2>
                <button style="border:none; background:none; font-size: 1.5rem; cursor:pointer;" onclick="closeModal()">&times;</button>
            </div>
            <form id="approval-form" action="" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <!-- Application Details Grid -->
                    <div id="application-details"></div>

                    <div style="margin-top: 1.5rem; border-top: 1px solid var(--gray-200); padding-top: 1.5rem;">
                        <div class="form-group">
                            <label>Action To Take *</label>
                            <select name="action" required onchange="toggleActionFields(this.value)">
                                <option value="">-- Choose Decision --</option>
                                <option value="Approve" style="color: #10b981; font-weight: 700;">Approve &amp; Send Certificate</option>
                                <option value="Reject" style="color: #ef4444; font-weight: 700;">Reject Application</option>
                            </select>
                        </div>

                        <!-- Approval Message Section -->
                        <div id="approve-fields" style="display: none; background: #f0fdf4; padding: 1.25rem; border-radius: 12px; border: 1px solid #bbf7d0;">
                            <p style="font-size: 0.85rem; color: #166534; font-weight: 600;">
                                <i class="fas fa-magic"></i> Instant Generation Enabled
                            </p>
                            <p style="font-size: 0.75rem; color: #166534; margin-top: 5px;">
                                Approving this will automatically create an official registry record using the citizen's submitted data and deliver the certificate to their vault instantly.
                            </p>
                        </div>

                        <div id="reject-fields" style="display: none;">
                            <div class="form-group">
                                <label>Rejection Reason</label>
                                <textarea name="remarks" placeholder="Explain why the application is being rejected..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="modal-footer-actions">
                    <span style="margin-right: auto; font-size: 0.75rem; color: #64748b; font-style: italic;"><i class="fas fa-paper-plane"></i> Approval delivers the certificate instantly.</span>
                    <button type="button" style="background:none; border:none; cursor:pointer; font-weight:600;" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-action">Confirm Decision</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openReviewModal(app) {
            const data = JSON.parse(app.application_data);
            let html = `<div class="review-grid">
                <div class="review-item"><label>Person Name</label><span>${data.person_name || app.user_name || 'N/A'}</span></div>
                <div class="review-item"><label>Gender</label><span>${data.gender || 'N/A'}</span></div>
                <div class="review-item"><label>Event/Request Date</label><span>${data.date_of_event || app.applied_at || 'N/A'}</span></div>
                <div class="review-item"><label>Place/House</label><span>${data.place_of_event || data.house || 'N/A'}</span></div>
                <div class="review-item"><label>Father</label><span>${data.father_name || data.father || 'N/A'}</span></div>
                <div class="review-item"><label>Mother</label><span>${data.mother_name || 'N/A'}</span></div>
                ${data.profession ? `<div class="review-item"><label>Profession</label><span>${data.profession}</span></div>` : ''}
                ${data.annual_income ? `<div class="review-item"><label>Annual Income</label><span style="color: #166534; font-weight: 800;">₹${data.annual_income}</span></div>` : ''}
                ${data.financial_year ? `<div class="review-item"><label>Fin. Year</label><span>${data.financial_year}</span></div>` : ''}
                ${data.category ? `<div class="review-item"><label>Category</label><span>${data.category}</span></div>` : ''}
                ${data.caste_name ? `<div class="review-item"><label>Caste</label><span>${data.caste_name}</span></div>` : ''}
                ${data.religion ? `<div class="review-item"><label>Religion</label><span>${data.religion}</span></div>` : ''}
                ${data.stay_duration ? `<div class="review-item"><label>Stay Duration</label><span>${data.stay_duration} Years</span></div>` : ''}
                ${data.id_proof_no ? `<div class="review-item"><label>ID Proof / Aadhar</label><span>${data.id_proof_no}</span></div>` : ''}
                ${(!data.profession && !data.category && app.service_type !== 'Income Certificate') ? `<div class="review-item"><label>Weight/Cause</label><span>${data.weight_at_birth || data.cause_of_death || 'N/A'}</span></div>` : ''}
                <div class="review-item" style="grid-column: 1/ -1;"><label>Purpose</label><span>${data.purpose || 'N/A'}</span></div>
            </div>`;
            
            document.getElementById('application-details').innerHTML = html;
            document.getElementById('approval-form').action = "<?= base_url('admin/cert-approvals/process') ?>/" + app.id;
            
            // If already processed, hide action fields
            if (app.status !== 'Pending') {
                document.getElementById('modal-footer-actions').style.display = 'none';
                document.getElementById('approval-form').querySelector('div[style*="margin-top: 1.5rem"]').style.display = 'none';
                document.querySelector('.modal-header h2').innerText = "Application Archive";
            } else {
                document.getElementById('modal-footer-actions').style.display = 'flex';
                document.getElementById('approval-form').querySelector('div[style*="margin-top: 1.5rem"]').style.display = 'block';
                document.querySelector('.modal-header h2').innerText = "Review & Approve Application";
            }
            
            document.getElementById('reviewModal').classList.add('open');
        }

        function closeModal() { document.getElementById('reviewModal').classList.remove('open'); }

        function toggleActionFields(val) {
            document.getElementById('approve-fields').style.display = (val === 'Approve') ? 'block' : 'none';
            document.getElementById('reject-fields').style.display  = (val === 'Reject') ? 'block' : 'none';
            
            // Toggle required
            document.querySelector('[name="remarks"]').required = (val === 'Reject');
        }

        // --- Popups ---
        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?= session()->getFlashdata('success') ?>',
                confirmButtonColor: '#2563eb'
            });
        <?php endif; ?>
    </script>
</body>
</html>
