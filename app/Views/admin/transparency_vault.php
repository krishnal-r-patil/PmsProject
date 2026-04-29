<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Audit & Transparency Vault - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; --success: #10b981; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 90; }
        .content-padding { padding: 2.5rem; }

        .page-header { display: flex; justify-content: space-between; align-items: end; margin-bottom: 2.5rem; }
        
        .vault-grid { display: grid; grid-template-columns: 1fr; gap: 2rem; }
        .project-section { background: white; border-radius: 24px; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; }
        
        .project-info { display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 1.5rem; }
        .project-title { font-size: 1.5rem; font-weight: 800; color: var(--dark); }
        .project-meta { font-size: 0.9rem; color: #64748b; margin-top: 5px; }

        .audit-items { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem; margin-top: 1.5rem; }
        .audit-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 1.2rem; position: relative; transition: 0.3s; }
        .audit-card:hover { transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
        
        .type-badge { display: inline-block; padding: 4px 10px; border-radius: 8px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; margin-bottom: 10px; }
        .type-Bill { background: #fee2e2; color: #991b1b; }
        .type-Muster { background: #fef3c7; color: #92400e; }
        .type-Photo { background: #dcfce7; color: #166534; }

        .audit-preview { width: 100%; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 10px; background: #e2e8f0; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .audit-preview img { width: 100%; height: 100%; object-fit: cover; }
        .audit-preview i { font-size: 2.5rem; color: #94a3b8; }

        .btn-upload { background: var(--primary); color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 0.85rem; display: flex; align-items: center; gap: 6px; }
        .btn-delete { color: #ef4444; background: none; border: none; cursor: pointer; font-size: 0.9rem; position: absolute; top: 1.2rem; right: 1.2rem; }

        /* Modal */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
        .modal-overlay.open { display: flex; }
        .modal { background: white; width: 500px; border-radius: 28px; overflow: hidden; }
        .modal-header { padding: 1.5rem 2.5rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #f8fafc; }
        .modal-body { padding: 2.5rem; }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 800; font-size: 0.85rem; color: var(--gray-700); }
        input, select, textarea { width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800;"><i class="fas fa-shield-alt" style="color: var(--primary);"></i> Social Audit & Transparency Vault</div>
            <div style="font-size: 0.85rem; color: #64748b;">Public accountability through open expenditure data.</div>
        </header>

        <div class="content-padding">
            <div class="page-header">
                <div>
                    <h1 style="font-size: 2.2rem; font-weight: 800;">Transparency Vault</h1>
                    <p style="color: #64748b;">Manage digital proofs, bills, and geo-tagged progress photos for GPDP projects.</p>
                </div>
            </div>

            <div class="vault-grid">
                <?php foreach($projects as $p): ?>
                <div class="project-section">
                    <div class="project-info">
                        <div>
                            <h2 class="project-title"><?= esc($p['title']) ?></h2>
                            <div class="project-meta">
                                <i class="fas fa-map-marker-alt"></i> <?= esc($p['ward_no']) ?> | 
                                <i class="fas fa-coins"></i> ₹<?= number_format($p['budget']) ?> |
                                <span style="font-weight: 800; color: var(--primary);"><?= $p['progress_percent'] ?>% Complete</span>
                            </div>
                        </div>
                        <button class="btn-upload" onclick="openVaultModal(<?= $p['id'] ?>, '<?= esc($p['title']) ?>')">
                            <i class="fas fa-cloud-upload-alt"></i> Add Proof
                        </button>
                    </div>

                    <?php if(empty($p['audits'])): ?>
                        <div style="text-align: center; padding: 2rem; color: #94a3b8; border: 2px dashed #e2e8f0; border-radius: 20px;">
                            <i class="fas fa-folder-open" style="font-size: 2rem; margin-bottom: 10px;"></i>
                            <p>No audit documents uploaded yet for this project.</p>
                        </div>
                    <?php else: ?>
                        <div class="audit-items">
                            <?php foreach($p['audits'] as $audit): 
                                $isImg = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $audit['file_path']);
                            ?>
                            <div class="audit-card">
                                <a href="<?= base_url('admin/transparency/delete/'.$audit['id']) ?>" class="btn-delete" onclick="return confirm('Remove this document from the vault?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <span class="type-badge type-<?= explode(' ', $audit['type'])[0] ?>"><?= $audit['type'] ?></span>
                                
                                <div class="audit-preview">
                                    <?php if($isImg): ?>
                                        <img src="<?= base_url($audit['file_path']) ?>" alt="Proof">
                                    <?php else: ?>
                                        <i class="fas fa-file-pdf"></i>
                                    <?php endif; ?>
                                </div>

                                <div style="font-weight: 700; font-size: 0.85rem; color: var(--dark); margin-bottom: 5px;">
                                    <?= esc($audit['remarks'] ?: $audit['type']) ?>
                                </div>
                                
                                <div style="font-size: 0.7rem; color: #94a3b8; display: flex; justify-content: space-between;">
                                    <span><?= date('d M Y', strtotime($audit['uploaded_at'])) ?></span>
                                    <?php if($audit['latitude']): ?>
                                        <span title="Geo-tagged"><i class="fas fa-map-pin"></i> Fixed</span>
                                    <?php endif; ?>
                                </div>

                                <a href="<?= base_url($audit['file_path']) ?>" target="_blank" style="display: block; width: 100%; text-align: center; padding: 8px; background: white; border: 1px solid #e2e8f0; border-radius: 8px; margin-top: 10px; font-size: 0.8rem; font-weight: 700; color: var(--primary); text-decoration: none;">
                                    View Document
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal-overlay" id="vaultModal">
        <div class="modal">
            <div class="modal-header">
                <h2 style="font-weight: 800;">Upload Proof</h2>
                <button style="border:none; background:none; font-size: 1.5rem; cursor:pointer;" onclick="closeVaultModal()">&times;</button>
            </div>
            <form action="<?= base_url('admin/transparency/save') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="project_id" id="modal-project-id">
                <div class="modal-body">
                    <p id="modal-project-title" style="margin-bottom: 1.5rem; font-weight: 700; color: var(--primary);"></p>
                    
                    <div class="form-group">
                        <label>Document Type *</label>
                        <select name="type" required>
                            <option value="Bill">Official Bill/Invoice</option>
                            <option value="Muster Roll">Muster Roll (Labour Attendance)</option>
                            <option value="Photo Before">Photo: Before Work</option>
                            <option value="Photo After">Photo: After Completion</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Select File * (Image or PDF)</label>
                        <input type="file" name="audit_file" accept=".jpg,.jpeg,.png,.webp,.pdf" required>
                    </div>

                    <div class="form-group">
                        <label>Remarks/Title</label>
                        <input type="text" name="remarks" placeholder="e.g. Phase 1 Cement Bill #452">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label>Latitude (Optional)</label>
                            <input type="text" name="latitude" id="lat-input" placeholder="e.g. 21.3142">
                        </div>
                        <div class="form-group">
                            <label>Longitude (Optional)</label>
                            <input type="text" name="longitude" id="lng-input" placeholder="e.g. 76.2141">
                        </div>
                    </div>
                    
                    <button type="button" onclick="getLocation()" style="width: 100%; margin-bottom: 1rem; background: #f1f5f9; border: 1px solid #e2e8f0; padding: 10px; border-radius: 10px; font-size: 0.8rem; font-weight: 700; cursor: pointer;">
                        <i class="fas fa-location-arrow"></i> Fetch My Current Geo-Tag
                    </button>

                    <button type="submit" class="btn-upload" style="width: 100%; justify-content: center; height: 50px;">Upload to Vault</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openVaultModal(id, title) {
            document.getElementById('modal-project-id').value = id;
            document.getElementById('modal-project-title').innerText = "Project: " + title;
            document.getElementById('vaultModal').classList.add('open');
        }
        function closeVaultModal() { document.getElementById('vaultModal').classList.remove('open'); }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('lat-input').value = position.coords.latitude.toFixed(6);
                    document.getElementById('lng-input').value = position.coords.longitude.toFixed(6);
                }, function(error) {
                    alert("Error fetching location: " + error.message);
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Vault Updated', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#2563eb' });
        <?php endif; ?>
    </script>
</body>
</html>
