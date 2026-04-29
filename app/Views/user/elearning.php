<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning & Skills – E-Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #2563eb; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }
        .sidebar { width: 260px; background: var(--dark); height: 100vh; position: fixed; padding: 1.5rem; color: white; }
        .main-content { margin-left: 260px; width: calc(100% - 260px); min-height: 100vh; }
        header { background: white; padding: 1.5rem 2.5rem; border-bottom: 1px solid var(--gray-200); }
        .content-padding { padding: 2.5rem; }
        .hero { background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); color: white; padding: 3rem; border-radius: 30px; margin-bottom: 2.5rem; position: relative; overflow: hidden; }
        .hero h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem; }
        .resource-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem; }
        .resource-card { background: white; border-radius: 24px; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid var(--gray-200); transition: all 0.3s; display: flex; flex-direction: column; }
        .resource-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .category-tag { display: inline-block; padding: 6px 12px; border-radius: 10px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; margin-bottom: 1rem; width: fit-content; }
        .tag-Scholarship { background: #dcfce7; color: #166534; }
        .tag-Course { background: #eff6ff; color: #1d4ed8; }
        .tag-PMKVY { background: #fee2e2; color: #991b1b; }
        .res-title { font-size: 1.3rem; font-weight: 800; color: var(--dark); margin-bottom: 0.75rem; line-height: 1.3; }
        .res-provider { font-size: 0.85rem; color: var(--primary); font-weight: 700; margin-bottom: 1rem; }
        .res-desc { color: #64748b; font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem; flex: 1; }
        .res-footer { border-top: 1px solid var(--gray-100); padding-top: 1.25rem; display: flex; justify-content: space-between; align-items: center; }
        .deadline { font-size: 0.75rem; color: #94a3b8; font-weight: 600; }
        .btn-apply { background: var(--primary); color: white; padding: 0.7rem 1.4rem; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 0.85rem; transition: background 0.2s; }
        .btn-apply:hover { background: #1d4ed8; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>
    <div class="main-content">
        <header>
            <div style="font-weight: 800; font-size: 1.1rem; color: var(--dark);"><i class="fas fa-graduation-cap" style="color: var(--primary); margin-right: 8px;"></i> E-Learning & Skill Hub</div>
        </header>
        <div class="content-padding">
            <div class="hero">
                <h1>Future Ready Village</h1>
                <p>Unlock your potential with specialized training, scholarships, and world-class courses.</p>
                <div style="position: absolute; right: 50px; bottom: -20px; font-size: 8rem; opacity: 0.1; color: white;"><i class="fas fa-book-open"></i></div>
            </div>

            <div class="resource-grid">
                <?php foreach($resources as $r): ?>
                <div class="resource-card">
                    <div class="category-tag tag-<?= strpos($r['category'], 'Course') !== false ? 'Course' : $r['category'] ?>"><?= $r['category'] ?></div>
                    <h2 class="res-title"><?= esc($r['title']) ?></h2>
                    <div class="res-provider">by <?= esc($r['provider']) ?></div>
                    <p class="res-desc"><?= esc($r['description']) ?></p>
                    <div class="res-footer">
                        <div class="deadline">
                            <i class="far fa-calendar-alt"></i> 
                            <?= $r['deadline'] ? 'Deadline: '.date('d M Y', strtotime($r['deadline'])) : 'Always Open' ?>
                        </div>
                        <a href="<?= $r['link'] ?: '#' ?>" target="_blank" class="btn-apply">
                            <?= strpos($r['category'], 'Course') !== false ? 'Join Course' : 'Apply Now' ?> 
                            <i class="fas fa-external-link-alt" style="font-size: 0.7rem; margin-left: 5px;"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
