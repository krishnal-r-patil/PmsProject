<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Records Vault - Panchayat</title>
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
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .content-body { padding: 2.5rem; }

        .doc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem; }
        .doc-card { background: white; border-radius: 20px; padding: 2rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); border-top: 5px solid #10b981; transition: 0.3s; position: relative; overflow: hidden; }
        .doc-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
        
        .doc-icon { width: 60px; height: 60px; background: #ecfdf5; color: #10b981; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 1.5rem; }
        .doc-reg { font-family: monospace; font-size: 0.8rem; color: #64748b; font-weight: 700; background: #f8fafc; padding: 4px 10px; border-radius: 6px; }
        .doc-title { font-size: 1.25rem; font-weight: 700; color: var(--dark); margin: 1rem 0 0.5rem; }
        .doc-meta { font-size: 0.85rem; color: #64748b; margin-bottom: 1.5rem; }
        
        .btn-download { display: inline-flex; align-items: center; gap: 8px; width: 100%; justify-content: center; background: var(--dark); color: white; padding: 12px; border-radius: 12px; text-decoration: none; font-weight: 700; transition: 0.3s; }
        .btn-download:hover { background: #1e293b; }

        .empty-state { text-align: center; padding: 5rem 2rem; background: white; border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); width: 100%; max-width: 600px; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 600;"><i class="fas fa-vault" style="color: var(--primary);"></i> Official Documents Vault</div>
            <div><a href="<?= base_url('user/dashboard') ?>" style="color: #64748b; text-decoration: none; font-size: 0.9rem;"><i class="fas fa-home"></i> Dashboard</a></div>
        </header>

        <div class="content-body">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 2.5rem;">
                <div>
                    <h1 style="margin-bottom: 0.5rem; color: var(--dark);">My Digital Records</h1>
                    <p style="color: #64748b;">Access and download your verified government-issued certificates.</p>
                </div>
                <!-- Interactive Vault Search & Manage -->
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem;"></i>
                        <input type="text" id="vaultSearch" placeholder="Search certificates..." 
                               style="padding: 0.8rem 1rem 0.8rem 2.6rem; width: 300px; border-radius: 12px; border: 1px solid var(--gray-200); box-shadow: 0 4px 6px rgba(0,0,0,0.02); font-size: 0.9rem;">
                    </div>
                    <button id="manageBtn" class="btn-manage" onclick="toggleManagementMode()">
                        <i class="fas fa-tasks"></i> <span>Manage Vault</span>
                    </button>
                </div>
            </div>

            <?php if(empty($issued_certificates)): ?>
                <div class="empty-state">
                    <div style="font-size: 4rem; color: #e2e8f0; margin-bottom: 1.5rem;"><i class="fas fa-folder-open"></i></div>
                    <h2 style="color: var(--dark); margin-bottom: 0.5rem;">No Certificates Yet</h2>
                    <p style="color: #64748b; margin-bottom: 2rem;">Once the admin approves your application, your certificate will appear in this secure vault.</p>
                    <a href="<?= base_url('user/certificates') ?>" style="color: #2563eb; font-weight: 700; text-decoration: none;">Apply for a New Certificate &rarr;</a>
                </div>
            <?php else: ?>
                <div class="doc-grid" id="docGrid">
                    <?php foreach($issued_certificates as $cert): ?>
                        <?php 
                            $type = $cert['type'] ?? '';
                            $regNo = $cert['registration_no'] ?? '';
                            $displayTitle = 'Certificate';
                            $iconClass = 'fa-file-contract';
                            $colorClass = '#10b981'; // Green for Birth/Death
                            
                            if (strpos($regNo, 'INC') !== false || strtolower($type) == 'income') {
                                $displayTitle = 'Income Certificate';
                                $iconClass = 'fa-indian-rupee-sign';
                                $colorClass = '#1e3a8a'; // Navy Blue for Income
                            } elseif (strtolower($type) == 'death' || strpos($regNo, '/D-') !== false) {
                                $displayTitle = 'Death Certificate';
                                $iconClass = 'fa-dove';
                                $colorClass = '#334155'; // Slate for Death
                            } elseif (strpos($regNo, 'CST') !== false || strtolower($type) == 'caste') {
                                $displayTitle = 'Caste Certificate';
                                $iconClass = 'fa-file-invoice';
                                $colorClass = '#ea580c'; // Saffron for Caste
                            } elseif (strpos($regNo, 'DOM') !== false || strtolower($type) == 'domicile') {
                                $displayTitle = 'Domicile Certificate';
                                $iconClass = 'fa-house-user';
                                $colorClass = '#1e40af'; // Blue for Domicile
                            } elseif (strpos($regNo, 'CRS') !== false || strtolower($type) == 'birth' || strtolower($type) == 'birth certificate') {
                                $displayTitle = 'Birth Certificate';
                                $iconClass = 'fa-baby';
                                $colorClass = '#10b981'; // Green for Birth
                            }
                        ?>
                        <div class="doc-card" id="card-<?= $cert['id'] ?>" style="border-top-color: <?= $colorClass ?>" onclick="handleCardClick(this, <?= $cert['id'] ?>)">
                            <!-- SELECTION CHECKBOX (HIDDEN) -->
                            <div class="selection-overlay">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            
                            <div class="doc-reg"><?= esc($regNo) ?></div>
                            <div class="doc-icon" style="background: <?= $colorClass ?>10; color: <?= $colorClass ?>">
                                <i class="fas <?= $iconClass ?>"></i>
                            </div>
                            <h2 class="doc-title"><?= esc($displayTitle) ?></h2>
                            <div class="doc-meta">
                                <div><i class="fas fa-user"></i> &nbsp;<?= esc($cert['person_name']) ?></div>
                                <div style="margin-top: 5px;"><i class="fas fa-calendar-alt"></i> &nbsp;Issued: <?= date('d M Y', strtotime($cert['created_at'])) ?></div>
                            </div>
                            <a href="<?= base_url('user/certificate/view/'.$cert['id']) ?>" target="_blank" class="btn-download">
                                <i class="fas fa-file-pdf"></i> View / Download PDF
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- PAGE STYLES -->
    <style>
        .btn-manage { background: white; border: 1px solid var(--gray-200); color: var(--dark); padding: 0.8rem 1.2rem; border-radius: 12px; font-weight: 600; cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 8px; }
        .btn-manage:hover { background: var(--gray-100); }
        .btn-manage.delete-mode { background: #ef4444; color: white; border-color: #ef4444; }
        .btn-manage.delete-mode:hover { background: #dc2626; }

        .selection-overlay { position: absolute; top: 15px; right: 15px; font-size: 1.5rem; color: #cbd5e1; opacity: 0; transition: 0.3s; z-index: 5; pointer-events: none; }
        .management-mode .selection-overlay { opacity: 1; }
        .management-mode .doc-card { cursor: pointer; }
        .doc-card.selected { border: 2px solid var(--primary); transform: scale(0.98); }
        .doc-card.selected .selection-overlay { color: var(--primary); opacity: 1; }
        .management-mode .btn-download { opacity: 0.5; pointer-events: none; }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let isManagementMode = false;
        let selectedIds = new Set();

        function toggleManagementMode() {
            isManagementMode = !isManagementMode;
            const docGrid = document.getElementById('docGrid');
            const manageBtn = document.getElementById('manageBtn');
            const btnText = manageBtn.querySelector('span');

            if (isManagementMode) {
                docGrid.classList.add('management-mode');
                manageBtn.classList.add('delete-mode');
                btnText.innerText = "Delete Selected (0)";
                selectedIds.clear();
            } else {
                if (selectedIds.size > 0) {
                    confirmDeletions();
                } else {
                    resetManagementMode();
                }
            }
        }

        function handleCardClick(card, id) {
            if (!isManagementMode) return;
            
            if (selectedIds.has(id)) {
                selectedIds.delete(id);
                card.classList.remove('selected');
            } else {
                selectedIds.add(id);
                card.classList.add('selected');
            }

            document.getElementById('manageBtn').querySelector('span').innerText = `Delete Selected (${selectedIds.size})`;
        }

        function resetManagementMode() {
            isManagementMode = false;
            const docGrid = document.getElementById('docGrid');
            const manageBtn = document.getElementById('manageBtn');
            docGrid.classList.remove('management-mode');
            manageBtn.classList.remove('delete-mode');
            manageBtn.querySelector('span').innerText = "Manage Vault";
            document.querySelectorAll('.doc-card').forEach(c => c.classList.remove('selected'));
        }

        async function confirmDeletions() {
            const result = await Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete ${selectedIds.size} certificates from your vault. This cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete them!'
            });

            if (result.isConfirmed) {
                // Submit to backend
                const idsArray = Array.from(selectedIds);
                
                try {
                    const response = await fetch('<?= base_url('user/certificates/delete-bulk') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ ids: idsArray })
                    });

                    const data = await response.json();
                    if (data.status === 'success') {
                        location.reload();
                    } else {
                        Swal.fire('Error', 'Failed to delete records', 'error');
                    }
                } catch (e) {
                    console.error(e);
                    Swal.fire('Error', 'An unexpected error occurred', 'error');
                }
            }
            
            resetManagementMode();
        }

        // Live Search for Digital Vault Cards
        document.getElementById('vaultSearch').addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const cards = document.querySelectorAll('.doc-card');
            
            cards.forEach(card => {
                const text = card.innerText.toLowerCase();
                card.style.display = text.includes(query) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
