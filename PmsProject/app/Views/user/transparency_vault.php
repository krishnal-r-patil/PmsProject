<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Data: Social Audit & Transparency - Citizen Portal</title>
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

        .hero-banner { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); padding: 3.5rem 3rem; border-radius: 32px; color: white; margin-bottom: 2.5rem; position: relative; overflow: hidden; }
        .hero-banner::after { content: ''; position: absolute; top: -50px; right: -50px; width: 250px; height: 250px; background: rgba(37, 99, 235, 0.2); border-radius: 50%; filter: blur(50px); }
        .hero-badge { background: rgba(255,255,255,0.1); padding: 6px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 1.5rem; backdrop-filter: blur(10px); }

        .search-container { position: relative; max-width: 600px; margin-top: 2rem; }
        .search-container input { width: 100%; padding: 1.2rem 1.5rem; padding-left: 3.5rem; border: none; border-radius: 18px; font-size: 1.1rem; background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); }
        .search-container input::placeholder { color: rgba(255,255,255,0.5); }
        .search-container i { position: absolute; left: 1.5rem; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.5); font-size: 1.2rem; }

        .vault-grid { display: grid; grid-template-columns: 1fr; gap: 2.5rem; }
        .project-card { background: white; border-radius: 28px; padding: 2.5rem; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; }
        
        .project-header { display: flex; justify-content: space-between; align-items: start; margin-bottom: 2rem; }
        .project-title { font-size: 1.6rem; font-weight: 800; color: var(--dark); letter-spacing: -0.5px; }
        .budget-tag { background: #eff6ff; color: #2563eb; padding: 8px 16px; border-radius: 14px; font-weight: 800; font-size: 0.9rem; }

        .tabs-nav { display: flex; gap: 1rem; margin-bottom: 2rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 1rem; }
        .tab-btn { background: none; border: none; padding: 0.8rem 1.5rem; font-weight: 700; color: #94a3b8; cursor: pointer; border-radius: 12px; transition: 0.3s; }
        .tab-btn.active { background: #f8fafc; color: var(--primary); }

        .proof-scroller { display: flex; gap: 1.5rem; overflow-x: auto; padding-bottom: 1rem; scrollbar-width: thin; }
        .proof-scroller::-webkit-scrollbar { height: 6px; }
        .proof-scroller::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }

        .proof-card { flex: 0 0 300px; background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 20px; overflow: hidden; transition: 0.3s; }
        .proof-card:hover { transform: translateY(-5px); border-color: var(--primary); }
        
        .proof-img { width: 100%; height: 180px; object-fit: cover; background: #e2e8f0; display: flex; align-items: center; justify-content: center; }
        .proof-img i { font-size: 3rem; color: #cbd5e1; }
        .proof-content { padding: 1.2rem; }
        
        .proof-type { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 5px; display: block; }
        .proof-title { font-weight: 800; color: var(--dark); font-size: 1rem; line-height: 1.4; height: 2.8rem; overflow: hidden; }

        .geo-info { margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
        .btn-view { background: var(--dark); color: white; padding: 8px 16px; border-radius: 10px; text-decoration: none; font-size: 0.85rem; font-weight: 700; transition: 0.3s; }
        .btn-view:hover { background: var(--primary); }

        .empty-state { text-align: center; padding: 4rem; color: #94a3b8; background: #f8fafc; border-radius: 24px; border: 2px dashed #e2e8f0; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800;"><i class="fas fa-eye" style="color: var(--primary);"></i> Social Audit Portal</div>
            <div style="font-size: 0.85rem; color: #64748b;">Village Open Data Initiative</div>
        </header>

        <div class="content-padding">
            <div class="hero-banner">
                <div class="hero-badge"><i class="fas fa-check-circle"></i> Authenticated Government Records</div>
                <h1 style="font-size: 3rem; font-weight: 800; line-height: 1.1; margin-bottom: 1rem;">Social Audit & <br><span style="color: var(--primary);">Transparency Vault</span></h1>
                <p style="color: rgba(255,255,255,0.6); max-width: 600px; font-size: 1.1rem;">Empowering citizens with direct access to expenditure proofs, muster rolls, and physical progress data to ensure 100% corruption-free development.</p>
                
                <div class="search-container">
                    <i class="fas fa-search"></i>
                    <input type="text" id="projectSearch" placeholder="Search by Project Name or Ward..." onkeyup="filterVault()">
                </div>
            </div>

            <div class="vault-grid" id="vaultContainer">
                <?php foreach($projects as $p): ?>
                <div class="project-card" data-title="<?= strtolower(esc($p['title'])) ?>" data-ward="<?= strtolower(esc($p['ward_no'])) ?>">
                    <div class="project-header">
                        <div>
                            <div style="color: var(--primary); font-weight: 800; font-size: 0.8rem; text-transform: uppercase; margin-bottom: 8px;">GPDP Project #<?= str_pad($p['id'], 3, '0', STR_PAD_LEFT) ?></div>
                            <h2 class="project-title"><?= esc($p['title']) ?></h2>
                            <div style="color: #64748b; margin-top: 5px; font-size: 0.95rem;">
                                <i class="fas fa-map-marker-alt"></i> Location: <?= esc($p['ward_no']) ?> | 
                                <i class="far fa-calendar"></i> Started: <?= date('M Y', strtotime($p['start_date'])) ?>
                            </div>
                        </div>
                        <div class="budget-tag">
                            ₹<?= number_format($p['budget']) ?>
                            <div style="font-size: 0.65rem; text-align: center; color: #64748b; font-weight: 700; margin-top: 2px;">FUND: <?= $p['fund_source'] ?: 'SFC' ?></div>
                        </div>
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <div style="display: flex; justify-content: space-between; font-weight: 800; font-size: 0.85rem; margin-bottom: 10px;">
                            <span>Project Execution Progress</span>
                            <span><?= $p['progress_percent'] ?>%</span>
                        </div>
                        <div style="height: 12px; background: #f1f5f9; border-radius: 10px; overflow: hidden;">
                            <div style="width: <?= $p['progress_percent'] ?>%; height: 100%; background: var(--primary); transition: 1s ease;"></div>
                        </div>
                        <p style="font-size: 0.9rem; color: #64748b; margin-top: 15px;"><?= esc($p['description']) ?></p>
                    </div>

                    <h3 style="font-size: 1.1rem; font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-file-invoice-dollar" style="color: var(--primary);"></i> Transparency Records (Open Data)
                    </h3>

                    <?php if(empty($p['audits'])): ?>
                        <div class="empty-state">
                            <i class="fas fa-hourglass-half" style="font-size: 2rem; margin-bottom: 10px;"></i>
                            <p>No audit documents have been uploaded for this project yet.</p>
                        </div>
                    <?php else: ?>
                        <div class="proof-scroller">
                            <?php foreach($p['audits'] as $audit): 
                                $isImg = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $audit['file_path']);
                            ?>
                            <div class="proof-card">
                                <div class="proof-img">
                                    <?php if($isImg): ?>
                                        <img src="<?= base_url($audit['file_path']) ?>" alt="Evidence" style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php else: ?>
                                        <i class="fas fa-file-pdf"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="proof-content">
                                    <span class="proof-type"><?= $audit['type'] ?></span>
                                    <div class="proof-title"><?= esc($audit['remarks'] ?: 'Project Proof') ?></div>
                                    
                                    <div class="geo-info">
                                        <div style="font-size: 0.75rem; color: #94a3b8;">
                                            <i class="far fa-clock"></i> <?= date('d M Y', strtotime($audit['uploaded_at'])) ?>
                                            <?php if($audit['latitude']): ?>
                                                <br><span style="color: var(--success); font-weight: 800;"><i class="fas fa-map-pin"></i> Geo-Tagged</span>
                                            <?php endif; ?>
                                        </div>
                                        <a href="<?= base_url($audit['file_path']) ?>" target="_blank" class="btn-view">View</a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        function filterVault() {
            let input = document.getElementById('projectSearch').value.toLowerCase();
            let container = document.getElementById('vaultContainer');
            let cards = container.getElementsByClassName('project-card');

            for (let i = 0; i < cards.length; i++) {
                let title = cards[i].getAttribute('data-title');
                let ward = cards[i].getAttribute('data-ward');
                if (title.includes(input) || ward.includes(input)) {
                    cards[i].style.display = "";
                } else {
                    cards[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
