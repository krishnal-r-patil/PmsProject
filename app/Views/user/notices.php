<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Village Notice Board - Citizen Portal</title>
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

        .page-header { margin-bottom: 2.5rem; border-bottom: 2px solid var(--gray-200); padding-bottom: 1.5rem; }
        
        .notice-container { display: flex; flex-direction: column; gap: 1.5rem; max-width: 900px; }
        .notice-card { background: white; border-radius: 20px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #e2e8f0; position: relative; border-left: 6px solid var(--primary); }
        
        .type-badge { position: absolute; top: 2rem; right: 2rem; padding: 5px 15px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; }
        .type-Notice { background: #eff6ff; color: #2563eb; }
        .type-Tender { background: #fffbeb; color: #d97706; }
        .type-News { background: #f0fdf4; color: #16a34a; }

        .notice-title { font-size: 1.5rem; font-weight: 800; color: var(--dark); margin-bottom: 1rem; line-height: 1.4; }
        .notice-content { color: #475569; font-size: 1.05rem; line-height: 1.7; margin-bottom: 2rem; white-space: pre-line; }

        .meta-footer { display: flex; align-items: center; gap: 2rem; border-top: 1px solid #f1f5f9; padding-top: 1.5rem; color: #94a3b8; font-size: 0.9rem; font-weight: 600; }
        .meta-item { display: flex; align-items: center; gap: 8px; }
        .meta-item i { color: var(--primary); font-size: 1.1rem; }

        .empty-state { text-align: center; padding: 5rem 2rem; background: white; border-radius: 30px; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800;"><i class="fas fa-bullhorn" style="color: var(--primary);"></i> Village Digital Notice Board</div>
            <div style="font-size: 0.85rem; color: #64748b;">Official announcements for residents of <?= session()->get('village') ?? 'Gram Panchayat' ?></div>
        </header>

        <div class="content-padding">
            <div class="page-header">
                <h1 style="font-size: 2.2rem; font-weight: 800; color: var(--dark);">Announcements & Tenders</h1>
                <p style="color: #64748b; font-size: 1.1rem;">Stay informed about local governance and upcoming development projects.</p>
            </div>

            <?php if(empty($notices)): ?>
                <div class="empty-state">
                    <img src="https://illustrations.popsy.co/gray/notifications.svg" alt="No Notices" style="width: 250px; margin-bottom: 2rem;">
                    <h2 style="color: var(--dark);">All caught up!</h2>
                    <p style="color: #64748b;">There are no active notices or tenders at the moment. Please check back later.</p>
                </div>
            <?php else: ?>
                <div class="notice-container">
                    <?php foreach($notices as $n): ?>
                        <div class="notice-card">
                            <span class="type-badge type-<?= $n['type'] ?>"><?= $n['type'] ?></span>
                            <h2 class="notice-title"><?= esc($n['title']) ?></h2>
                            <p class="notice-content"><?= esc($n['content']) ?></p>

                            <div class="meta-footer">
                                <div class="meta-item">
                                    <i class="far fa-calendar-check"></i> Published on: <?= date('d M, Y', strtotime($n['created_at'])) ?>
                                </div>
                                <?php if($n['expiry_date']): ?>
                                    <div class="meta-item">
                                        <i class="far fa-calendar-times"></i> Valid until: <?= date('d M, Y', strtotime($n['expiry_date'])) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
