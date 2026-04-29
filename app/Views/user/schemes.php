<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Government Schemes - E-Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; display: flex; align-items: center; gap: 10px; color: white; text-decoration: none; }
        .sidebar-brand span { color: var(--primary); }
        .nav-menu { list-style: none; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 0.8rem 1rem; color: #94a3b8; text-decoration: none; border-radius: 8px; transition: all 0.3s; margin-bottom: 0.5rem; }
        .nav-link:hover, .nav-link.active { background-color: #334155; color: white; }
        .nav-link.active { background-color: var(--primary); }

        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        
        .content-padding { padding: 0 2rem 2rem; }
        .scheme-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 1.5rem; }
        .scheme-card { background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid var(--gray-200); position: relative; }
        .scheme-title { font-size: 1.25rem; font-weight: 700; color: var(--dark); margin-bottom: 1rem; border-bottom: 1px solid var(--gray-100); padding-bottom: 1rem; }
        
        .benefit-box { background: #ecfdf5; border-radius: 12px; padding: 1rem; margin-top: 1.5rem; border-left: 4px solid #10b981; }
        .btn-apply { display: block; width: 100%; text-align: center; padding: 1rem; background: var(--primary); color: white; text-decoration: none; border: none; border-radius: 10px; font-weight: 600; margin-top: 1.5rem; transition: 0.3s; cursor: pointer; }
        .btn-apply:hover { background: #1d4ed8; filter: brightness(1.1); transform: translateY(-2px); }

        /* Modal Styles */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 1rem; }
        .modal-overlay.open { display: flex; }
        .modal { background: white; width: 750px; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); overflow: hidden; animation: modalSlide 0.3s ease-out; }
        @keyframes modalSlide { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        
        .modal-header { padding: 1.5rem 2rem; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center; background: #f8fafc; }
        .modal-body { padding: 2rem; }
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 700; font-size: 0.85rem; color: var(--gray-700); }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.9rem; border: 1px solid var(--gray-200); border-radius: 10px; font-size: 1rem; transition: 0.3s; }
        .form-group input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 600;"><i class="fas fa-award" style="color: var(--primary);"></i> Welfare Schemes Portal</div>
            <div class="user-profile">
                <span style="font-size: 0.85rem; color: #64748b;"><?= session()->get('user_name') ?> (Citizen)</span>
                <div class="user-avatar" style="width: 35px; height: 35px; background: #eff6ff; color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem;"><?= substr(session()->get('user_name'), 0, 1) ?></div>
            </div>
        </header>

        <div class="content-padding">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 2.5rem; gap: 2rem;">
                <div>
                    <h1 style="font-size: 2rem; color: var(--dark); font-weight: 800;">Welfare Schemes Exploration</h1>
                    <p style="color: #64748b;">Find and apply for government benefit programs tailored to your eligibility.</p>
                </div>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem;"></i>
                        <input type="text" id="schemeSearch" placeholder="Search by name or benefit..." 
                               style="padding: 0.8rem 1rem 0.8rem 2.5rem; width: 300px; border-radius: 12px; border: 1px solid var(--gray-200); box-shadow: 0 4px 6px rgba(0,0,0,0.02); font-size: 0.9rem;">
                    </div>
                    <!-- Master Button for Global Entry -->
                    <button onclick="openApplyForm(0, 'Welfare Scheme')" style="padding: 0.8rem 1.5rem; background: var(--dark); color: white; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; white-space: nowrap; transition: 0.3s; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);">
                        <i class="fas fa-plus-circle"></i> Lodge New Application
                    </button>
                </div>
            </div>

            <div class="scheme-grid" id="schemeGrid">
                <?php foreach($schemes as $s): ?>
                <div class="scheme-card">
                    <div class="scheme-title"><?= esc($s['title']) ?></div>
                    <p style="color: var(--gray-700); font-size: 0.95rem; line-height: 1.6;"><?= esc($s['description']) ?></p>
                    
                    <div style="margin-top: 1rem;">
                        <strong style="font-size: 0.85rem; display: block; margin-bottom: 5px; color: #64748b;">ELIGIBILITY:</strong>
                        <p style="font-size: 0.9rem; color: var(--dark); font-weight: 600;"><?= esc($s['eligibility_criteria']) ?></p>
                    </div>

                    <div class="benefit-box">
                        <strong style="font-size: 0.85rem; display: block; margin-bottom: 5px; color: #065f46;">PRIMARY BENEFIT:</strong>
                        <p style="font-size: 0.95rem; color: #065f46; font-weight: 700;"><?= esc($s['benefit_details']) ?></p>
                    </div>

                    <div style="margin-top: 1.5rem;">
                        <button type="button" class="btn-apply" onclick="openApplyForm(<?= $s['id'] ?>, '<?= esc($s['title']) ?>')">
                             <i class="fas fa-file-signature"></i> Apply Now
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div style="margin-top: 4rem;">
                <h2 style="margin-bottom: 1.5rem; color: var(--dark);"><i class="fas fa-history"></i> My Applied Schemes History</h2>
                <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1px solid var(--gray-200);">
                                <th style="padding: 1rem; text-align: left; font-size: 0.85rem; color: #64748b;">Scheme Name</th>
                                <th style="padding: 1rem; text-align: left; font-size: 0.85rem; color: #64748b;">Applied At</th>
                                <th style="padding: 1rem; text-align: left; font-size: 0.85rem; color: #64748b;">Status</th>
                                <th style="padding: 1rem; text-align: left; font-size: 0.85rem; color: #64748b;">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($applied_schemes)): ?>
                                <tr><td colspan="4" style="text-align: center; padding: 2rem; color: #94a3b8;">You haven't applied for any schemes yet.</td></tr>
                            <?php else: ?>
                                <?php foreach($applied_schemes as $app): ?>
                                <tr>
                                    <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; font-weight: 600; color: var(--dark);"><?= esc($app['scheme_title']) ?></td>
                                    <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; color: #64748b;"><?= date('d M Y', strtotime($app['applied_at'])) ?></td>
                                    <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9;">
                                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; 
                                            background: <?= $app['status'] == 'Approved' ? '#dcfce7' : ($app['status'] == 'Rejected' ? '#fee2e2' : '#fef3c7') ?>;
                                            color: <?= $app['status'] == 'Approved' ? '#166534' : ($app['status'] == 'Rejected' ? '#991b1b' : '#92400e') ?>;">
                                            <?= $app['status'] ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; color: #64748b; max-width: 300px;">
                                        <?php 
                                            if(!empty($app['remarks'])) {
                                                echo esc($app['remarks']);
                                            } else {
                                                if($app['status'] == 'Approved') echo '<span style="color:#166534">Enrollment Finalized</span>';
                                                elseif($app['status'] == 'Rejected') echo '<span style="color:#991b1b">Application Not Eligible</span>';
                                                else echo 'Waiting for Review';
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Modal -->
    <div class="modal-overlay" id="applyModal">
        <div class="modal" style="width: 700px; max-width: 95%;">
            <div class="modal-header">
                <div>
                    <h2 id="modal-title" style="color: var(--dark);">Scheme Application Form</h2>
                    <p style="font-size: 0.85rem; color: #64748b;">Please provide accurate details for eligibility verification.</p>
                </div>
                <button style="border:none; background:none; font-size: 1.5rem; cursor:pointer;" onclick="closeModal()">&times;</button>
            </div>
            <form id="apply-form" action="" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <!-- New Global Scheme Selector (Only visible if using top button) -->
                    <div class="form-group" id="scheme-selector-group" style="display: none; background: #eff6ff; padding: 1rem; border-radius: 12px; border-left: 4px solid var(--primary); margin-bottom: 2rem;">
                        <label>Select Scheme you wish to apply for *</label>
                        <select name="scheme_id_dynamic" id="scheme-dropdown">
                            <?php foreach($schemes as $s): ?>
                                <option value="<?= $s['id'] ?>"><?= esc($s['title']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label>Full Name of Applicant *</label>
                            <input type="text" name="data[applicant_name]" placeholder="Enter full name" required>
                        </div>
                        <div class="form-group">
                            <label>Father/Husband Name *</label>
                            <input type="text" name="data[relative_name]" placeholder="Enter father/husband name" required>
                        </div>
                        <div class="form-group">
                            <label>Annual Family Income (INR) *</label>
                            <input type="number" name="data[annual_income]" placeholder="e.g. 45000" required>
                        </div>
                        <div class="form-group">
                            <label>Category *</label>
                            <select name="data[category]" required>
                                <option value="General">General</option>
                                <option value="OBC">OBC</option>
                                <option value="SC">SC</option>
                                <option value="ST">ST</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Aadhar Number *</label>
                            <input type="text" name="data[aadhar_no]" placeholder="12-digit number" required pattern="[0-9]{12}">
                        </div>
                        <div class="form-group">
                            <label>Ration Card No. (BPL/APL)</label>
                            <input type="text" name="data[ration_card]" placeholder="Enter ration card number">
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 1rem;">
                        <label>Reason for Applying / Special Remarks</label>
                        <textarea name="data[applicant_remarks]" rows="3" placeholder="Briefly explain why you need this benefit..."></textarea>
                    </div>
                    
                    <div style="background: #fffbeb; border-left: 4px solid #f59e0b; padding: 1rem; border-radius: 8px; margin-top: 1rem;">
                        <p style="font-size: 0.85rem; color: #92400e;"><strong>Disclaimer:</strong> By submitting, you certify that the information provided is true and correct to the best of your knowledge.</p>
                    </div>
                </div>
                <div style="padding: 1.5rem; border-top: 1px solid var(--gray-200); text-align: right;">
                    <button type="button" class="btn-apply" style="background: var(--gray-700); width: auto; padding: 0.8rem 2rem; margin-right: 1rem;" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-apply" style="width: auto; padding: 0.8rem 2rem;">Submit Application</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openApplyForm(schemeId, schemeTitle) {
            const selectorGroup = document.getElementById('scheme-selector-group');
            const form = document.getElementById('apply-form');
            
            if (schemeId === 0) {
                // Global application mode
                document.getElementById('modal-title').innerText = 'Submit New Scheme Application';
                selectorGroup.style.display = 'block';
                // Dynamic action listener
                form.onsubmit = function(e) {
                    const selectedId = document.getElementById('scheme-dropdown').value;
                    form.action = "<?= base_url('user/schemes/apply') ?>/" + selectedId;
                };
            } else {
                // Direct application mode
                document.getElementById('modal-title').innerText = 'Apply for ' + schemeTitle;
                selectorGroup.style.display = 'none';
                form.action = "<?= base_url('user/schemes/apply') ?>/" + schemeId;
                form.onsubmit = null; // Reset
            }
            
            document.getElementById('applyModal').classList.add('open');
        }

        function closeModal() { 
            document.getElementById('applyModal').classList.remove('open'); 
        }

        // Live Search for Schemes (Cards)
        document.getElementById('schemeSearch').addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const cards = document.querySelectorAll('#schemeGrid .scheme-card');
            
            cards.forEach(card => {
                const text = card.innerText.toLowerCase();
                card.style.display = text.includes(query) ? '' : 'none';
            });
        });

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Successfully Submitted!',
                text: '<?= session()->getFlashdata('success') ?>',
                confirmButtonColor: '#2563eb',
                timer: 4000
            });
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Unable to Submit',
                text: '<?= session()->getFlashdata('error') ?>',
                confirmButtonColor: '#ef4444'
            });
        <?php endif; ?>
    </script>
</body>
</html>
