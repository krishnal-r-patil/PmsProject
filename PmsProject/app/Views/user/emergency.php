<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency & Health Hub - E-Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #ef4444; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gold: #f59e0b; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }
        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 90; }
        .content-padding { padding: 3rem; }

        .alert-active { background: #fee2e2; border: 2px solid #ef4444; padding: 1.5rem; border-radius: 20px; display: flex; gap: 20px; align-items: center; margin-bottom: 2.5rem; animation: pulse 2s infinite; }
        @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); } 70% { box-shadow: 0 0 0 15px rgba(239, 68, 68, 0); } 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); } }
        
        .directory-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem; }
        .dir-card { background: white; padding: 1.5rem; border-radius: 24px; border: 1px solid #e2e8f0; transition: 0.3s; position: relative; overflow: hidden; }
        .dir-card:hover { transform: translateY(-5px); border-color: var(--primary); }
        .dir-icon { width: 50px; height: 50px; background: #fef2f2; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #ef4444; margin-bottom: 1rem; }
        
        .cat-pill { padding: 4px 10px; border-radius: 50px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; background: #f1f5f9; color: #64748b; margin-bottom: 10px; display: inline-block; }
        .blood-tag { background: #fee2e2; color: #b91c1c; font-weight: 800; padding: 2px 8px; border-radius: 6px; font-size: 0.9rem; }
        
        .call-btn { width: 100%; padding: 0.8rem; background: var(--dark); color: white; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; text-decoration: none; margin-top: 1rem; transition: 0.3s; }
        .call-btn:hover { background: #b91c1c; }

        .section-title { font-size: 1.8rem; font-weight: 800; margin-bottom: 1.5rem; color: var(--dark); display: flex; align-items: center; gap: 12px; }
        .tabs { display: flex; gap: 15px; margin-bottom: 2rem; overflow-x: auto; padding-bottom: 10px; }
        .tab-btn { padding: 0.8rem 1.5rem; background: white; border: 1px solid #e2e8f0; border-radius: 50px; cursor: pointer; font-weight: 700; white-space: nowrap; transition: 0.3s; }
        .tab-btn.active { background: var(--primary); color: white; border-color: var(--primary); }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800; color: var(--primary);"><i class="fas fa-heartbeat"></i> Emergency & Health Hub</div>
            <div style="background: #ecfdf5; color: #059669; padding: 6px 15px; border-radius: 50px; font-size: 0.8rem; font-weight: 800;">
                <i class="fas fa-shield-alt"></i> Official Directory Verified
            </div>
        </header>

        <div class="content-padding">
            <?php if(!empty($active_alerts)): ?>
                <?php foreach($active_alerts as $alert): ?>
                    <div class="alert-active" style="<?= $alert['severity'] != 'High' ? 'background: #fff7ed; border-color: #f59e0b; animation: none;' : '' ?>">
                        <div style="width: 60px; height: 60px; background: <?= $alert['severity'] == 'High' ? '#ef4444' : '#f59e0b' ?>; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; color: white;">
                            <i class="fas <?= $alert['severity'] == 'High' ? 'fa-exclamation-triangle' : 'fa-info-circle' ?>"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                <div style="font-size: 0.75rem; font-weight: 800; color: <?= $alert['severity'] == 'High' ? '#991b1b' : '#92400e' ?>; text-transform: uppercase; letter-spacing: 1px;">
                                    ACTIVE ALERT: <?= $alert['severity'] ?> 
                                    <span style="margin-left: 10px; background: rgba(0,0,0,0.05); padding: 2px 8px; border-radius: 4px;"><i class="fas fa-map-marker-alt"></i> Area: <?= $alert['ward_no'] ?></span>
                                </div>
                                <div style="text-align: right; color: <?= $alert['severity'] == 'High' ? '#991b1b' : '#92400e' ?>; font-size: 0.8rem; font-weight: 700;">
                                    Issued: <?= date('d M, H:i', strtotime($alert['created_at'])) ?>
                                </div>
                            </div>
                            <h2 style="font-size: 1.5rem; font-weight: 800; color: <?= $alert['severity'] == 'High' ? '#7f1d1d' : '#854d0e' ?>; margin-top: 5px;"><?= $alert['title'] ?></h2>
                            <p style="color: <?= $alert['severity'] == 'High' ? '#991b1b' : '#92400e' ?>; font-weight: 500;"><?= $alert['message'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="tabs">
                <button class="tab-btn active" onclick="filterTab('all')">Emergency Directory</button>
                <button class="tab-btn" onclick="filterTab('Hospital')">Hospitals</button>
                <button class="tab-btn" onclick="filterTab('Ambulance')">Ambulances</button>
                <button class="tab-btn" onclick="filterTab('Blood Donor')">Donors</button>
                <button class="tab-btn" onclick="filterTab('Pharmacy')">Pharmacy</button>
                <button class="tab-btn" onclick="filterTab('Oxygen Supply')">Oxygen</button>
                <button class="tab-btn" onclick="filterTab('Fire Station')">Public Services</button>
            </div>

            <div class="directory-grid">
                <?php foreach($directory as $item): ?>
                <div class="dir-card" data-cat="<?= $item['category'] ?>">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <span class="cat-pill">
                            <i class="fas <?= $item['category'] == 'Hospital' ? 'fa-hospital' : ($item['category'] == 'Ambulance' ? 'fa-ambulance' : ($item['category'] == 'Blood Donor' ? 'fa-tint' : 'fa-briefcase-medical')) ?>"></i> 
                            <?= $item['category'] ?>
                        </span>
                        <?php if($item['blood_group']): ?>
                            <span class="blood-tag"><?= $item['blood_group'] ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <h3 style="font-weight: 800; color: var(--dark); margin-bottom: 4px;"><?= esc($item['name']) ?></h3>
                    <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 12px; line-height: 1.4;"><?= esc($item['address']) ?></p>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 15px;">
                        <div style="background: #f8fafc; padding: 8px; border-radius: 10px; text-align: center;">
                            <div style="font-size: 0.6rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Status</div>
                            <div style="font-size: 0.75rem; font-weight: 800; color: #10b981;"><?= $item['service_hours'] ?></div>
                        </div>
                        <?php if($item['available_capacity']): 
                            $cap_text = strtolower($item['available_capacity']);
                            $is_good = (strpos($cap_text, 'full') !== false || strpos($cap_text, 'complete') !== false || strpos($cap_text, 'available') !== false || strpos($cap_text, 'high') !== false || strpos($cap_text, 'yes') !== false || strpos($cap_text, 'good') !== false);
                        ?>
                        <div style="background: <?= $is_good ? '#ecfdf5' : '#fef2f2' ?>; padding: 8px; border-radius: 10px; text-align: center;">
                            <div style="font-size: 0.6rem; font-weight: 800; color: <?= $is_good ? '#059669' : '#f87171' ?>; text-transform: uppercase;">Capacity/Stock</div>
                            <div style="font-size: 0.75rem; font-weight: 800; color: <?= $is_good ? '#10b981' : '#ef4444' ?>;"><?= esc($item['available_capacity']) ?></div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <?php if($item['map_link']): ?>
                            <a href="<?= $item['map_link'] ?>" target="_blank" class="call-btn" style="background: #f1f5f9; color: #475569; width: 45px; margin: 0;"><i class="fas fa-map-marked-alt"></i></a>
                        <?php endif; ?>
                        <?php if($item['website']): ?>
                            <a href="<?= $item['website'] ?>" target="_blank" class="call-btn" style="background: #f1f5f9; color: #475569; width: 45px; margin: 0;"><i class="fas fa-globe"></i></a>
                        <?php endif; ?>
                        <button onclick="initiateEmergencyCall('<?= esc($item['name']) ?>', '<?= $item['contact_no'] ?>', '<?= $item['category'] ?>')" class="call-btn" style="flex: 1; margin: 0;">
                            <i class="fas fa-phone-alt"></i> CALL NOW
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Emergency Dialer Modal -->
    <div id="dialerModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
        <div style="background: white; width: 380px; border-radius: 40px; padding: 2.5rem; text-align: center; border: 4px solid #ef4444; position: relative;">
            <button onclick="closeDialer()" style="position: absolute; right: 20px; top: 20px; border: none; background: #fee2e2; color: #ef4444; width: 35px; height: 35px; border-radius: 50%; cursor: pointer; font-weight: 800;">&times;</button>
            
            <div style="width: 80px; height: 80px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 2rem; animation: pulse 1s infinite;">
                <i class="fas fa-phone-alt"></i>
            </div>
            
            <div id="dialerTag" style="font-size: 0.7rem; color: #ef4444; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;"></div>
            <h2 id="dialerName" style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-bottom: 10px;"></h2>
            <div id="dialerNumber" style="font-size: 1.8rem; font-weight: 800; color: #ef4444; margin-bottom: 1.5rem;"></div>

            <div style="background: #f8fafc; padding: 1.5rem; border-radius: 20px; border: 1px solid #e2e8f0; margin-bottom: 1.5rem; display: flex; flex-direction: column; align-items: center;">
                <div id="qrCode" style="padding: 10px; background: white; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); display: inline-block;"></div>
                <p style="font-size: 0.75rem; color: #64748b; margin-top: 15px; font-weight: 700;">Scan with Phone Camera to Start Call</p>
            </div>

            <a id="directDial" href="" class="call-btn" style="background: #ef4444; padding: 1.2rem; font-size: 1rem;"><i class="fas fa-mobile-alt"></i> Direct Call on Mobile</a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let qrEngine = null;

        function initiateEmergencyCall(name, number, tag) {
            document.getElementById('dialerName').innerText = name;
            document.getElementById('dialerNumber').innerText = number;
            document.getElementById('dialerTag').innerText = tag;
            document.getElementById('directDial').href = 'tel:' + number;
            
            // Local QR Generation
            const qrContainer = document.getElementById('qrCode');
            qrContainer.innerHTML = '';
            
            new QRCode(qrContainer, {
                text: `tel:${number}`,
                width: 150,
                height: 150,
                colorDark : "#0f172a",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });

            document.getElementById('dialerModal').style.display = 'flex';
        }

        function closeDialer() {
            document.getElementById('dialerModal').style.display = 'none';
        }
        function filterTab(cat) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            document.querySelectorAll('.dir-card').forEach(card => {
                if(cat === 'all' || card.dataset.cat === cat) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
