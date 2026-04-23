<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Village Development (GPDP) - E-Panchayat</title>
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

        .project-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(420px, 1fr)); gap: 2.5rem; }
        .project-card { background: white; border-radius: 28px; padding: 2.5rem; box-shadow: 0 4px 25px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; position: relative; overflow: hidden; }
        
        .status-pill { position: absolute; top: 1.5rem; right: 1.5rem; padding: 6px 16px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
        .pill-Planned { background: #f1f5f9; color: #64748b; }
        .pill-In-Progress { background: #eff6ff; color: #2563eb; }
        .pill-Completed { background: #dcfce7; color: #166534; }

        .project-meta-top { font-size: 0.8rem; font-weight: 700; color: var(--primary); text-transform: uppercase; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 8px; }
        .project-title { font-size: 1.6rem; font-weight: 800; color: var(--dark); margin-bottom: 1rem; line-height: 1.25; }
        .project-info { color: #64748b; font-size: 1rem; line-height: 1.6; margin-bottom: 2rem; }

        .progress-section { background: #f8fafc; padding: 1.5rem; border-radius: 20px; margin-bottom: 2rem; border: 1px solid #f1f5f9; }
        .progress-label { display: flex; justify-content: space-between; font-weight: 800; font-size: 0.9rem; color: var(--dark); margin-bottom: 0.75rem; }
        .progress-bg { height: 12px; background: #e2e8f0; border-radius: 10px; overflow: hidden; }
        .progress-bar { height: 100%; width: 0; background: linear-gradient(90deg, #2563eb, #3b82f6); border-radius: 10px; transition: 1.5s ease-out; }

        .data-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        .data-box { }
        .data-label { font-size: 0.7rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; margin-bottom: 4px; }
        .data-val { font-size: 1.1rem; font-weight: 800; color: var(--dark); }

        .btn-audit { margin-top: 2rem; display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 1rem; background: var(--dark); color: white; border-radius: 12px; text-decoration: none; font-weight: 800; font-size: 0.9rem; transition: 0.3s; }
        .btn-audit:hover { background: var(--primary); transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2); }

        .empty-state { text-align: center; padding: 6rem 2rem; grid-column: 1/-1; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800;"><i class="fas fa-city" style="color: var(--primary);"></i> Village Development Portal (GPDP)</div>
            <div style="font-size: 0.85rem; color: #64748b;">Public Transparency in Infrastructure Execution.</div>
        </header>

        <div class="content-padding">
            <div style="margin-bottom: 3rem;">
                <h1 style="font-size: 2.5rem; font-weight: 800; color: var(--dark);">Infrastructure Progress</h1>
                <p style="color: #64748b; font-size: 1.1rem;">Track how your village funds are being utilized for better roads, schools, and facilities.</p>
            </div>

            <div class="project-grid">
                <?php if(empty($projects)): ?>
                    <div class="empty-state">
                        <i class="fas fa-construction" style="font-size: 4rem; color: #e2e8f0; margin-bottom: 1.5rem;"></i>
                        <h2 style="color: #94a3b8;">No projects recorded for this financial year yet.</h2>
                    </div>
                <?php else: ?>
                    <?php foreach($projects as $p): ?>
                    <div class="project-card">
                        <span class="status-pill pill-<?= $p['status'] ?>"><?= $p['status'] ?></span>
                        <div class="project-meta-top"><i class="fas fa-map-marker-alt"></i> <?= esc($p['ward_no']) ?></div>
                        <h2 class="project-title"><?= esc($p['title']) ?></h2>
                        <p class="project-info"><?= esc($p['description']) ?></p>

                        <div class="progress-section">
                            <div class="progress-label">
                                <span>Execution Progress</span>
                                <span><?= $p['progress_percent'] ?>%</span>
                            </div>
                            <div class="progress-bg">
                                <div class="progress-bar" style="width: <?= $p['progress_percent'] ?>%; background: <?= $p['status'] == 'Completed' ? '#10b981' : 'linear-gradient(90deg, #2563eb, #3b82f6)' ?>;"></div>
                            </div>
                        </div>

                        <div class="data-grid">
                            <div class="data-box">
                                <div class="data-label">Allocated Budget</div>
                                <div class="data-val">₹<?= number_format($p['budget'], 2) ?></div>
                                <div style="font-size: 0.65rem; color: #94a3b8; font-weight: 700; margin-top: 4px;">FUND: <?= esc($p['fund_source'] ?: 'General') ?></div>
                            </div>
                            <div class="data-box">
                                <div class="data-label">Executing Body</div>
                                <div class="data-val"><?= esc($p['executing_agency'] ?: 'Gram Panchayat') ?></div>
                                <div style="font-size: 0.65rem; color: #94a3b8; font-weight: 700; margin-top: 4px;">LOC: <?= esc($p['ward_no']) ?></div>
                            </div>
                        </div>

                        <div style="margin-top: 1.5rem; background: #f8fafc; padding: 12px; border-radius: 12px; display: flex; align-items: center; gap: 10px;">
                            <i class="far fa-calendar-alt" style="color: var(--primary);"></i>
                            <div style="font-size: 0.8rem; font-weight: 700; color: #64748b;">
                                Timeline: <?= date('M Y', strtotime($p['start_date'])) ?> – <?= $p['estimate_end_date'] ? date('M Y', strtotime($p['estimate_end_date'])) : 'TBD' ?>
                            </div>
                        </div>

                        <a href="<?= base_url('user/transparency') ?>" class="btn-audit">
                            <i class="fas fa-shield-alt"></i> View Audit Proofs & Bills
                        </a>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
