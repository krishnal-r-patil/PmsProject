<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Democracy Hub - Citizen Voice</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --accent: #10b981; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }
        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        header { background: white; padding: 1rem 2.5rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 90; }
        .content-padding { padding: 3rem; }

        .democracy-layout { display: grid; grid-template-columns: 1.3fr 0.7fr; gap: 2.5rem; }
        .hero-banner { background: linear-gradient(135deg, var(--primary), #1e40af); color: white; padding: 2.5rem; border-radius: 30px; margin-bottom: 2.5rem; display: flex; align-items: center; justify-content: space-between; }
        
        .card { background: white; border-radius: 28px; padding: 2.5rem; border: 1px solid #e2e8f0; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.03); }
        
        .poll-card { background: white; border-radius: 24px; padding: 2rem; margin-bottom: 2rem; border: 1px solid #eef2f6; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); }
        .poll-option { display: block; background: #f8fafc; padding: 1.3rem; border-radius: 16px; margin-top: 12px; border: 2px solid transparent; cursor: pointer; transition: 0.3s; position: relative; }
        .poll-option:hover { border-color: var(--primary); background: #eff6ff; }
        .poll-option input { display: none; }
        .poll-option.selected { border-color: var(--primary); background: #eff6ff; }
        .poll-option.selected::after { content: '\f058'; font-family: 'Font Awesome 6 Free'; font-weight: 900; position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: var(--primary); font-size: 1.2rem; }

        .suggestion-form { background: white; border-radius: 28px; padding: 2rem; border: 1px solid #e2e8f0; }
        .form-control { width: 100%; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 14px; outline: none; margin-bottom: 1.2rem; font-family: inherit; }
        .btn-action { width: 100%; padding: 1.2rem; background: var(--dark); color: white; border: none; border-radius: 14px; font-weight: 700; cursor: pointer; transition: 0.3s; }
        .btn-action:hover { background: var(--accent); transform: translateY(-2px); }

        .my-suggestion { background: white; padding: 1.5rem; border-radius: 20px; border: 1px solid #e2e8f0; margin-bottom: 1.2rem; position: relative; }
        .status-pill { font-size: 0.65rem; font-weight: 800; padding: 4px 10px; border-radius: 50px; text-transform: uppercase; float: right; }
        .status-Pending { background: #fff7ed; color: #c2410c; }
        .status-Reviewed { background: #eff6ff; color: #1d4ed8; }
        .status-Implemented { background: #f0fdf4; color: #15803d; }
        
        .admin-reply { background: #f8fafc; padding: 1rem; border-radius: 12px; margin-top: 1rem; border-left: 4px solid var(--accent); font-size: 0.85rem; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800; font-size: 1.1rem;"><i class="fas fa-check-to-slot" style="color: var(--primary); margin-right: 10px;"></i> Direct Democracy Portal</div>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span style="font-size: 0.85rem; color: #64748b; font-weight: 600;"><i class="fas fa-signal" style="color: var(--accent);"></i> Real-time Participation Active</span>
                <div style="width: 35px; height: 35px; background: #eef2f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800;"><?= substr(session()->get('user_name'), 0, 1) ?></div>
            </div>
        </header>

        <div class="content-padding">
            <div class="hero-banner">
                <div style="max-width: 60%;">
                    <h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 0.5rem;">The Vibe of the Village</h1>
                    <p style="opacity: 0.9; font-weight: 500;">Directly influence village development. Your vote decide our priorities, or submit a new idea for a better community.</p>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 2.5rem; font-weight: 800;"><?= $accountability_score ?>%</div>
                    <div style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; opacity: 0.9;">Panchayat Accountability</div>
                    <div style="font-size: 0.75rem; margin-top: 5px; opacity: 0.7;">Based on <?= $total_ideas ?> Community Ideas Shared</div>
                </div>
            </div>

            <div class="democracy-layout">
                <!-- POLLS -->
                <div>
                    <h2 style="font-weight: 800; margin-bottom: 1.5rem; font-size: 1.5rem;"><i class="fas fa-person-circle-check"></i> Active Development Polls</h2>
                    
                    <?php if(empty($polls)): ?>
                        <div class="poll-card" style="text-align:center; padding: 4rem;">
                            <i class="fas fa-box-open" style="font-size: 3rem; color: var(--gray-200); margin-bottom: 1rem;"></i>
                            <h3 style="color: #64748b;">No active polls right now. Check back soon!</h3>
                        </div>
                    <?php endif; ?>

                    <?php foreach($polls as $poll): ?>
                    <div class="poll-card">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem;">
                            <h3 style="font-weight: 800; font-size: 1.3rem; color: var(--dark); max-width: 80%;"><?= esc($poll['question']) ?></h3>
                            <span style="background: #f1f5f9; padding: 5px 12px; border-radius: 8px; font-size: 0.7rem; font-weight: 800; color: #64748b;">POLL #<?= $poll['id'] ?></span>
                        </div>
                        
                        <?php if($poll['has_voted']): ?>
                            <div style="background: #ecfdf5; border: 1px solid #bbf7d0; padding: 1.5rem; border-radius: 20px; display: flex; align-items: center; gap: 15px;">
                                <i class="fas fa-check-circle" style="color: var(--accent); font-size: 2rem;"></i>
                                <div>
                                    <div style="font-weight: 800; color: #065f46;">VOTE RECORDED</div>
                                    <div style="font-size: 0.85rem; color: #059669;">Your priority has been sent to the Gram Panchayat council. Results await conclusion.</div>
                                </div>
                            </div>
                        <?php else: ?>
                            <form action="<?= base_url('user/democracy/poll/vote/'.$poll['id']) ?>" method="POST">
                                <?= csrf_field() ?>
                                <?php foreach($poll['options'] as $idx => $opt): ?>
                                <label class="poll-option" onclick="selectOpt(this)">
                                    <input type="radio" name="option_index" value="<?= $idx ?>" required>
                                    <span style="font-weight: 700;"><?= esc($opt) ?></span>
                                </label>
                                <?php endforeach; ?>
                                <button type="submit" class="btn-action" style="background: var(--primary); margin-top: 1.5rem;">Confirm My Priority</button>
                            </form>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- SUGGESTIONS -->
                <div>
                    <h2 style="font-weight: 800; margin-bottom: 1.5rem; font-size: 1.5rem;"><i class="fas fa-lightbulb"></i> Share Your Idea</h2>
                    
                    <div class="suggestion-form">
                        <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 2rem; font-weight: 600;">Have a suggestion for a new park, road improvement, or social activity? Tell us!</p>
                        
                        <form action="<?= base_url('user/democracy/suggestion/save') ?>" method="POST">
                            <?= csrf_field() ?>
                            <input type="text" name="title" placeholder="Idea summary (e.g. Village Fair)" class="form-control" required style="font-weight: 800;">
                            <textarea name="content" rows="6" placeholder="Describe your idea in detail... how will it benefit the village?" class="form-control" required></textarea>
                            <button type="submit" class="btn-action">Submit to Council</button>
                        </form>
                    </div>

                    <div style="margin-top: 3rem;">
                        <h3 style="font-weight: 800; font-size: 1.1rem; margin-bottom: 1.5rem;">My Contribution History</h3>
                        
                        <?php if(empty($my_suggestions)): ?>
                            <p style="text-align: center; color: #94a3b8; font-size: 0.9rem; padding: 2rem;">You haven't submitted any ideas yet.</p>
                        <?php endif; ?>

                        <?php foreach($my_suggestions as $s): ?>
                        <div class="my-suggestion">
                            <span class="status-pill status-<?= $s['status'] ?>"><?= $s['status'] ?></span>
                            <h4 style="font-weight: 800; font-size: 0.95rem; margin-bottom: 5px; color: var(--dark);"><?= esc($s['title']) ?></h4>
                            <div style="font-size: 0.75rem; color: #94a3b8; margin-bottom: 10px;"><?= date('d M, Y', strtotime($s['created_at'])) ?></div>
                            <p style="font-size: 0.85rem; color: #64748b; line-height: 1.5;"><?= esc($s['content']) ?></p>
                            
                            <?php if(!empty($s['admin_note'])): ?>
                                <div class="admin-reply">
                                    <div style="font-weight: 800; color: var(--dark); font-size: 0.7rem; margin-bottom: 4px; text-transform: uppercase;"><i class="fas fa-reply"></i> Official Response</div>
                                    <?= esc($s['admin_note']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function selectOpt(el) {
            document.querySelectorAll('.poll-option').forEach(opt => opt.classList.remove('selected'));
            el.classList.add('selected');
        }
        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Action Recorded', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#2563eb', borderRadius: '30px' });
        <?php endif; ?>
    </script>
</body>
</html>
