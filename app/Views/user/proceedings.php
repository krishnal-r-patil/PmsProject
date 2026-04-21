<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Village Transparency Archive - Gram Sabha</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 280px; --primary: #2563eb; --accent: #10b981; --dark: #0f172a; --gray-50: #f8fafc; --gray-100: #f1f5f9; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-50); display: flex; }
        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        header { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); padding: 1rem 2.5rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 90; }
        .content-padding { padding: 3rem; }

        .hero-section { background: linear-gradient(135deg, #1e293b, #0f172a); color: white; padding: 3rem; border-radius: 40px; margin-bottom: 3rem; position: relative; overflow: hidden; }
        .hero-section::after { content: '\f19c'; font-family: 'Font Awesome 6 Free'; font-weight: 900; position: absolute; right: -20px; bottom: -40px; font-size: 15rem; opacity: 0.05; transform: rotate(-15deg); }
        .hero-section h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem; }
        .hero-section p { opacity: 0.8; font-size: 1.1rem; max-width: 600px; }

        /* PROCEEDINGS FEED */
        .archive-feed { display: grid; grid-template-columns: 1fr; gap: 2.5rem; }
        .archive-card { background: white; border-radius: 40px; padding: 3rem; border: 1px solid #e2e8f0; display: grid; grid-template-columns: 120px 1fr; align-items: start; gap: 3rem; transition: 0.4s; position: relative; }
        .archive-card:hover { transform: translateY(-8px); border-color: var(--primary); box-shadow: 0 30px 40px -15px rgba(0,0,0,0.08); }

        .date-badge { text-align: center; background: #f0f9ff; padding: 1.5rem; border-radius: 25px; border: 1px solid #e0f2fe; color: var(--primary); position: sticky; top: 120px; }
        .date-badge .month { display: block; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; margin-bottom: 2px; }
        .date-badge .day { display: block; font-size: 2.2rem; font-weight: 800; line-height: 1; }
        .date-badge .year { display: block; font-size: 0.9rem; font-weight: 600; opacity: 0.7; }

        .content-area h2 { font-size: 1.6rem; font-weight: 800; color: var(--dark); margin-bottom: 12px; }
        .content-area p { color: #64748b; font-size: 1.05rem; line-height: 1.7; }

        .action-area { text-align: right; }
        .btn-archive { background: var(--dark); color: white; padding: 1rem 1.5rem; border-radius: 16px; text-decoration: none; font-weight: 700; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 10px; transition: 0.3s; }
        .btn-archive:hover { background: var(--primary); transform: translateX(-5px); }

        .digital-tag { font-size: 0.75rem; font-weight: 800; color: #10b981; background: #f0fdf4; padding: 6px 14px; border-radius: 50px; display: inline-flex; align-items: center; gap: 5px; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800; font-size: 1.1rem;"><i class="fas fa-file-invoice" style="color: var(--primary); margin-right: 10px;"></i> Gram Sabha Transparency</div>
            <div style="font-size: 0.85rem; color: #64748b; font-weight: 600;"><i class="fas fa-shield-check" style="color: var(--accent);"></i> Authenticated Records</div>
        </header>

        <div class="content-padding">
            <div class="hero-section">
                <h1>Official Assembly Register</h1>
                <p>Browse the official proceedings, resolutions, and budget allocations discussed in the village Gram Sabha meetings.</p>
            </div>

            <?php if(empty($proceedings)): ?>
                <div style="text-align:center; padding: 8rem 0; background: white; border-radius: 40px; border: 2px dashed #e2e8f0;">
                    <i class="fas fa-box-archive" style="font-size: 4rem; color: #cbd5e1; margin-bottom: 1.5rem;"></i>
                    <h3 style="color: #64748b; font-weight: 700;">The digital archive is currently empty.</h3>
                </div>
            <?php endif; ?>

            <div class="archive-feed">
                <?php foreach($proceedings as $p): 
                    $date = strtotime($p['meeting_date']);
                ?>
                <div class="archive-card">
                    <div class="date-badge">
                        <span class="month"><?= date('M', $date) ?></span>
                        <span class="day"><?= date('d', $date) ?></span>
                        <span class="year"><?= date('Y', $date) ?></span>
                    </div>
                    
                    <div class="content-area">
                        <?php if($p['file_path']): 
                            $ext = strtolower(pathinfo($p['file_path'], PATHINFO_EXTENSION));
                            $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
                            
                            // Smart Pathing: Auto-detect if 'public/' prefix is needed
                            $fPath = $p['file_path'];
                            $finalPath = base_url($fPath);
                            if (strpos($_SERVER['REQUEST_URI'], '/public/') === false && strpos($finalPath, '/public/') === false) {
                                $finalPath = base_url('public/' . $fPath);
                            }
                        ?>
                            <?php if($isImg): ?>
                                <div style="width: 100%; height: 250px; border-radius: 25px; overflow: hidden; margin-bottom: 2rem; border: 1px solid #e2e8f0; position: relative;">
                                    <img src="<?= $finalPath ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Assembly Visual">
                                    <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(0deg, rgba(0,0,0,0.6) 0%, transparent 100%); padding: 1.5rem; color: white;">
                                        <div style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;"><i class="fas fa-camera"></i> Official Record Visual</div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <h2><?= esc($p['title']) ?></h2>
                        <div style="margin-bottom: 1.5rem;">
                            <p style="color: #475569; font-weight: 600; font-size: 1.1rem;"><?= esc($p['minutes']) ?></p>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 1.5rem;">
                            <?php if(!empty($p['agenda'])): ?>
                            <div style="background: #f8fafc; padding: 1.2rem; border-radius: 20px; border: 1px solid #eef2f6;">
                                <div style="font-size: 0.7rem; font-weight: 800; color: var(--primary); text-transform: uppercase; margin-bottom: 8px;"><i class="fas fa-list-ul"></i> Agenda Items</div>
                                <p style="font-size: 0.85rem; color: #64748b; line-height: 1.6;"><?= nl2br(esc($p['agenda'])) ?></p>
                            </div>
                            <?php endif; ?>

                            <?php if(!empty($p['attendees'])): ?>
                            <div style="background: #f8fafc; padding: 1.2rem; border-radius: 20px; border: 1px solid #eef2f6;">
                                <div style="font-size: 0.7rem; font-weight: 800; color: var(--primary); text-transform: uppercase; margin-bottom: 8px;"><i class="fas fa-users"></i> Key Attendees</div>
                                <p style="font-size: 0.85rem; color: #64748b; line-height: 1.6;"><?= nl2br(esc($p['attendees'])) ?></p>
                            </div>
                            <?php endif; ?>
                        </div>

                        <?php if(!empty($p['resolutions'])): ?>
                        <div style="background: #fffbeb; padding: 1.5rem; border-radius: 20px; border: 1px solid #fef3c7; margin-bottom: 1rem;">
                            <div style="font-size: 0.75rem; font-weight: 800; color: #d97706; text-transform: uppercase; margin-bottom: 10px;"><i class="fas fa-file-contract"></i> Formal Resolutions Passed</div>
                            <p style="font-size: 0.95rem; color: #92400e; font-weight: 600; line-height: 1.6;"><?= nl2br(esc($p['resolutions'])) ?></p>
                        </div>
                        <?php endif; ?>

                        <div style="margin-top: 2rem;">
                            <?php if($p['file_path']): ?>
                                <a href="<?= $finalPath ?>" target="_blank" class="btn-archive">
                                    <i class="fas <?= $isImg ? 'fa-eye' : 'fa-file-pdf' ?>"></i> <?= $isImg ? 'View Full Resolution' : 'Download Official Signed Document' ?>
                                </a>
                            <?php else: ?>
                                <div class="digital-tag"><i class="fas fa-check-circle"></i> Digitally Verified & Published</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
