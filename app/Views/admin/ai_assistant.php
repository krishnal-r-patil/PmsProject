<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Sahayak Control Hub - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 280px; --primary: #6366f1; --dark: #1e293b; --light: #f8fafc; }
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Outfit', sans-serif; }
        body { background: var(--light); display: flex; min-height: 100vh; }
        
        .sidebar { width: var(--sidebar-width); background: var(--dark); color: white; height: 100vh; position: fixed; }
        .main-content { margin-left: var(--sidebar-width); flex: 1; padding: 40px; }
        
        .hub-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px; }
        .card { background: white; border-radius: 24px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05); }
        .card-title { font-size: 1.2rem; font-weight: 800; margin-bottom: 20px; color: var(--dark); display: flex; align-items: center; gap: 10px; }
        
        .stat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 30px; }
        .stat-card { background: var(--light); padding: 20px; border-radius: 16px; border: 1px dashed #cbd5e1; }
        .stat-val { font-size: 1.8rem; font-weight: 900; color: var(--primary); }
        .stat-label { font-size: 0.8rem; color: #64748b; font-weight: 700; text-transform: uppercase; }

        .bot-playground { height: 400px; background: #0f172a; border-radius: 20px; display: flex; flex-direction: column; overflow: hidden; }
        .playground-header { padding: 15px; background: rgba(255,255,255,0.05); font-size: 0.8rem; color: #94a3b8; display: flex; justify-content: space-between; }
        .playground-chat { flex: 1; padding: 20px; overflow-y: auto; color: #cbd5e1; font-family: 'Courier New', Courier, monospace; font-size: 0.9rem; }
        .playground-input { padding: 20px; background: rgba(255,255,255,0.05); display: flex; gap: 10px; }
        .playground-input input { flex:1; background: none; border: 1px solid rgba(255,255,255,0.2); color: white; padding: 10px 15px; border-radius: 10px; }
        
        /* Playground Scroller */
        .playground-chat::-webkit-scrollbar { width: 6px; }
        .playground-chat::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        .playground-chat::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>

    <div class="main-content">
        <header style="margin-bottom: 40px;">
            <h1 style="font-size: 2.2rem; font-weight: 800; color: var(--dark);">AI Sahayak Control Hub</h1>
            <p style="color: #64748b;">Monitoring Neural Service Engagement & Knowledge Base</p>
        </header>

        <div class="hub-grid">
            <!-- Analytics Card -->
            <div class="card">
                <div class="card-title"><i class="fas fa-chart-line"></i> Engagement Analytics</div>
                <div class="stat-grid">
                    <div class="stat-card">
                        <div class="stat-val">2.4k</div>
                        <div class="stat-label">Total Queries</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-val">98%</div>
                        <div class="stat-label">Resolution Rate</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-val">342</div>
                        <div class="stat-label">Schemes Suggested</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-val">12</div>
                        <div class="stat-label">Active Languages</div>
                    </div>
                </div>

                <div style="background: #eff6ff; padding: 20px; border-radius: 16px; border-left: 5px solid var(--primary);">
                    <h5 style="color: var(--primary); margin-bottom: 10px;">Smart Insights</h5>
                    <p style="font-size: 0.9rem; color: #1e3a8a;">AI has noticed a 40% spike in **"Kanya Sumangala Yojana"** queries this week. Consider putting it on the main notice board.</p>
                </div>
            </div>

            <!-- Playground Card -->
            <div class="card">
                <div class="card-title"><i class="fas fa-vial"></i> Neural Playground (Tester)</div>
                <div class="bot-playground">
                    <div class="playground-header">
                        <span>BOT_ENV: PRODUCTION</span>
                        <span>LATENCY: 42ms</span>
                    </div>
                    <div class="playground-chat" id="admin-bot-chat">
                        <div>[SYSTEM]: Bot initialized. Awaiting input...</div>
                    </div>
                    <div class="playground-input">
                        <input type="text" id="admin-bot-input" placeholder="Test a query..." onkeypress="if(event.key==='Enter') testBot()">
                        <button onclick="testBot()" style="background: var(--primary); color: white; border: none; padding: 0 15px; border-radius: 8px; cursor: pointer;">Test</button>
                    </div>
                </div>
                <p style="font-size: 0.8rem; color: #64748b; margin-top: 15px;">Use this to test how Sahayak responds to specific village scenarios.</p>
            </div>
        </div>

        <div class="card" style="margin-top: 30px;">
            <div class="card-title"><i class="fas fa-brain"></i> Knowledge Base Connectivity</div>
            <table style="width: 100%; border-collapse: collapse;">
                <tr style="border-bottom: 1px solid #f1f5f9; background: #f8fafc;">
                    <th style="padding: 15px; text-align: left; font-size: 0.8rem; color: #64748b;">DATA SOURCE</th>
                    <th style="padding: 15px; text-align: left; font-size: 0.8rem; color: #64748b;">SYNC STATUS</th>
                    <th style="padding: 15px; text-align: left; font-size: 0.8rem; color: #64748b;">MAPPED ENTITIES</th>
                </tr>
                <tr>
                    <td style="padding: 15px; font-weight: 600;">Welfare Schemes Table</td>
                    <td style="padding: 15px;"><span style="color: #10b981;"><i class="fas fa-check-circle"></i> Live Sync</span></td>
                    <td style="padding: 15px;">24 Active Schemes</td>
                </tr>
                <tr>
                    <td style="padding: 15px; font-weight: 600;">Resident Registry</td>
                    <td style="padding: 15px;"><span style="color: #10b981;"><i class="fas fa-check-circle"></i> Live Sync</span></td>
                    <td style="padding: 15px;">1,402 Residents</td>
                </tr>
            </table>
        </div>
    </div>

    <script>
        let csrfHash = '<?= csrf_hash() ?>';
        const csrfName = '<?= csrf_token() ?>';

        function testBot() {
            const input = document.getElementById('admin-bot-input');
            const chat = document.getElementById('admin-bot-chat');
            const val = input.value.trim();
            if(!val) return;

            chat.innerHTML += `<div style="color: #818cf8; margin-top:10px;">> ${val}</div>`;
            input.value = '';

            fetch('<?= base_url('ai-assistant/neural-hub') ?>', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfHash
                },
                body: JSON.stringify({
                    message: val
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.token) csrfHash = data.token; // Update for next request
                chat.innerHTML += `<div style="color: #10b981;">[SAHAYAK]: ${data.reply}</div>`;
                chat.scrollTop = chat.scrollHeight;
            })
            .catch(err => {
                chat.innerHTML += `<div style="color: #ef4444;">[ERROR]: Neural Link Failure. System Offline.</div>`;
            });
        }
    </script>
</body>
</html>
