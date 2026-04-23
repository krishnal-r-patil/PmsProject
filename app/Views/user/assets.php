<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panchayat Asset Inventory - E-Panchayat</title>
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

        .asset-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem; }
        .asset-card { background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        
        .asset-head { display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem; }
        .asset-icon-box { width: 50px; height: 50px; border-radius: 12px; background: #eff6ff; color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
        
        .status-pill { padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }
        .status-Functional { background: #dcfce7; color: #166534; }
        .status-Needs-Repair { background: #fef9c3; color: #854d0e; }
        .status-Dilapidated { background: #fee2e2; color: #991b1b; }

        .asset-title { font-size: 1.2rem; font-weight: 800; color: var(--dark); margin-bottom: 0.25rem; }
        .asset-cat { font-size: 0.75rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }

        .detail-row { display: flex; justify-content: space-between; border-top: 1px solid #f1f5f9; padding-top: 0.75rem; margin-top: 1rem; }
        .detail-label { font-size: 0.75rem; color: #94a3b8; font-weight: 700; }
        .detail-val { font-size: 0.9rem; font-weight: 700; color: var(--dark); }

        .empty-state { text-align: center; padding: 6rem 2rem; grid-column: 1/-1; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800;"><i class="fas fa-city" style="color: var(--primary);"></i> Village Resource Inventory</div>
            <div style="font-size: 0.85rem; color: #64748b;">Public assets and community property.</div>
        </header>

        <div class="content-padding">
            <div style="margin-bottom: 2.5rem;">
                <h1 style="font-size: 2.2rem; font-weight: 800; color: var(--dark);">Panchayat Asset Inventory</h1>
                <p style="color: #64748b; font-size: 1.1rem;">A transparent record of all village-owned property to promote public accountability.</p>
            </div>

            <div class="asset-grid">
                <?php if(empty($assets)): ?>
                    <div class="empty-state">
                        <i class="fas fa-boxes-stacked" style="font-size: 4rem; color: #e2e8f0; margin-bottom: 1.5rem;"></i>
                        <h2 style="color: #94a3b8;">No public assets have been registered in the digital registry yet.</h2>
                    </div>
                <?php else: ?>
                    <?php foreach($assets as $a): 
                        $icon = 'cube';
                        if($a['asset_type'] == 'Building') $icon = 'building';
                        if($a['asset_type'] == 'Vehicle') $icon = 'truck-pickup';
                        if($a['asset_type'] == 'Land') $icon = 'mountain';
                        if($a['asset_type'] == 'Water Body') $icon = 'water';
                        if($a['asset_type'] == 'Equipment') $icon = 'tools';
                    ?>
                    <div class="asset-card">
                        <div class="asset-head">
                            <div class="asset-icon-box"><i class="fas fa-<?= $icon ?>"></i></div>
                            <span class="status-pill status-<?= str_replace(' ', '-', $a['current_status']) ?>">
                                <?= $a['current_status'] ?>
                            </span>
                        </div>
                        <div class="asset-cat"><?= esc($a['asset_type']) ?></div>
                        <h3 class="asset-title"><?= esc($a['asset_name']) ?></h3>
                        <p style="font-size: 0.85rem; color: #64748b; margin-top: 5px;"><i class="fas fa-location-dot"></i> <?= esc($a['location']) ?></p>

                        <div class="detail-row">
                            <span class="detail-label">Asset Valuation</span>
                            <span class="detail-val">₹<?= number_format($a['cost'], 2) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Asset ID</span>
                            <span class="detail-val">#AST-<?= $a['id'] ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
