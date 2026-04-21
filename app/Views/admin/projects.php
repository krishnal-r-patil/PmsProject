<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infrastructure & GPDP Progress - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 90; }
        .content-padding { padding: 2.5rem; }

        .page-header { display: flex; justify-content: space-between; align-items: end; margin-bottom: 2.5rem; }
        .btn-add { background: var(--dark); color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: 0.3s; }
        .btn-add:hover { background: #1e293b; transform: translateY(-2px); }

        .project-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 2rem; }
        .project-card { background: white; border-radius: 24px; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; position: relative; }
        
        .status-badge { position: absolute; top: 2rem; right: 2rem; padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; }
        .status-Planned { background: #f1f5f9; color: #64748b; }
        .status-In-Progress { background: #eff6ff; color: #2563eb; }
        .status-Completed { background: #dcfce7; color: #166534; }

        .project-title { font-size: 1.4rem; font-weight: 800; color: var(--dark); max-width: 80%; line-height: 1.3; margin-bottom: 0.5rem; }
        .project-desc { color: #64748b; font-size: 0.95rem; line-height: 1.5; margin-bottom: 1.5rem; }

        .progress-container { margin: 2rem 0; }
        .progress-header { display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-weight: 800; font-size: 0.85rem; color: var(--dark); }
        .progress-bar { height: 10px; background: #f1f5f9; border-radius: 10px; overflow: hidden; }
        .progress-fill { height: 100%; background: var(--primary); transition: 1s ease-in-out; }

        .meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; border-top: 1px solid #f1f5f9; padding-top: 1.5rem; }
        .meta-item { border-right: 1px solid #f1f5f9; }
        .meta-item:last-child { border-right: none; }
        .meta-label { font-size: 0.7rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .meta-value { font-size: 1rem; font-weight: 800; color: var(--dark); margin-top: 2px; }

        .card-actions { display: flex; gap: 10px; margin-top: 2rem; }
        .btn-action { flex: 1; padding: 0.7rem; border: 1px solid #e2e8f0; border-radius: 10px; background: white; color: var(--dark); font-weight: 700; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.85rem; }
        .btn-action:hover { background: #f8fafc; border-color: var(--primary); color: var(--primary); }

        /* Modal */
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
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800;"><i class="fas fa-road" style="color: var(--primary);"></i> Village Infrastructure & GPDP Hub</div>
            <div style="font-size: 0.85rem; color: #64748b;">Monitoring development and fund utilization.</div>
        </header>

        <div class="content-padding">
            <div class="page-header">
                <div>
                    <h1 style="font-size: 2.2rem; font-weight: 800;">Gram Panchayat Projects</h1>
                    <p style="color: #64748b;">Managing the execution of modern infrastructure in our village.</p>
                </div>
                <button class="btn-add" onclick="openModal()">
                    <i class="fas fa-plus-circle"></i> Plan New Project
                </button>
            </div>

            <div class="project-grid">
                <?php foreach($projects as $p): ?>
                <div class="project-card">
                    <span class="status-badge status-<?= $p['status'] ?>"><?= $p['status'] ?></span>
                    <h2 class="project-title"><?= esc($p['title']) ?></h2>
                    <p class="project-desc"><?= esc($p['description']) ?></p>

                    <div class="progress-container">
                        <div class="progress-header">
                            <span>Project Progress</span>
                            <span><?= $p['progress_percent'] ?>%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?= $p['progress_percent'] ?>%; background-color: <?= $p['status'] == 'Completed' ? '#10b981' : 'var(--primary)' ?>;"></div>
                        </div>
                    </div>

                    <div class="meta-grid">
                        <div class="meta-item">
                            <div class="meta-label">Allocated Budget</div>
                            <div class="meta-value">₹<?= number_format($p['budget'], 2) ?></div>
                            <div style="font-size:0.65rem; color:#94a3b8; font-weight:800; text-transform:uppercase; margin-top:5px;">Source: <?= esc($p['fund_source'] ?: 'General Fund') ?></div>
                        </div>
                        <div class="meta-item" style="padding-left: 1rem;">
                            <div class="meta-label">Exec. Agency</div>
                            <div class="meta-value"><?= esc($p['executing_agency'] ?: 'Gram Panchayat') ?></div>
                            <div style="font-size:0.65rem; color:#94a3b8; font-weight:800; text-transform:uppercase; margin-top:5px;">Loc: <?= esc($p['ward_no']) ?></div>
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; background: #f8fafc; padding: 12px; border-radius: 12px; display: flex; align-items: center; gap: 10px;">
                        <i class="far fa-calendar-alt" style="color: var(--primary);"></i>
                        <div style="font-size: 0.8rem; font-weight: 700; color: #64748b;">
                            Timeline: <?= date('M Y', strtotime($p['start_date'])) ?> – <?= $p['estimate_end_date'] ? date('M Y', strtotime($p['estimate_end_date'])) : 'TBD' ?>
                        </div>
                    </div>

                    <div class="card-actions">
                        <button class="btn-action" onclick="openProgressModal(<?= $p['id'] ?>, <?= $p['progress_percent'] ?>, '<?= $p['status'] ?>')">
                            <i class="fas fa-tasks"></i> Update Progress
                        </button>
                        <a href="<?= base_url('admin/transparency') ?>" class="btn-action" style="text-decoration: none;">
                            <i class="fas fa-shield-alt"></i> Vault
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- New Project Modal -->
    <div class="modal-overlay" id="projectModal">
        <div class="modal">
            <div class="modal-header">
                <h2 style="font-weight: 800;">Plan New Development</h2>
                <button style="border:none; background:none; font-size: 1.5rem; cursor:pointer;" onclick="closeModal()">&times;</button>
            </div>
            <form action="<?= base_url('admin/projects/save') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Project Title *</label>
                        <input type="text" name="title" placeholder="e.g. Ward 4 Concrete Road" required>
                    </div>
                    <div class="form-group">
                        <label>Description *</label>
                        <textarea name="description" rows="3" placeholder="Scope of work details..." required></textarea>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label>Budget (INR) *</label>
                            <input type="number" name="budget" placeholder="1500000" required>
                        </div>
                        <div class="form-group">
                            <label>Ward No *</label>
                            <select name="ward_no" required>
                                <option value="Ward 01">Ward 01</option>
                                <option value="Ward 02">Ward 02</option>
                                <option value="Ward 03">Ward 03</option>
                                <option value="Ward 04">Ward 04</option>
                            </select>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label>Target Start Date *</label>
                            <input type="date" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label>Estimate End Date *</label>
                            <input type="date" name="estimate_end_date" required>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label>Executing Agency *</label>
                            <select name="executing_agency" required>
                                <option value="Gram Panchayat Management">Gram Panchayat Management</option>
                                <option value="Contractor (Panchayat Hire)">Private Contractor</option>
                                <option value="PWD Department">PWD Department</option>
                                <option value="Local SHG/Committee">Local SHG / Committee</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Fund Source (SFC/FFC) *</label>
                            <select name="fund_source" required>
                                <option value="15th Finance Commission (FFC)">15th FC (Central Grant)</option>
                                <option value="State Finance Commission (SFC)">State Finance Commission</option>
                                <option value="MGNREGA Scheme">MGNREGA Development</option>
                                <option value="Member of Parliament (MPLAD)">MPLAD Fund</option>
                                <option value="Panchayat Own Income">Panchayat Own Income</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn-add" style="width: 100%; justify-content: center; height: 55px;">Initiate Project</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Progress Modal -->
    <div class="modal-overlay" id="progressModal">
        <div class="modal" style="width: 450px;">
            <div class="modal-header">
                <h2 style="font-weight: 800;">Update Status</h2>
                <button style="border:none; background:none; font-size: 1.5rem; cursor:pointer;" onclick="closeProgressModal()">&times;</button>
            </div>
            <form action="<?= base_url('admin/projects/update-progress') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="prog-id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Development Status *</label>
                        <select name="status" id="prog-status" required>
                            <option value="Planned">Planned</option>
                            <option value="In-Progress">In-Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Progress Percentage * (<span id="perc-val">0</span>%)</label>
                        <input type="range" name="progress_percent" id="prog-range" min="0" max="100" step="5" style="padding: 0;" oninput="document.getElementById('perc-val').innerText = this.value">
                    </div>
                    <button type="submit" class="btn-add" style="width: 100%; justify-content: center; height: 50px; background: var(--primary);">Save Update</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openModal() { document.getElementById('projectModal').classList.add('open'); }
        function closeModal() { document.getElementById('projectModal').classList.remove('open'); }
        
        function openProgressModal(id, perc, status) {
            document.getElementById('prog-id').value = id;
            document.getElementById('prog-range').value = perc;
            document.getElementById('perc-val').innerText = perc;
            document.getElementById('prog-status').value = status;
            document.getElementById('progressModal').classList.add('open'); 
        }
        function closeProgressModal() { document.getElementById('progressModal').classList.remove('open'); }

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Great!', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#2563eb' });
        <?php endif; ?>
    </script>
</body>
</html>
