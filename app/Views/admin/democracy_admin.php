<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Democracy Control Panel - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #6366f1; --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }
        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        header { background: white; padding: 1.2rem 2.5rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 90; }
        .content-padding { padding: 2.5rem; }

        .dashboard-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem; }
        .vibe-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2.5rem; }
        .vibe-card { background: white; padding: 1.5rem; border-radius: 20px; border: 1px solid var(--gray-200); display: flex; align-items: center; gap: 1.2rem; }
        .vibe-icon { width: 55px; height: 55px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }

        .democracy-grid { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 2rem; }
        .card { background: white; border-radius: 28px; padding: 2rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        
        .poll-card { background: #f8fafc; padding: 2rem; border-radius: 24px; margin-bottom: 1.5rem; border: 1px solid #eef2f6; position: relative; overflow: hidden; }
        .poll-card::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 6px; background: var(--primary); }
        .poll-opt { margin-bottom: 1rem; }
        .progress-container { height: 12px; background: #e2e8f0; border-radius: 20px; overflow: hidden; margin-top: 6px; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, var(--primary), #818cf8); transition: 1s ease-in-out; }

        .suggestion-item { background: white; border-radius: 20px; padding: 1.5rem; border: 1px solid #f1f5f9; margin-bottom: 1rem; transition: 0.3s; cursor: pointer; }
        .suggestion-item:hover { border-color: var(--primary); transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }
        .status-badge { padding: 4px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }
        .status-Pending { background: #fffbeb; color: #d97706; }
        .status-Reviewed { background: #eff6ff; color: #2563eb; }
        .status-Implemented { background: #f0fdf4; color: #166534; }

        .btn-prime { background: var(--dark); color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; }
        .btn-ghost { background: #f1f5f9; color: #475569; border: none; padding: 0.6rem 1rem; border-radius: 10px; font-weight: 700; cursor: pointer; }

        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px); }
        .modal { background: white; width: 550px; border-radius: 32px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); animation: slideUp 0.3s ease; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800; font-size: 1.1rem; color: var(--dark);"><i class="fas fa-landmark" style="color: var(--primary); margin-right: 10px;"></i> Democracy Control Panel</div>
            <div style="background: #eef2f6; padding: 6px 15px; border-radius: 50px; font-size: 0.75rem; font-weight: 800; color: #475569;">
                <i class="fas fa-users-viewfinder"></i> Citizen Prioritization Active
            </div>
        </header>

        <div class="content-padding">
            <div class="dashboard-header">
                <div>
                    <h1 style="font-size: 2.5rem; font-weight: 800;">Village Decision Hub</h1>
                    <p style="color: #64748b; font-size: 1.05rem;">Manage polls and respond to direct citizen suggestions.</p>
                </div>
                <button class="btn-prime" onclick="openPollModal()"><i class="fas fa-plus-circle"></i> Create Governance Poll</button>
            </div>

            <div class="vibe-stats">
                <div class="vibe-card">
                    <div class="vibe-icon" style="background: #eff6ff; color: var(--primary);"><i class="fas fa-hand-holding-heart"></i></div>
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Accountability Score</div>
                        <div style="font-size: 1.5rem; font-weight: 800;"><?= $accountability_score ?>% Response Rate</div>
                    </div>
                </div>
                <div class="vibe-card">
                    <div class="vibe-icon" style="background: #fff1f2; color: var(--danger);"><i class="fas fa-hourglass-half"></i></div>
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Attention Required</div>
                        <div style="font-size: 1.5rem; font-weight: 800;"><?= $pending_ideas ?> Pending Ideas</div>
                    </div>
                </div>
                <div class="vibe-card">
                    <div class="vibe-icon" style="background: #ecfdf5; color: var(--success);"><i class="fas fa-check-double"></i></div>
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Ideas Implemented</div>
                        <div style="font-size: 1.5rem; font-weight: 800;"><?= count(array_filter($suggestions, fn($s) => $s['status'] == 'Implemented')) ?> Successes</div>
                    </div>
                </div>
            </div>

            <div class="democracy-grid">
                <!-- POLL ANALYTICS -->
                <div class="card">
                    <div class="card-header">
                        <h2 style="font-weight: 800; font-size: 1.4rem;">Live Priority Polls</h2>
                    </div>

                    <?php if(empty($polls)): ?>
                        <div style="text-align:center; padding: 4rem; color: #94a3b8;">
                            <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                            <p>No active polls. Launch one to gather citizen feedback.</p>
                        </div>
                    <?php endif; ?>

                    <?php foreach($polls as $p): 
                        $totalVotes = count($p['votes']) ?: 1;
                        $voteCounts = array_count_values(array_column($p['votes'], 'option_index'));
                    ?>
                    <div class="poll-card">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem;">
                            <h3 style="font-weight: 800; font-size: 1.25rem; color: var(--dark);"><?= esc($p['question']) ?></h3>
                            <button onclick="askConfirm('<?= base_url('admin/democracy/poll/delete/'.$p['id']) ?>', 'Remove this poll? All citizen votes will be permanently lost.')" style="background:none; border:none; color: var(--danger); cursor:pointer;"><i class="fas fa-trash-alt"></i></button>
                        </div>

                        <?php foreach($p['options'] as $idx => $opt): 
                            $count = $voteCounts[$idx] ?? 0;
                            $pct = ($count / $totalVotes) * 100;
                        ?>
                        <div class="poll-opt">
                            <div style="display: flex; justify-content: space-between; font-size: 0.9rem; font-weight: 700; color: #475569;">
                                <span><?= esc($opt) ?></span>
                                <span><?= round($pct) ?>% (<?= $count ?>)</span>
                            </div>
                            <div class="progress-container">
                                <div class="progress-fill" style="width: <?= $pct ?>%"></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                        <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #eef2f6; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 0.75rem; font-weight: 700; color: #94a3b8;"><i class="fas fa-history"></i> Updated just now</span>
                            <span style="font-size: 0.75rem; font-weight: 800; color: var(--primary); background: #eff6ff; padding: 4px 10px; border-radius: 5px;">Total: <?= count($p['votes']) ?> Votes</span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- SUGGESTIONS FEED -->
                <div>
                    <div class="card" style="padding: 1.5rem;">
                        <div class="card-header" style="margin-bottom: 1.5rem;">
                            <h2 style="font-weight: 800; font-size: 1.3rem;">Citizen Voice Feed</h2>
                        </div>

                        <div style="max-height: 800px; overflow-y: auto; padding-right: 5px;">
                            <?php if(empty($suggestions)): ?>
                                <div style="text-align:center; padding: 4rem; color: #94a3b8;">No entries in suggestion box.</div>
                            <?php endif; ?>

                            <?php foreach($suggestions as $s): ?>
                            <div class="suggestion-item" onclick='reviewSuggestion(<?= json_encode($s) ?>)'>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <h4 style="font-weight: 800; color: var(--dark);"><?= esc($s['title']) ?></h4>
                                    <span class="status-badge status-<?= $s['status'] ?>"><?= $s['status'] ?></span>
                                </div>
                                <p style="font-size: 0.85rem; color: #64748b; line-height: 1.5; margin-bottom: 12px;"><?= substr(esc($s['content']), 0, 120) ?>...</p>
                                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem;">
                                    <span style="font-weight: 700; color: #475569;"><i class="fas fa-user-circle"></i> <?= esc($s['citizen_name']) ?></span>
                                    <span style="color: #94a3b8;"><?= date('d M, Y', strtotime($s['created_at'])) ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Poll Modal -->
    <div class="modal-overlay" id="pollModal">
        <div class="modal">
            <div style="padding: 1.5rem 2.5rem; background: #f8fafc; border-bottom: 1px solid #eef2f6; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-weight: 800;">Launch Priority Poll</h3>
                <button onclick="closePollModal()" style="border:none; background:none; font-size: 1.5rem; cursor:pointer;">&times;</button>
            </div>
            <form action="<?= base_url('admin/democracy/poll/save') ?>" method="POST" style="padding: 2.5rem;">
                <?= csrf_field() ?>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display:block; font-size:0.8rem; font-weight:800; color:#64748b; margin-bottom:8px;">POLL QUESTION *</label>
                    <input type="text" name="question" placeholder="e.g. Which park should we renovate first?" required style="width:100%; padding:1rem; border:1px solid #e2e8f0; border-radius:15px; outline:none; font-weight:600;">
                </div>
                <div style="margin-bottom: 2rem;">
                    <label style="display:block; font-size:0.8rem; font-weight:800; color:#64748b; margin-bottom:8px;">OPTIONS (One per line) *</label>
                    <textarea name="options" rows="4" placeholder="Option A&#10;Option B&#10;Option C" required style="width:100%; padding:1rem; border:1px solid #e2e8f0; border-radius:15px; outline:none; font-family:inherit;"></textarea>
                </div>
                <button type="submit" class="btn-prime" style="width:100%; justify-content:center; height: 55px; font-size: 1.05rem;">Broadast to Citizens</button>
            </form>
        </div>
    </div>

    <!-- Review Modal -->
    <div class="modal-overlay" id="reviewModal">
        <div class="modal" style="width: 600px;">
            <div style="padding: 1.5rem 2.5rem; background: #f8fafc; border-bottom: 1px solid #eef2f6; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-weight: 800;">Review Citizen Idea</h3>
                <button onclick="closeReviewModal()" style="border:none; background:none; font-size: 1.5rem; cursor:pointer;">&times;</button>
            </div>
            <form action="<?= base_url('admin/democracy/suggestion/update') ?>" method="POST" style="padding: 2.5rem;">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="s_id">
                
                <div style="margin-bottom: 2rem;">
                    <div style="background: #f1f5f9; padding: 1.5rem; border-radius: 20px; margin-bottom: 1.5rem;">
                        <h4 id="s_title" style="font-weight: 800; color: var(--dark); margin-bottom: 10px;"></h4>
                        <p id="s_content" style="font-size: 0.95rem; color: #475569; line-height: 1.6;"></p>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="display:block; font-size:0.8rem; font-weight:800; color:#64748b; margin-bottom:8px;">SET STATUS</label>
                            <select name="status" id="s_status" style="width:100%; padding: 0.9rem; border: 1px solid #e2e8f0; border-radius: 12px; font-weight: 700;">
                                <option value="Pending">Pending</option>
                                <option value="Reviewed">Under Review</option>
                                <option value="Implemented">Implemented</option>
                            </select>
                        </div>
                        <div>
                            <label style="display:block; font-size:0.8rem; font-weight:800; color:#64748b; margin-bottom:8px;">CITIZEN INFO</label>
                            <div id="s_citizen" style="padding: 0.9rem; background: #f8fafc; border-radius: 12px; font-weight: 700; font-size: 0.9rem; color: var(--primary);"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="display:block; font-size:0.8rem; font-weight:800; color:#64748b; margin-bottom:8px;">ADMIN RESPONSE / NOTES</label>
                        <textarea name="admin_note" id="s_note" rows="3" placeholder="Write a response or implementation note for the citizen..."></textarea>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="button" onclick="closeReviewModal()" class="btn-ghost" style="flex: 1; height: 50px;">Cancel</button>
                    <button type="submit" class="btn-prime" style="flex: 1; justify-content: center; height: 50px;">Save & Notify</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openPollModal() { document.getElementById('pollModal').style.display = 'flex'; }
        function closePollModal() { document.getElementById('pollModal').style.display = 'none'; }
        
        function reviewSuggestion(s) {
            document.getElementById('s_id').value = s.id;
            document.getElementById('s_title').innerText = s.title;
            document.getElementById('s_content').innerText = s.content;
            document.getElementById('s_status').value = s.status;
            document.getElementById('s_note').value = s.admin_note || "";
            document.getElementById('s_citizen').innerText = s.citizen_name;
            document.getElementById('reviewModal').style.display = 'flex';
        }
        function closeReviewModal() { document.getElementById('reviewModal').style.display = 'none'; }

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Great!', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#6366f1', borderRadius: '25px' });
        <?php endif; ?>
    </script>
</body>
</html>
