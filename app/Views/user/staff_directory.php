<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panchayat Staff Directory – E-Panchayat</title>
    <meta name="description" content="View all Gram Panchayat staff members, their designations, departments, and contact information.">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #2563eb;
            --dark: #0f172a;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-600: #475569;
            --gray-700: #334155;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; min-height: 100vh; }

        .sidebar { width: var(--sidebar-width); background: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; display: flex; flex-direction: column; }

        /* Hero Header */
        .hero-banner {
            background: linear-gradient(135deg, var(--dark) 0%, #1e3a8a 50%, #1d4ed8 100%);
            padding: 3rem 2.5rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .hero-banner::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 300px; height: 300px;
            background: rgba(255,255,255,0.03);
            border-radius: 50%;
        }
        .hero-banner::after {
            content: '';
            position: absolute;
            bottom: -80px; left: 40%;
            width: 200px; height: 200px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }
        .hero-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); padding: 6px 16px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem; }
        .hero-banner h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem; }
        .hero-banner p { color: rgba(255,255,255,0.7); font-size: 1.05rem; }
        .hero-stats { display: flex; gap: 2.5rem; margin-top: 2rem; }
        .hero-stat-val { font-size: 2rem; font-weight: 800; }
        .hero-stat-lbl { font-size: 0.8rem; color: rgba(255,255,255,0.6); font-weight: 600; text-transform: uppercase; }

        /* Filter/Search */
        .search-section { background: white; padding: 1.5rem 2.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.06); display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; }
        .search-wrap { position: relative; flex: 1; min-width: 250px; }
        .search-wrap input { width: 100%; padding: 0.8rem 1rem 0.8rem 2.75rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 0.94rem; font-family: 'Outfit', sans-serif; outline: none; transition: all 0.2s; }
        .search-wrap input:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(37,99,235,0.08); }
        .search-wrap i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--gray-400); }
        .filter-select { padding: 0.8rem 1rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 0.9rem; font-family: 'Outfit', sans-serif; outline: none; transition: border-color 0.2s; color: var(--dark); }
        .filter-select:focus { border-color: var(--primary); }

        /* Content */
        .content-area { padding: 2rem 2.5rem; flex: 1; }

        /* Department section separators */
        .dept-header { display: flex; align-items: center; gap: 12px; margin: 2.5rem 0 1.25rem; }
        .dept-header h2 { font-size: 1rem; font-weight: 800; color: var(--gray-600); text-transform: uppercase; letter-spacing: 1px; white-space: nowrap; }
        .dept-header::after { content: ''; flex: 1; height: 1px; background: var(--gray-200); }

        /* Staff Cards */
        .staff-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.25rem; }

        .staff-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            border: 1px solid var(--gray-200);
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .staff-card:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0,0,0,0.09); border-color: rgba(37,99,235,0.2); }

        .card-top { display: flex; align-items: center; gap: 1rem; }
        .avatar { width: 58px; height: 58px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; color: white; flex-shrink: 0; }
        .s-name { font-size: 1rem; font-weight: 800; color: var(--dark); }
        .s-desig { font-size: 0.78rem; color: var(--primary); font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; margin-top: 2px; }

        .contact-strip { background: var(--gray-50); border-radius: 12px; padding: 0.9rem 1rem; display: flex; flex-direction: column; gap: 0.5rem; }
        .contact-row { display: flex; align-items: center; gap: 8px; font-size: 0.875rem; color: var(--gray-600); }
        .contact-row i { width: 18px; color: var(--primary); text-align: center; }

        .ward-chip { display: inline-flex; align-items: center; gap: 6px; color: var(--primary); background: #eff6ff; border-radius: 8px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700; }

        .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 10px; font-size: 0.75rem; font-weight: 700; }
        .status-badge.active   { background: #dcfce7; color: #166534; }
        .status-badge.leave    { background: #fef3c7; color: #92400e; }
        .status-badge.retired  { background: #f1f5f9; color: #64748b; }
        .badge-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

        .empty-state { text-align: center; padding: 5rem 2rem; grid-column: 1/-1; }
        .empty-state i { font-size: 4rem; color: var(--gray-200); display: block; margin-bottom: 1.5rem; }
    </style>
</head>
<body>
<div class="sidebar"><?= view('user/partials/sidebar') ?></div>

<div class="main-content">
    <!-- Hero Banner -->
    <div class="hero-banner">
        <div class="hero-badge"><i class="fas fa-shield-halved"></i> Official Directory – Gram Panchayat</div>
        <h1><i class="fas fa-id-badge" style="margin-right:12px;"></i>Panchayat Staff Directory</h1>
        <p>Know your village representatives and how to reach them for any assistance.</p>

        <?php
            $total  = count($staff);
            $active = count(array_filter($staff, fn($s) => $s['status'] === 'Active'));
        ?>
        <div class="hero-stats">
            <div>
                <div class="hero-stat-val"><?= $total ?></div>
                <div class="hero-stat-lbl">Total Employees</div>
            </div>
            <div>
                <div class="hero-stat-val"><?= $active ?></div>
                <div class="hero-stat-lbl">Currently Active</div>
            </div>
            <div>
                <?php $depts = count(array_unique(array_column($staff, 'department'))); ?>
                <div class="hero-stat-val"><?= $depts ?></div>
                <div class="hero-stat-lbl">Departments</div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="search-section">
        <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search by name or designation..." onkeyup="filterCards()">
        </div>
        <select class="filter-select" id="filterDept" onchange="filterCards()">
            <option value="">All Departments</option>
            <?php
                $allDepts = array_unique(array_column($staff, 'department'));
                foreach($allDepts as $d): ?>
                <option><?= esc($d) ?></option>
            <?php endforeach; ?>
        </select>
        <select class="filter-select" id="filterStatus" onchange="filterCards()">
            <option value="">All Status</option>
            <option>Active</option>
            <option>On Leave</option>
            <option>Retired</option>
        </select>
    </div>

    <div class="content-area">
        <?php if(empty($staff)): ?>
            <div class="staff-grid">
                <div class="empty-state">
                    <i class="fas fa-users-slash"></i>
                    <h3 style="color:var(--gray-400);">No staff information is available at this time.</h3>
                    <p style="color:var(--gray-400); margin-top:8px;">Please check back later or contact the Panchayat office directly.</p>
                </div>
            </div>
        <?php else: ?>
            <?php
                $avatarColors = ['#6366f1','#8b5cf6','#ec4899','#14b8a6','#f59e0b','#10b981','#3b82f6','#ef4444'];
                $i = 0;
            ?>
            <div class="staff-grid" id="staffGrid">
                <?php foreach($staff as $s):
                    $color = $avatarColors[$i % count($avatarColors)]; $i++;
                    $statusClass = $s['status'] === 'Active' ? 'active' : ($s['status'] === 'On Leave' ? 'leave' : 'retired');
                ?>
                <div class="staff-card"
                     data-name="<?= strtolower($s['name']) ?> <?= strtolower($s['designation']) ?>"
                     data-dept="<?= $s['department'] ?>"
                     data-status="<?= $s['status'] ?>">

                    <div class="card-top">
                        <div class="avatar" style="background: <?= $color ?>;">
                            <?= strtoupper(substr($s['name'], 0, 1)) ?>
                        </div>
                        <div>
                            <div class="s-name"><?= esc($s['name']) ?></div>
                            <div class="s-desig"><?= esc($s['designation']) ?></div>
                        </div>
                    </div>

                    <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                        <span style="background:var(--gray-100); color:var(--gray-600); font-size:0.72rem; font-weight:700; padding:4px 10px; border-radius:8px; text-transform:uppercase;">
                            <i class="fas fa-building" style="margin-right:4px;"></i><?= esc($s['department']) ?>
                        </span>
                        <?php if(!empty($s['ward_no'])): ?>
                            <span class="ward-chip"><i class="fas fa-map-marker-alt"></i> Ward <?= esc($s['ward_no']) ?></span>
                        <?php endif; ?>
                        <span class="status-badge <?= $statusClass ?>">
                            <span class="badge-dot"></span><?= esc($s['status']) ?>
                        </span>
                    </div>

                    <div class="contact-strip">
                        <div class="contact-row"><i class="fas fa-phone-alt"></i> <?= esc($s['phone']) ?></div>
                        <?php if(!empty($s['email'])): ?>
                            <div class="contact-row"><i class="fas fa-envelope"></i> <?= esc($s['email']) ?></div>
                        <?php endif; ?>
                        <div class="contact-row"><i class="fas fa-calendar-check"></i> Serving since <?= date('M Y', strtotime($s['joining_date'])) ?></div>
                        <?php if(!empty($s['address'])): ?>
                            <div class="contact-row"><i class="fas fa-house-user"></i> <?= esc($s['address']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function filterCards() {
    const q      = document.getElementById('searchInput').value.toLowerCase();
    const dept   = document.getElementById('filterDept').value;
    const status = document.getElementById('filterStatus').value;
    document.querySelectorAll('.staff-card').forEach(card => {
        const ok = card.dataset.name.includes(q)
            && (!dept   || card.dataset.dept   === dept)
            && (!status || card.dataset.status === status);
        card.style.display = ok ? '' : 'none';
    });
}
</script>
</body>
</html>
