<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Profile - <?= esc($resident['name']) ?></title>
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
            --success: #10b981;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .nav-menu { list-style: none; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 0.8rem 1rem; color: #94a3b8; text-decoration: none; border-radius: 8px; transition: all 0.3s; margin-bottom: 0.5rem; }
        .nav-link:hover { background-color: #334155; color: white; }

        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; padding: 2rem; }

        .page-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; }
        .back-btn { display: inline-flex; align-items: center; gap: 6px; color: var(--gray-700); text-decoration: none; font-size: 0.9rem; padding: 0.5rem 1rem; border-radius: 8px; background: white; border: 1px solid var(--gray-200); transition: all 0.2s; }
        .back-btn:hover { background: var(--gray-100); color: var(--dark); }

        .profile-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; }
        .profile-banner { background: linear-gradient(135deg, #1e40af, #2563eb, #3b82f6); padding: 2.5rem 2rem; display: flex; align-items: center; gap: 1.5rem; }
        .profile-avatar { width: 80px; height: 80px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; font-weight: 700; border: 3px solid rgba(255,255,255,0.5); }
        .profile-meta h2 { color: white; font-size: 1.6rem; font-weight: 700; }
        .profile-meta p { color: rgba(255,255,255,0.8); margin-top: 0.3rem; }
        .profile-badges { display: flex; gap: 0.5rem; margin-top: 0.6rem; }
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-white { background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.35); }
        .badge-cat { background: white; color: var(--primary); }

        .profile-body { padding: 2rem; }
        .section-title { font-size: 1rem; font-weight: 700; color: var(--dark); padding-bottom: 0.7rem; border-bottom: 2px solid #e0f2fe; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 8px; }
        .section-title i { color: var(--primary); }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.2rem; margin-bottom: 2rem; }
        .info-item label { font-size: 0.75rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.3rem; }
        .info-item span { font-size: 0.95rem; color: var(--dark); font-weight: 500; }
        .info-item span.empty { color: #cbd5e1; font-style: italic; }

        .profile-actions { display: flex; gap: 1rem; padding-top: 1.5rem; border-top: 1px solid var(--gray-200); }
        .btn-edit-profile { background: var(--primary); color: white; padding: 0.65rem 1.4rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
        .btn-edit-profile:hover { background: #1d4ed8; }
    </style>
</head>
<body>
    <div class="sidebar">
        <?= view('admin/partials/sidebar') ?>
    </div>

    <div class="main-content">
        <div class="page-header">
            <a href="<?= base_url('admin/residents') ?>" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Parivar Register
            </a>
            <h1 style="font-size:1.4rem; color: var(--dark);">Resident Profile</h1>
        </div>

        <div class="profile-card">
            <!-- Banner -->
            <div class="profile-banner">
                <div class="profile-avatar">
                    <?= strtoupper(substr($resident['name'], 0, 1)) ?>
                </div>
                <div class="profile-meta">
                    <h2><?= esc($resident['name']) ?></h2>
                    <p>S/O: <?= esc($resident['father_name'] ?: '—') ?></p>
                    <div class="profile-badges">
                        <span class="badge badge-white"><i class="fas fa-id-card"></i> <?= esc($resident['family_id'] ?: 'No Family ID') ?></span>
                        <span class="badge badge-cat"><?= esc($resident['category'] ?: '—') ?></span>
                        <?php if($resident['gender']): ?>
                            <span class="badge badge-white"><?= esc($resident['gender']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="profile-body">

                <!-- Personal Information -->
                <div class="section-title"><i class="fas fa-user"></i> Personal Information</div>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Full Name</label>
                        <span><?= esc($resident['name'] ?: '—') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Father's Name</label>
                        <span><?= esc($resident['father_name'] ?: '—') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Date of Birth</label>
                        <span><?= $resident['dob'] ? date('d M Y', strtotime($resident['dob'])) : '—' ?></span>
                    </div>
                    <div class="info-item">
                        <label>Gender</label>
                        <span><?= esc($resident['gender'] ?: '—') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Category</label>
                        <span><?= esc($resident['category'] ?: '—') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Occupation</label>
                        <span><?= esc($resident['occupation'] ?: '—') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Annual Income</label>
                        <span><?= $resident['income_annual'] ? '₹' . number_format($resident['income_annual'], 2) : '—' ?></span>
                    </div>
                    <div class="info-item">
                        <label>Email</label>
                        <span><?= esc($resident['email'] ?: '—') ?></span>
                    </div>
                </div>

                <!-- Identity Documents -->
                <div class="section-title"><i class="fas fa-fingerprint"></i> Identity Documents</div>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Aadhar Number</label>
                        <span><?= esc($resident['aadhar_no'] ?: '—') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Voter ID</label>
                        <span><?= esc($resident['voter_id'] ?: '—') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Family ID (Samagra)</label>
                        <span><?= esc($resident['family_id'] ?: '—') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Phone Number</label>
                        <span><?= esc($resident['phone'] ?: '—') ?></span>
                    </div>
                </div>

                <!-- Address -->
                <div class="section-title"><i class="fas fa-map-marker-alt"></i> Address Details</div>
                <div class="info-grid">
                    <div class="info-item">
                        <label>House No.</label>
                        <span><?= esc($resident['house_no'] ?: '—') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Ward No.</label>
                        <span><?= esc($resident['ward_no'] ?: '—') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Village / Gram</label>
                        <span><?= esc($resident['village'] ?: '—') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Block</label>
                        <span><?= esc($resident['block'] ?: '—') ?></span>
                    </div>
                    <div class="info-item">
                        <label>District</label>
                        <span><?= esc($resident['district'] ?: '—') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Member Since</label>
                        <span><?= $resident['created_at'] ? date('d M Y', strtotime($resident['created_at'])) : '—' ?></span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="profile-actions">
                    <a href="<?= base_url('admin/residents/edit/' . $resident['id']) ?>" class="btn-edit-profile">
                        <i class="fas fa-edit"></i> Edit Resident
                    </a>
                    <a href="<?= base_url('admin/residents') ?>" class="back-btn">
                        <i class="fas fa-list"></i> All Residents
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
