<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Identity Verification | Gram Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { 
            --primary: #6366f1; 
            --success: #10b981; 
            --dark: #0f172a; 
            --gray-100: #f8fafc;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: #f1f5f9; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 1.5rem; }
        
        .id-card-certified { 
            background: white; 
            width: 100%; 
            max-width: 450px; 
            border-radius: 32px; 
            overflow: hidden; 
            box-shadow: 0 40px 80px rgba(15, 23, 42, 0.15); 
            border: 1px solid rgba(255,255,255,0.8);
            position: relative;
            animation: cardEntrance 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes cardEntrance { from { opacity: 0; transform: translateY(30px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
        
        /* Official Header */
        .id-header { 
            background: linear-gradient(135deg, var(--dark), #1e293b); 
            color: white; 
            padding: 2.5rem 1.5rem; 
            text-align: center; 
            position: relative; 
            overflow: hidden;
        }
        .header-mesh { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.15; background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 20px 20px; }
        .id-header::after { content: "✓ SECURE VERIFIED IDENTITY"; position: absolute; bottom: 0; left: 0; width: 100%; padding: 8px 0; background: var(--success); font-size: 0.7rem; font-weight: 800; letter-spacing: 1.5px; }
        
        .gov-logo { width: 70px; height: 70px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.2rem; color: var(--dark); font-size: 1.8rem; box-shadow: 0 10px 20px rgba(0,0,0,0.2); position: relative; z-index: 1; }
        .panchayat-name { font-size: 1.3rem; font-weight: 800; letter-spacing: -0.5px; position: relative; z-index: 1; }
        
        /* Profile Image Section */
        .profile-section { padding: 3.5rem 2rem 2rem; text-align: center; background: radial-gradient(circle at top, rgba(99, 102, 241, 0.05), transparent); }
        .avatar { width: 120px; height: 120px; background: linear-gradient(to bottom, #f1f5f9, #e2e8f0); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 3.5rem; color: var(--primary); border: 6px solid white; box-shadow: 0 15px 35px rgba(0,0,0,0.08); }
        .citizen-name { font-size: 1.8rem; font-weight: 800; color: var(--dark); margin-bottom: 0.5rem; letter-spacing: -0.5px; }
        .citizen-id-badge { display: inline-flex; align-items: center; gap: 8px; background: #f1f5f9; padding: 6px 14px; border-radius: 12px; font-size: 0.8rem; font-weight: 800; color: var(--primary); }

        /* Details Grid */
        .details-grid { padding: 2.5rem; display: grid; grid-template-columns: 1fr 1fr; gap: 2rem 1.5rem; position: relative; }
        .details-grid::before { content: "CERTIFIED"; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-30deg); font-size: 5rem; font-weight: 900; color: rgba(16, 185, 129, 0.03); pointer-events: none; }
        
        .detail-item label { display: block; font-size: 0.7rem; color: #94a3b8; font-weight: 800; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px; }
        .detail-item p { font-size: 1rem; font-weight: 700; color: var(--dark); }

        .full-address { grid-column: span 2; padding-top: 1rem; border-top: 1px dashed var(--gray-200); }
        
        .footer-banner { background: #f8fafc; padding: 1.5rem; text-align: center; border-top: 1px solid var(--gray-200); }
        .stamp-badge { display: inline-flex; align-items: center; gap: 10px; background: white; padding: 10px 20px; border-radius: 50px; border: 1px solid #d1fae5; box-shadow: 0 5px 15px rgba(0,0,0,0.03); }
        
        @media print { .no-print { display: none; } body { background: white; padding: 0; } .id-card-certified { box-shadow: none; border: 1px solid #ccc; max-width: 100%; } }
    </style>
</head>
<body>
    <div class="id-card-certified">
        <div class="id-header">
            <div class="header-mesh"></div>
            <div class="gov-logo"><i class="fas fa-landmark"></i></div>
            <div class="panchayat-name">GRAM PANCHAYAT <?= strtoupper($citizen['village']) ?></div>
            <p style="font-size: 0.8rem; opacity: 0.7; margin-top: 8px; font-weight: 500;">Official e-PMS Registry Verification</p>
        </div>

        <div class="profile-section">
            <div class="avatar"><?= substr($citizen['name'], 0, 1) ?></div>
            <h1 class="citizen-name"><?= $citizen['name'] ?></h1>
            <div class="citizen-id-badge"><i class="fas fa-fingerprint"></i> ID: <?= $citizen['family_id'] ?></div>
        </div>

        <div class="details-grid">
            <div class="detail-item">
                <label>Relation Name</label>
                <p><?= $citizen['father_name'] ?></p>
            </div>
            <div class="detail-item">
                <label>Date of Birth</label>
                <p><?= date('d M Y', strtotime($citizen['dob'])) ?></p>
            </div>
            <div class="detail-item">
                <label>Voter ID</label>
                <p><?= $citizen['voter_id'] ?></p>
            </div>
            <div class="detail-item">
                <label>Aadhar Linked</label>
                <p>Verified ✓</p>
            </div>
            <div class="full-address">
                <label>Residential Housing Detail</label>
                <p style="color: var(--primary); font-size: 1.05rem; line-height: 1.5;">
                    House No. <?= $citizen['house_no'] ?>, Near <?= $citizen['village'] ?> Ward 0<?= $citizen['ward_no'] ?>, Gram Panchayat Bodarli Area, Dist. Burhanpur (M.P.)
                </p>
            </div>
        </div>

        <div class="footer-banner">
            <div class="stamp-badge">
                <i class="fas fa-stamp" style="color: #10b981;"></i>
                <span style="font-size: 0.85rem; font-weight: 800; color: #065f46;">OFFICIAL DIGITAL SIGNATURE</span>
            </div>
            <p style="font-size: 0.65rem; color: #94a3b8; margin-top: 15px; font-weight: 600;">System Generated Verification • Timestamp: <?= date('d M Y H:i') ?></p>
        </div>
        
        <div style="padding: 1.5rem; text-align: center;" class="no-print">
            <button onclick="window.print()" style="width: 100%; padding: 1rem; background: var(--dark); color: white; border: none; border-radius: 16px; font-weight: 700; cursor: pointer; transition: 0.3s;"><i class="fas fa-file-pdf"></i> Download Official Certificate</button>
        </div>
    </div>
</body>
</html>
