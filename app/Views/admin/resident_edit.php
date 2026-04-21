<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resident - <?= esc($resident['name']) ?></title>
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
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .nav-menu { list-style: none; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 0.8rem 1rem; color: #94a3b8; text-decoration: none; border-radius: 8px; transition: all 0.3s; margin-bottom: 0.5rem; }
        .nav-link:hover { background-color: #334155; color: white; }

        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; padding: 2rem; }

        .page-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; }
        .back-btn { display: inline-flex; align-items: center; gap: 6px; color: var(--gray-700); text-decoration: none; font-size: 0.9rem; padding: 0.5rem 1rem; border-radius: 8px; background: white; border: 1px solid var(--gray-200); transition: all 0.2s; white-space: nowrap; }
        .back-btn:hover { background: var(--gray-100); color: var(--dark); }

        .form-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; }

        .form-banner { background: linear-gradient(135deg, #1e3a8a, #2563eb); padding: 1.8rem 2rem; display: flex; align-items: center; gap: 1rem; }
        .form-banner-icon { width: 54px; height: 54px; border-radius: 50%; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: white; border: 2px solid rgba(255,255,255,0.35); }
        .form-banner h2 { color: white; font-size: 1.3rem; font-weight: 700; }
        .form-banner p  { color: rgba(255,255,255,0.75); font-size: 0.88rem; margin-top: 0.2rem; }

        form { padding: 2rem; }

        .section-title { font-size: 0.95rem; font-weight: 700; color: var(--dark); padding-bottom: 0.6rem; border-bottom: 2px solid #e0f2fe; margin-bottom: 1.4rem; margin-top: 1.8rem; display: flex; align-items: center; gap: 8px; }
        .section-title:first-of-type { margin-top: 0; }
        .section-title i { color: var(--primary); }

        .form-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.2rem; }
        .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
        .form-group.full { grid-column: 1 / -1; }
        .form-group label { font-size: 0.8rem; font-weight: 600; color: var(--gray-700); text-transform: uppercase; letter-spacing: 0.4px; }
        .form-group input,
        .form-group select { padding: 0.6rem 0.9rem; border: 1.5px solid var(--gray-200); border-radius: 8px; font-size: 0.92rem; color: var(--dark); background: white; transition: border-color 0.2s, box-shadow 0.2s; outline: none; }
        .form-group input:focus,
        .form-group select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }

        .form-actions { display: flex; gap: 1rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--gray-200); }
        .btn-save { background: var(--primary); color: white; padding: 0.7rem 2rem; border: none; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s; }
        .btn-save:hover { background: #1d4ed8; }
        .btn-cancel { padding: 0.7rem 1.6rem; background: white; border: 1.5px solid var(--gray-200); border-radius: 8px; font-weight: 600; color: var(--gray-700); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
        .btn-cancel:hover { background: var(--gray-100); }
    </style>
</head>
<body>
    <div class="sidebar">
        <?= view('admin/partials/sidebar') ?>
    </div>

    <div class="main-content">
        <div class="page-header">
            <a href="<?= base_url('admin/residents') ?>" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <h1 style="font-size:1.4rem; color: var(--dark);">Edit Resident</h1>
        </div>

        <div class="form-card">
            <!-- Banner -->
            <div class="form-banner">
                <div class="form-banner-icon"><i class="fas fa-user-edit"></i></div>
                <div>
                    <h2>Editing: <?= esc($resident['name']) ?></h2>
                    <p>Family ID: <?= esc($resident['family_id'] ?: 'N/A') ?> &nbsp;|&nbsp; Ward: <?= esc($resident['ward_no'] ?: 'N/A') ?></p>
                </div>
            </div>

            <!-- Form -->
            <form action="<?= base_url('admin/residents/save/' . $resident['id']) ?>" method="POST">
                <?= csrf_field() ?>

                <!-- Personal Information -->
                <p class="section-title"><i class="fas fa-user"></i> Personal Information</p>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" value="<?= esc($resident['name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?= esc($resident['email']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="father_name">Father's / Husband's Name</label>
                        <input type="text" id="father_name" name="father_name" value="<?= esc($resident['father_name']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" value="<?= esc($resident['dob']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="">— Select —</option>
                            <?php foreach(['Male','Female','Other'] as $g): ?>
                                <option value="<?= $g ?>" <?= $resident['gender'] == $g ? 'selected' : '' ?>><?= $g ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category" name="category">
                            <option value="">— Select —</option>
                            <?php foreach(['General','OBC','SC','ST'] as $c): ?>
                                <option value="<?= $c ?>" <?= $resident['category'] == $c ? 'selected' : '' ?>><?= $c ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="occupation">Occupation</label>
                        <input type="text" id="occupation" name="occupation" value="<?= esc($resident['occupation']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="income_annual">Annual Income (₹)</label>
                        <input type="number" id="income_annual" name="income_annual" step="0.01" value="<?= esc($resident['income_annual']) ?>">
                    </div>
                </div>

                <!-- Identity Documents -->
                <p class="section-title"><i class="fas fa-fingerprint"></i> Identity Documents</p>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="aadhar_no">Aadhar Number</label>
                        <input type="text" id="aadhar_no" name="aadhar_no" maxlength="12" value="<?= esc($resident['aadhar_no']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="voter_id">Voter ID</label>
                        <input type="text" id="voter_id" name="voter_id" value="<?= esc($resident['voter_id']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="family_id">Family ID (Samagra)</label>
                        <input type="text" id="family_id" name="family_id" value="<?= esc($resident['family_id']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" maxlength="15" value="<?= esc($resident['phone']) ?>">
                    </div>
                </div>

                <!-- Address Details -->
                <p class="section-title"><i class="fas fa-map-marker-alt"></i> Address Details</p>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="house_no">House No.</label>
                        <input type="text" id="house_no" name="house_no" value="<?= esc($resident['house_no']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="ward_no">Ward No.</label>
                        <input type="text" id="ward_no" name="ward_no" value="<?= esc($resident['ward_no']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="village">Village / Gram</label>
                        <input type="text" id="village" name="village" value="<?= esc($resident['village']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="block">Block</label>
                        <input type="text" id="block" name="block" value="<?= esc($resident['block']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="district">District</label>
                        <input type="text" id="district" name="district" value="<?= esc($resident['district']) ?>">
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <a href="<?= base_url('admin/residents/view/' . $resident['id']) ?>" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
