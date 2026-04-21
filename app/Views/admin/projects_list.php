<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPDP Work Progress - Gram Panchayat</title>
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
            --warning: #f59e0b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; display: flex; align-items: center; gap: 10px; color: white; text-decoration: none; }
        .sidebar-brand span { color: var(--primary); }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 0.8rem 1rem; color: #94a3b8; text-decoration: none; border-radius: 8px; transition: all 0.3s; margin-bottom: 0.5rem; }
        .nav-link:hover, .nav-link.active { background-color: #334155; color: white; }
        .nav-link.active { background-color: var(--primary); }

        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; padding: 2rem; }
        
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .header-actions h1 { font-size: 1.8rem; color: var(--dark); }
        
        .btn-add { background: var(--primary); color: white; padding: 0.6rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 8px; }

        .project-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem; }
        .project-card { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border-left: 5px solid var(--primary); }
        .project-card.Completed { border-left-color: var(--success); }
        .project-card.Planned { border-left-color: var(--gray-700); }

        .project-status { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; padding: 4px 10px; border-radius: 20px; display: inline-block; margin-bottom: 1rem; }
        .status-Planned { background: #f1f5f9; color: #475569; }
        .status-In-Progress { background: #fff7ed; color: #c2410c; }
        .status-Completed { background: #ecfdf5; color: #047857; }

        .project-title { font-size: 1.25rem; font-weight: 700; color: var(--dark); margin-bottom: 0.5rem; }
        .project-desc { font-size: 0.9rem; color: var(--gray-700); margin-bottom: 1.5rem; min-height: 3em; }
        
        .project-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 0.85rem; border-top: 1px solid var(--gray-200); pt: 1rem; padding-top: 1rem; }
        .meta-item { display: flex; flex-direction: column; }
        .meta-label { color: var(--gray-700); font-weight: 500; font-size: 0.75rem; }
        .meta-value { color: var(--dark); font-weight: 600; }

        .progress-bar { height: 8px; background: var(--gray-200); border-radius: 10px; margin: 1.5rem 0 0.5rem; overflow: hidden; }
        .progress-fill { height: 100%; background: var(--primary); width: 0%; transition: width 1s; }
    </style>
</head>
<body>

    <div class="sidebar">
        <?= view('admin/partials/sidebar') ?>
    </div>

    <div class="main-content">
        <div class="header-actions">
            <div>
                <h1>Infrastructure & GPDP Progress</h1>
                <p style="color: var(--gray-700);">Monitoring village development and fund utilization</p>
            </div>
            <button class="btn-add">
                <i class="fas fa-plus"></i> New Project Plan
            </button>
        </div>

        <div class="project-grid">
            <?php foreach($projects as $p): ?>
            <div class="project-card <?= $p['status'] ?>">
                <span class="project-status status-<?= $p['status'] ?>"><?= $p['status'] ?></span>
                <div class="project-title"><?= $p['title'] ?></div>
                <p class="project-desc"><?= $p['description'] ?></p>
                
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?= $p['status'] == 'Completed' ? '100' : ($p['status'] == 'In-Progress' ? '45' : '0') ?>%"></div>
                </div>
                <div style="font-size: 0.75rem; text-align: right; margin-bottom: 1rem; color: var(--gray-700);">
                    <?= $p['status'] == 'Completed' ? '100' : ($p['status'] == 'In-Progress' ? '45' : '0') ?>% Work Done
                </div>

                <div class="project-meta">
                    <div class="meta-item">
                        <span class="meta-label">ALLOCATED BUDGET</span>
                        <span class="meta-value">₹<?= number_format($p['budget']) ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">WARD NO</span>
                        <span class="meta-value">Ward <?= $p['ward_no'] ?></span>
                    </div>
                    <div class="meta-item" style="margin-top: 10px;">
                        <span class="meta-label">START DATE</span>
                        <span class="meta-value"><?= date('M Y', strtotime($p['start_date'])) ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>
