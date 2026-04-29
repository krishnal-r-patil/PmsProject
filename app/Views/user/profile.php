<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citizen Identity | Panchayat Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { 
            --sidebar-width: 280px; 
            --primary: #6366f1; 
            --primary-dark: #4f46e5;
            --accent-purple: #8b5cf6;
            --dark: #0f172a; 
            --dark-sidebar: #1e293b;
            --gray-100: #f1f5f9; 
            --gray-200: #e2e8f0; 
            --gray-700: #334155; 
            --glass: rgba(255, 255, 255, 0.9);
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        }

        /* Global Layout Reset and Consistency Lock */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: #f8fafc; display: flex; color: #1e293b; min-height: 100vh; }

        .sidebar { width: var(--sidebar-width) !important; background-color: var(--dark-sidebar) !important; height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 2rem 1.5rem !important; z-index: 1000; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width) !important; width: calc(100% - var(--sidebar-width)) !important; min-height: 100vh; }
        
        header { background: var(--glass); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); padding: 1.2rem 2.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(226, 232, 240, 0.8); position: sticky; top: 0; z-index: 999; }
        
        .content-body { padding: 3rem; animation: fadeIn 0.8s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

        /* Premium Profile Layout */
        .profile-layout { display: grid; grid-template-columns: 350px 1fr; gap: 3rem; align-items: start; }

        /* Identity Card (Left) */
        .id-card-premium { 
            background: white; 
            border-radius: 28px; 
            overflow: hidden; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            border: 1px solid rgba(255,255,255,0.7);
            position: sticky;
            top: 110px;
        }

        .id-cover {
            height: 160px;
            background: linear-gradient(135deg, var(--primary), var(--accent-purple));
            background-image: 
                radial-gradient(at 0% 0%, rgba(255,255,255,0.2) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(255,255,255,0.1) 0px, transparent 50%);
            position: relative;
        }

        .id-avatar-container {
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%);
            width: 110px;
            height: 110px;
            background: white;
            border-radius: 50%;
            padding: 5px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        .id-avatar {
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, #f1f5f9, #e2e8f0);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--primary);
            font-weight: 700;
        }

        .id-content { padding: 4rem 2rem 2.5rem 2rem; text-align: center; }
        .id-name { font-size: 1.5rem; font-weight: 800; color: var(--dark); margin-bottom: 5px; }
        .id-status { font-size: 0.85rem; color: #64748b; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 6px; }
        .online-blink { width: 8px; height: 8px; background: #10b981; border-radius: 50%; display: inline-block; animation: blink 2s infinite; }
        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }

        .id-quick-info { margin-top: 2.5rem; border-top: 1px dashed var(--gray-200); padding-top: 2rem; }
        .id-stat { display: flex; justify-content: space-between; margin-bottom: 1.2rem; }
        .id-stat-label { font-size: 0.8rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .id-stat-value { font-size: 0.95rem; color: var(--dark); font-weight: 700; }

        .btn-digital-id { 
            width: 100%; 
            margin-top: 2rem; 
            padding: 1rem; 
            background: var(--dark); 
            color: white; 
            border: none; 
            border-radius: 16px; 
            font-weight: 700; 
            cursor: pointer; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 10px; 
            transition: all 0.3s;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.1);
        }
        .btn-digital-id:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(15, 23, 42, 0.15); background: #000; }

        /* Details Section (Right) */
        .info-card { 
            background: white; 
            border-radius: 28px; 
            padding: 2.5rem; 
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255,255,255,0.7);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .card-decoration { position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(99, 102, 241, 0.03); border-radius: 50%; z-index: 0; }

        .info-card h3 { 
            font-size: 1.3rem; 
            font-weight: 800; 
            color: var(--dark); 
            margin-bottom: 2rem; 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            position: relative;
            z-index: 1;
        }
        .info-card h3 i { 
            background: rgba(99, 102, 241, 0.1); 
            color: var(--primary); 
            width: 38px; 
            height: 38px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            border-radius: 10px; 
            font-size: 1rem;
        }

        .data-grid { 
            display: grid; 
            grid-template-columns: repeat(3, 1fr); 
            gap: 2.5rem; 
            position: relative;
            z-index: 1;
        }

        .data-item label { 
            display: block; 
            font-size: 0.75rem; 
            font-weight: 700; 
            color: #94a3b8; 
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
            margin-bottom: 8px; 
        }

        .data-item p { 
            font-size: 1rem; 
            font-weight: 700; 
            color: var(--dark); 
            line-height: 1.4;
        }

        .address-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #f1f5f9;
            padding: 6px 12px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary);
        }

        /* QR Modal Styling */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.9); backdrop-filter: blur(8px); z-index: 2000; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; animation: bgFade 0.4s ease; }
        @keyframes bgFade { from { opacity: 0; } to { opacity: 1; } }

        .digital-id-modal { 
            background: white; 
            width: 480px; 
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 32px; 
            box-shadow: 0 30px 60px rgba(0,0,0,0.5);
            animation: modalSlide 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
        }
        @keyframes modalSlide { from { opacity: 0; transform: translateY(40px) scale(0.9); } to { opacity: 1; transform: translateY(0) scale(1); } }

        .btn-maximize {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
            z-index: 10;
        }
        .btn-maximize:hover { background: white; color: var(--primary); }

        .modal-header { 
            background: linear-gradient(135deg, var(--primary), var(--accent-purple));
            padding: 2.5rem 2rem;
            text-align: center;
            color: white;
        }

        .modal-body { padding: 2.5rem; text-align: center; }
        #qrcode { background: white; padding: 20px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); display: inline-block; margin-bottom: 2rem; transition: 0.4s; }
        #qrcode.maximized { transform: scale(1.15); margin-top: 2rem; margin-bottom: 3.5rem; }
        #qrcode img { width: 280px; height: 280px; transition: 0.4s; }
        #qrcode.maximized img { width: 340px; height: 340px; }

        .btn-close { width: 100%; padding: 1.1rem; background: var(--gray-100); color: var(--dark); border: none; border-radius: 18px; font-weight: 800; cursor: pointer; transition: 0.3s; margin-bottom: 2rem; }
        .btn-close:hover { background: var(--gray-200); }
    </style>
</head>
<body>
    <div class="sidebar">
        <?= view('user/partials/sidebar') ?>
    </div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800; font-size: 1.1rem; color: var(--dark);">Citizen Profile Registry</div>
            <div style="display:flex; align-items:center; gap:15px;">
                <span style="font-size: 0.85rem; color: #64748b;">System ID: <strong>GP-<?= substr($citizen['family_id'], -4) ?></strong></span>
                <div style="width: 1px; height: 20px; background: #e2e8f0;"></div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <div class="online-blink"></div>
                    <span style="font-size: 0.8rem; font-weight: 700; color: #10b981;">Authorized Access</span>
                </div>
            </div>
        </header>

        <div class="content-body">
            <div class="profile-layout">
                <!-- Left: Identity Badge -->
                <div class="id-card-premium">
                    <div class="id-content" style="padding-top: 3rem;">
                        <div class="id-avatar-container" style="position: relative; bottom: auto; left: auto; transform: none; margin: 0 auto 1.5rem auto; width: 120px; height: 120px; box-shadow: 0 15px 35px rgba(99, 102, 241, 0.2);">
                            <div class="id-avatar" style="background: linear-gradient(135deg, var(--primary), var(--accent-purple)); color: white; border: 4px solid white;">
                                <?= substr($citizen['name'], 0, 1) ?>
                            </div>
                        </div>
                        <h2 class="id-name"><?= $citizen['name'] ?></h2>
                        <div class="id-status">Gram Panchayat Bodarli, Resident</div>
                        
                        <div class="id-quick-info">
                            <div class="id-stat">
                                <span class="id-stat-label">Family Account ID</span>
                                <span class="id-stat-value" style="color: var(--primary); letter-spacing: 1px;"><?= $citizen['family_id'] ?></span>
                            </div>
                            <div class="id-stat">
                                <span class="id-stat-label">Member Role</span>
                                <span class="id-stat-value">Head of Fam / Member</span>
                            </div>
                            <div class="id-stat">
                                <span class="id-stat-label">Registry Date</span>
                                <span class="id-stat-value"><?= date('d M Y', strtotime($citizen['created_at'])) ?></span>
                            </div>
                        </div>

                        <button class="btn-digital-id" id="viewQrBtn">
                            <i class="fas fa-qrcode"></i> Digital Identity QR
                        </button>
                    </div>
                </div>

                <!-- Right: Detailed Information -->
                <div class="details-pane">
                    <!-- Section 1: Official registration -->
                    <div class="info-card">
                        <div class="card-decoration"></div>
                        <h3><i class="fas fa-id-card"></i> Official Registration Details</h3>
                        
                        <div style="margin-bottom: 2.5rem; padding-bottom: 2rem; border-bottom: 1px dashed var(--gray-200); position: relative; z-index: 1;">
                            <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Primary Record Name</label>
                            <h1 style="font-size: 2.4rem; font-weight: 900; background: linear-gradient(135deg, var(--dark), var(--primary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -1px;"><?= $citizen['name'] ?></h1>
                        </div>

                        <div class="data-grid">
                            <div class="data-item">
                                <label>Father/Husband Name</label>
                                <p><?= $citizen['father_name'] ?></p>
                            </div>
                            <div class="data-item">
                                <label>Date of Birth</label>
                                <p><?= date('d F Y', strtotime($citizen['dob'])) ?></p>
                            </div>
                            <div class="data-item">
                                <label>Aadhar Number</label>
                                <p>XXXX-XXXX-<?= substr($citizen['aadhar_no'], -4) ?></p>
                            </div>
                            <div class="data-item">
                                <label>Voter ID Card</label>
                                <p><?= $citizen['voter_id'] ?></p>
                            </div>
                            <div class="data-item">
                                <label>Phone Number</label>
                                <p><?= $citizen['phone'] ?></p>
                            </div>
                            <div class="data-item">
                                <label>Email Address</label>
                                <p><?= $citizen['email'] ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Residential Data -->
                    <div class="info-card">
                        <div class="card-decoration"></div>
                        <h3><i class="fas fa-house-user"></i> Resident Location & Housing</h3>
                        <div class="data-grid">
                            <div class="data-item">
                                <label>Village Name</label>
                                <p><span class="address-badge"><i class="fas fa-map-marker-alt"></i> <?= $citizen['village'] ?></span></p>
                            </div>
                            <div class="data-item">
                                <label>Ward Number</label>
                                <p>Ward No. 0<?= $citizen['ward_no'] ?></p>
                            </div>
                            <div class="data-item">
                                <label>Social Category</label>
                                <p><?= $citizen['category'] ?></p>
                            </div>
                            <div class="data-item" style="grid-column: span 3;">
                                <label>Housing Detail & Full Address</label>
                                <p style="font-size: 1.15rem; color: var(--primary); font-weight: 800; line-height: 1.6; letter-spacing: -0.2px;">
                                    House No. <?= $citizen['house_no'] ?>, Near <?= $citizen['village'] ?> Ward 0<?= $citizen['ward_no'] ?>, Gram Panchayat Bodarli Area, Dist. Burhanpur (M.P.)
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Verification Note -->
                    <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(99, 102, 241, 0.05)); padding: 2.5rem; border-radius: 28px; border: 1px solid rgba(16, 185, 129, 0.2); display: flex; flex-direction: column; gap: 20px; position: relative; overflow: hidden;">
                        <div style="position: absolute; right: -20px; bottom: -20px; font-size: 8rem; color: rgba(16, 185, 129, 0.03); transform: rotate(-15deg);"><i class="fas fa-certificate"></i></div>
                        
                        <div style="display: flex; gap: 15px; align-items: flex-start; position: relative; z-index: 1;">
                            <i class="fas fa-shield-check" style="color: #10b981; font-size: 1.5rem; margin-top: 2px;"></i>
                            <div>
                                <p style="font-weight: 800; color: #065f46; font-size: 1rem; margin-bottom: 5px;">Verified Citizen Record</p>
                                <p style="font-size: 0.85rem; color: #065f46; opacity: 0.8; line-height: 1.6; max-width: 600px;">
                                    This electronic profile is officially verified by the **Gram Panchayat Bodarli Authority**. 
                                    Total digital transparency is maintained for all benefits, subsidies, and government schemes linked to this identity.
                                </p>
                            </div>
                        </div>

                        <div style="margin-top: 1rem; border-top: 1px solid rgba(16, 185, 129, 0.1); padding-top: 1.5rem; display: flex; justify-content: space-between; align-items: flex-end; position: relative; z-index: 1;">
                            <div>
                                <p style="font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 10px;">Authenticated Identity</p>
                                <p style="font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 900; background: linear-gradient(to right, var(--primary), var(--accent-purple)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -0.5px;">
                                    <?= $citizen['name'] ?>
                                </p>
                            </div>
                            <div style="text-align: right;">
                                <div style="display: inline-flex; align-items: center; gap: 8px; background: white; padding: 10px 20px; border-radius: 50px; border: 1px solid #d1fae5; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                                    <i class="fas fa-stamp" style="color: #10b981;"></i>
                                    <span style="font-size: 0.8rem; font-weight: 800; color: #065f46;">OFFICIALLY CERTIFIED</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Digital ID QR Modal -->
    <div class="modal-overlay" id="qrModal">
        <div class="digital-id-modal">
            <button class="btn-maximize" id="maxBtn" title="Maximize View"><i class="fas fa-expand-alt"></i></button>
            <div class="modal-header">
                <i class="fas fa-fingerprint" style="font-size: 2.5rem; margin-bottom: 1rem; display: block;"></i>
                <h2 style="font-weight: 800;">Digital e-Identity</h2>
                <p style="font-size: 0.85rem; opacity: 0.8;">Scan for verification</p>
            </div>
            <div class="modal-body">
                <div id="qrcode"></div>
                <div style="text-align: left; background: #f8fafc; padding: 1.5rem; border-radius: 20px; margin-bottom: 2rem; border-left: 5px solid #10b981; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
                    <p style="font-weight: 800; color: var(--dark); font-size: 1.1rem; margin-bottom: 4px;"><?= $citizen['name'] ?></p>
                    <p style="font-size: 0.8rem; color: #10b981; font-weight: 800; text-transform: uppercase; margin-bottom: 10px; letter-spacing: 0.5px;">Verified Citizen Identity</p>
                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <p style="font-size: 0.75rem; color: #64748b; font-weight: 700;"><i class="fas fa-map-marker-alt" style="width: 15px;"></i> Resident of Gram Panchayat Bodarli</p>
                        <p style="font-size: 0.75rem; color: #64748b; font-weight: 700;"><i class="fas fa-calendar-check" style="width: 15px;"></i> Registered: <?= date('d M Y', strtotime($citizen['created_at'])) ?></p>
                        <p style="font-size: 0.75rem; color: #64748b; font-weight: 700;"><i class="fas fa-fingerprint" style="width: 15px;"></i> Digital Token: <?= substr(md5($citizen['family_id']), 0, 10) ?></p>
                    </div>
                </div>
                <button class="btn-close" id="closeQrBtn">Close Secure ID</button>
            </div>
        </div>
    </div>

    <!-- Reliable Digital Identity QR Engine -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        const citizen = {
            name: <?= json_encode($citizen['name']) ?>,
            father: <?= json_encode($citizen['father_name']) ?>,
            dob: <?= json_encode(date('d M Y', strtotime($citizen['dob']))) ?>,
            aadhar: "XXXX-XXXX-" + <?= json_encode(substr($citizen['aadhar_no'], -4)) ?>,
            voter: <?= json_encode($citizen['voter_id']) ?>,
            ward: "0" + <?= json_encode($citizen['ward_no']) ?>,
            village: <?= json_encode($citizen['village']) ?>,
            house: <?= json_encode($citizen['house_no']) ?>,
            id: <?= json_encode($citizen['family_id']) ?>
        };

        const idDataText = `GRAM PANCHAYAT BODARLI e-ID\n--------------------------\nNAME: ${citizen.name}\nFATHER: ${citizen.father}\nDOB: ${citizen.dob}\nAADHAR: ${citizen.aadhar}\nID: ${citizen.id}\nWARD: ${citizen.ward}\nHOUSE: ${citizen.house}\nSTATUS: VERIFIED`;

        function generateQR(size = 320) {
            const container = document.getElementById('qrcode');
            container.innerHTML = ''; 
            
            if (typeof QRCode === 'undefined') {
                container.innerHTML = 'Scan Engine Error';
                return;
            }

            try {
                new QRCode(container, {
                    text: idDataText,
                    width: size,
                    height: size,
                    colorDark : "#000000",
                    colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.L
                });
                
                setTimeout(() => {
                    const img = container.querySelector('img');
                    if(img) {
                        img.style.display = 'block';
                        img.style.margin = '0 auto';
                        img.style.borderRadius = '0'; 
                        img.style.padding = '10px';
                        img.style.background = 'white';
                        img.setAttribute('title', ''); // Hide hover info
                    }
                    container.setAttribute('title', ''); // Hide hover info on container too
                }, 200);

            } catch(e) {
                container.innerHTML = 'QR Complexity Error';
            }
        }

        document.getElementById('viewQrBtn').onclick = () => {
            document.getElementById('qrModal').classList.add('open');
            generateQR(280);
        };

        let isMax = false;
        document.getElementById('maxBtn').onclick = function() {
            isMax = !isMax;
            const qr = document.getElementById('qrcode');
            const icon = this.querySelector('i');
            
            if(isMax) {
                qr.classList.add('maximized');
                icon.className = "fas fa-compress-alt";
                generateQR(350);
            } else {
                qr.classList.remove('maximized');
                icon.className = "fas fa-expand-alt";
                generateQR(280);
            }
        };

        document.getElementById('closeQrBtn').onclick = () => {
            document.getElementById('qrModal').classList.remove('open');
            isMax = false;
            document.getElementById('qrcode').classList.remove('maximized');
            document.getElementById('maxBtn').querySelector('i').className = "fas fa-expand-alt";
        };

        window.onclick = (e) => {
            if (e.target.id == 'qrModal') document.getElementById('qrModal').classList.remove('open');
        }
    </script>
</body>
</html>
