<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gram Sabha Proceedings - Administrative Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 280px; --primary: #6366f1; --accent: #10b981; --dark: #0f172a; --gray-50: #f8fafc; --gray-100: #f1f5f9; --gray-200: #e2e8f0; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-50); display: flex; }
        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        header { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); padding: 1.2rem 2.5rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 90; }
        .content-padding { padding: 3rem; }

        .dashboard-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem; }
        .hub-title h1 { font-size: 2.8rem; font-weight: 800; letter-spacing: -1px; color: var(--dark); margin-bottom: 5px; }
        .hub-title p { color: #64748b; font-size: 1.1rem; font-weight: 500; }

        .btn-premium { background: linear-gradient(135deg, var(--primary), #4f46e5); color: white; padding: 1rem 2rem; border: none; border-radius: 16px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: 0.3s; box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3); }
        .btn-premium:hover { transform: translateY(-3px); box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.4); }

        /* PROCEEDINGS GRID */
        .proceedings-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 2rem; }
        .proceeding-card { background: white; border-radius: 30px; padding: 2rem; border: 1px solid var(--gray-200); position: relative; transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); display: flex; flex-direction: column; overflow: hidden; }
        .proceeding-card:hover { transform: translateY(-10px); box-shadow: 0 25px 40px -15px rgba(0,0,0,0.1); border-color: var(--primary); }
        
        .card-type-tab { position: absolute; top: 0; right: 0; background: var(--primary); color: white; padding: 6px 20px; border-bottom-left-radius: 20px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; }
        
        .date-badge { width: 65px; height: 65px; background: #eff6ff; border-radius: 18px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--primary); margin-bottom: 1.5rem; border: 1px solid #dbeafe; }
        .date-badge .day { font-size: 1.5rem; font-weight: 800; line-height: 1; }
        .date-badge .month { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }

        .proc-title { font-size: 1.5rem; font-weight: 800; color: var(--dark); line-height: 1.25; margin-bottom: 1rem; }
        .proc-summary { color: #64748b; font-size: 0.95rem; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 1.5rem; flex-grow: 1; }

        .card-footer { border-top: 1px solid var(--gray-100); padding-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; }
        .file-link { color: var(--primary); text-decoration: none; font-weight: 700; font-size: 0.85rem; display: flex; align-items: center; gap: 6px; }
        .action-btns { display: flex; gap: 10px; }
        .btn-icon { width: 38px; height: 38px; border-radius: 12px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: 0.2s; font-size: 1rem; }
        .btn-edit { background: #ecfdf5; color: #10b981; }
        .btn-edit:hover { background: #10b981; color: white; }
        .btn-delete { background: #fff1f2; color: #ef4444; }
        .btn-delete:hover { background: #ef4444; color: white; }

        /* Modal Styles */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px); }
        .modal { background: white; width: 650px; border-radius: 35px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); animation: zoomIn 0.3s ease; }
        @keyframes zoomIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        
        .form-group { margin-bottom: 1.8rem; }
        .form-group label { display: block; margin-bottom: 0.6rem; font-weight: 800; font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        input, textarea { width: 100%; padding: 1rem; border: 1.5px solid var(--gray-200); border-radius: 16px; outline: none; transition: 0.3s; font-size: 1rem; }
        input:focus, textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800; font-size: 1.1rem; color: var(--dark);"><i class="fas fa-file-invoice" style="color: var(--primary); margin-right: 10px;"></i> Transparency Control Center</div>
            <div style="font-size: 0.85rem; color: #64748b; font-weight: 600;"><i class="fas fa-database"></i> Digital Ledger v4.2</div>
        </header>

        <div class="content-padding">
            <div class="dashboard-header">
                <div class="hub-title">
                    <h1>Gram Sabha Archives</h1>
                    <p>Official repository of village resolutions and budget plans.</p>
                </div>
                <button class="btn-premium" onclick="openModal()"><i class="fas fa-plus-circle"></i> Record New Proceedings</button>
            </div>

            <?php if(empty($proceedings)): ?>
                <div style="text-align:center; padding: 10rem 0; background: white; border-radius: 40px; border: 2px dashed var(--gray-200);">
                    <i class="fas fa-folder-open" style="font-size: 4rem; color: var(--gray-200); margin-bottom: 1.5rem;"></i>
                    <h3 style="color: #64748b; font-weight: 700;">No proceedings found in central registry.</h3>
                </div>
            <?php endif; ?>

            <div class="proceedings-grid">
                <?php foreach($proceedings as $p): 
                    $date = strtotime($p['meeting_date']);
                ?>
                <div class="proceeding-card">
                    <div class="card-type-tab">Official Record</div>
                    <div class="date-badge">
                        <span class="month"><?= date('M', $date) ?></span>
                        <span class="day"><?= date('d', $date) ?></span>
                    </div>
                    
                    <h3 class="proc-title"><?= esc($p['title']) ?></h3>
                    <p class="proc-summary"><?= esc($p['minutes']) ?></p>

                    <div class="card-footer">
                        <div>
                            <?php if($p['file_path']): ?>
                                <a href="<?= base_url('public/' . $p['file_path']) ?>" target="_blank" class="file-link">
                                    <i class="fas fa-file-pdf"></i> View Attachment
                                </a>
                            <?php else: ?>
                                <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 700; font-style: italic;"><i class="fas fa-fingerprint"></i> Digital Only</span>
                            <?php endif; ?>
                        </div>
                        <div class="action-btns">
                            <button class="btn-icon btn-edit" onclick="safeEdit(this)" 
                                    data-id="<?= $p['id'] ?>"
                                    data-title="<?= htmlspecialchars($p['title']) ?>"
                                    data-date="<?= $p['meeting_date'] ?>"
                                    data-minutes="<?= htmlspecialchars($p['minutes']) ?>"
                                    data-attendees="<?= htmlspecialchars($p['attendees'] ?? '') ?>"
                                    data-agenda="<?= htmlspecialchars($p['agenda'] ?? '') ?>"
                                    data-resolutions="<?= htmlspecialchars($p['resolutions'] ?? '') ?>"
                                    data-file="<?= $p['file_path'] ?>"
                                    title="Edit Entry"><i class="fas fa-pen-nib"></i></button>
                            
                            <button class="btn-icon btn-delete" onclick="askConfirm('<?= base_url('admin/proceedings/delete/'.$p['id']) ?>', 'Wipe this official proceeding from history? This cannot be reversed.')" title="Delete Record">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Upload/Edit Modal -->
    <div class="modal-overlay" id="pModal">
        <div class="modal">
            <div style="padding: 2rem 3rem; background: var(--gray-50); border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center;">
                <h2 style="font-weight: 800; color: var(--dark);" id="modalTitle">Record Proceedings</h2>
                <button style="border:none; background:none; font-size: 2rem; cursor:pointer; color: #94a3b8;" onclick="closeModal()">&times;</button>
            </div>
            <form action="<?= base_url('admin/proceedings/save') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="p_id">
                <input type="hidden" name="old_file" id="p_old_file">
                <input type="hidden" name="meeting_id" id="p_meeting_id">
                
                <div style="max-height: 75vh; overflow-y: auto;">
                    <!-- Branded Header Image -->
                    <div style="width: 100%; height: 200px; background: url('<?= base_url('public/assets/img/assembly_branding.png') ?>') center/cover; position: relative;">
                        <div style="position: absolute; inset: 0; background: linear-gradient(0deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 100%);"></div>
                    </div>

                    <div style="padding: 0 3rem 2.5rem 3rem;">
                        <div class="form-group">
                            <label><i class="fas fa-heading" style="color:var(--primary);"></i> Meeting Subject / Core Agenda *</label>
                            <div style="display: flex; gap: 10px;">
                                <input type="text" name="title" id="p_title" placeholder="e.g. Annual Budget Planning FY2026" required style="flex: 1;">
                                <select onchange="applyTemplate(this.value)" style="width: 180px; padding: 0.5rem; border-radius: 12px; border: 1.5px solid var(--gray-200); font-weight: 700; cursor: pointer; background: #f8fafc;">
                                    <option value="">Quick Templates</option>
                                    <option value="budget">💰 Annual Budget</option>
                                    <option value="infra">🏗️ Infrastructure</option>
                                    <option value="audit">🔍 Quarterly Audit</option>
                                    <option value="agri">🚜 Krishi / Farmers</option>
                                    <option value="health">🏥 Health & Vaccine</option>
                                    <option value="edu">📚 Education & School</option>
                                    <option value="water">💧 Water & Sanitation</option>
                                    <option value="welfare">🤝 Social Welfare</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-calendar-day" style="color:var(--primary);"></i> Date of Assembly *</label>
                            <input type="date" name="meeting_date" id="p_date" required>
                        </div>
                        <div class="form-group">
                            <label style="display:flex; justify-content:space-between;"><span><i class="fas fa-align-left" style="color:var(--primary);"></i> Resolution Summary *</span> <span onclick="suggest('minutes')" style="color:var(--primary); cursor:pointer; font-size:0.75rem;"><i class="fas fa-wand-magic-sparkles"></i> Suggest Professional Summary</span></label>
                            <textarea name="minutes" id="p_minutes" rows="3" placeholder="Document the key discussions here..." required></textarea>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group">
                                <label style="display:flex; justify-content:space-between;"><span><i class="fas fa-users" style="color:var(--primary);"></i> Attendees</span> <span onclick="suggest('attendees')" style="color:var(--primary); cursor:pointer; font-size:0.75rem;"><i class="fas fa-wand-magic-sparkles"></i> Suggest List</span></label>
                                <textarea name="attendees" id="p_attendees" rows="3" placeholder="e.g. Sarpanch, Secretary, Ward Members..."></textarea>
                            </div>
                            <div class="form-group">
                                <label style="display:flex; justify-content:space-between;"><span><i class="fas fa-list-check" style="color:var(--primary);"></i> Agenda</span> <span onclick="suggest('agenda')" style="color:var(--primary); cursor:pointer; font-size:0.75rem;"><i class="fas fa-wand-magic-sparkles"></i> Suggest Topics</span></label>
                                <textarea name="agenda" id="p_agenda" rows="3" placeholder="List items discussed..."></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="display:flex; justify-content:space-between;"><span><i class="fas fa-file-signature" style="color:var(--primary);"></i> Formal Resolutions</span> <span onclick="suggest('resolutions')" style="color:var(--primary); cursor:pointer; font-size:0.75rem;"><i class="fas fa-wand-magic-sparkles"></i> Suggest Decisions</span></label>
                            <textarea name="resolutions" id="p_resolutions" rows="3" placeholder="List the final decisions/resolutions..."></textarea>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-paperclip" style="color:var(--primary);"></i> Final Signed Document (Optional PDF)</label>
                            <div style="position: relative; background: #fff; border: 2px dashed var(--gray-200); border-radius: 16px; padding: 1.5rem; text-align: center; display: flex; align-items: center; justify-content: center; gap: 20px;">
                                <input type="file" name="minutes_file" accept=".pdf,.jpg,.jpeg,.png" style="position: absolute; inset: 0; opacity: 0; cursor: pointer;">
                                <div style="text-align: left;">
                                    <i class="fas fa-cloud-upload-alt" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 5px;"></i>
                                    <p style="font-size: 0.8rem; color: #64748b; font-weight: 700;">Upload signed minutes</p>
                                </div>
                                <div style="border-left: 1px solid var(--gray-200); padding-left: 20px;">
                                    <img src="<?= base_url('public/assets/img/official_seal.png') ?>" id="seal_img" style="height: 80px; opacity: 0.8;" alt="Official Seal">
                                    <p id="seal_text" style="font-size: 0.65rem; color: var(--primary); font-weight: 800; margin-top: 4px;">AUTHORIZED SEAL</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div style="padding: 2rem 3rem; background: #f8fafc; border-top: 1px solid var(--gray-200); display: flex; gap: 1.5rem; justify-content: flex-end;">
                    <button type="button" onclick="closeModal()" style="padding: 1rem 2.5rem; background: white; border: 1.5px solid var(--gray-200); border-radius: 16px; font-weight: 800; cursor: pointer; color: #64748b; transition: 0.3s;"><i class="fas fa-times"></i> Discard</button>
                    <button type="submit" class="btn-premium" style="padding: 1rem 3rem; height: auto; font-size: 1.1rem;"><i class="fas fa-shield-check"></i> Finalize & Publish Assembly</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('modalTitle').innerText = "Record New Assembly";
            document.getElementById('p_id').value = "";
            document.getElementById('p_old_file').value = "";
            document.getElementById('p_meeting_id').value = "";
            document.getElementById('pModal').style.display = 'flex';
        }
        function closeModal() { document.getElementById('pModal').style.display = 'none'; }
        
        function safeEdit(btn) {
            const data = btn.dataset;
            document.getElementById('modalTitle').innerText = "Update Assembly Record";
            document.getElementById('p_id').value = data.id;
            document.getElementById('p_title').value = data.title;
            document.getElementById('p_date').value = data.date;
            document.getElementById('p_minutes').value = data.minutes;
            document.getElementById('p_attendees').value = data.attendees || "";
            document.getElementById('p_agenda').value = data.agenda || "";
            document.getElementById('p_resolutions').value = data.resolutions || "";
            document.getElementById('p_old_file').value = data.file || "";
            document.getElementById('p_meeting_id').value = data.meeting_id || "";
            document.getElementById('pModal').style.display = 'flex';
        }

        function applyTemplate(type) {
            const templates = {
                budget: { title: "Annual Budget Planning FY2026", minutes: "A formal assembly to discuss and approve the village expenditure plan for the upcoming financial year.", attendees: "Sarpanch, Secretary, All 7 Ward Members, Block Development Officer Assistant.", agenda: "1. Revenue Projections\n2. Road & Infrastructure Allocation\n3. Healthcare & Education Grants", resolutions: "Resolved to allocate INR 35 Lakhs for infrastructure and INR 10 Lakhs for sanitation.", img: 'budget_default.png' },
                infra: { title: "Infrastructure Development Meeting", minutes: "Detailed discussion on ongoing road construction and new water tank projects.", attendees: "Sarpanch, Ward 1-3 Members, JE (Public Works), Local Contractors.", agenda: "1. Road Quality Audit\n2. Water Pipeline Expansion Plan\n3. Street Light Maintenance", resolutions: "Contract awarded for Ward 2 main road to M/S BuildRight. Pipeline work to start by next Monday.", img: 'infra_default.png' },
                audit: { title: "Quarterly Scheme Audit Assembly", minutes: "Reviewing the implementation of central and state welfare schemes within the village.", attendees: "Secretary Anita, Sarpanch Rajesh, Scheme Beneficiaries (Group A).", agenda: "1. PM Awas Yojana Progress\n2. Pension Distribution Verification\n3. Ration Card Renewal Drive", resolutions: "Approved 12 new housing applications. Resolved to conduct a special camp for pension KYC next Saturday.", img: 'assembly_branding.png' },
                agri: { title: "Farmers Welfare & Krishi Assembly", minutes: "Assembly dedicated to discussing crop subsidies, irrigation facilities, and Mandi access.", attendees: "Panchayat Council, Block Agriculture Officer, Local Farmer Union Reps.", agenda: "1. Distribution of subsidized seeds\n2. Irrigation canal maintenance schedule\n3. Setting up of Mandi help-desk", resolutions: "Resolved to setup a temporary Krishi Help-desk. Approved repair budget for the north-side irrigation canal.", img: 'agri_default.png' },
                health: { title: "Public Health & Vaccination Camp Planning", minutes: "Coordinating upcoming health drives and improving access to medical facilities.", attendees: "Sarpanch, PHC Doctor, ASHA workers, Ward Members.", agenda: "1. Polio/COVID vaccination schedule\n2. Review of Primary Health Center supply\n3. Cleanliness drive for malaria prevention", resolutions: "Approved a 3-day health camp starting next month. Resolved to hire 2 additional sanitation cleaners for the PHC surroundings.", img: 'health_default.png' },
                edu: { title: "Education & Primary School Committee Meeting", minutes: "Focusing on infrastructure improvements for the village school and community library.", attendees: "School Management Committee, Sarpanch, Secretary, Parents Association.", agenda: "1. School building repair works\n2. Provision of new library books\n3. Mid-day meal quality audit", resolutions: "Allocated funds for school roof repair. Resolved to purchase 50 new reference books for the community library.", img: 'edu_default.png' },
                water: { title: "Water Management & Sanitation Drive", minutes: "Action plan for ensuring 24/7 drinking water and improving village sanitation.", attendees: "Pani Samiti (Water Committee), Sarpanch, Ward Members.", agenda: "1. New borewell site selection\n2. Drain cleaning schedule\n3. Garbage collection fees review", resolutions: "Finalized site for new borewell in Ward 4. Resolved to implement bi-weekly drain cleaning starting next week.", img: 'water_default.png' },
                welfare: { title: "Social Welfare & Pension Distribution Review", minutes: "Reviewing the status of old-age pensions, housing schemes, and women empowerment projects.", attendees: "Sarpanch, Social Welfare Officer, Ward 1-7 Representatives.", agenda: "1. Old-age pension verification\n2. PM Awas Yojana beneficiary audit\n3. Self-Help Group (SHG) funding", resolutions: "Approved 8 new pension applications. Allocated workspace for the village Women SHG in the community hall.", img: 'welfare_default.png' }
            };
            if(templates[type]) {
                document.getElementById('p_title').value = templates[type].title;
                document.getElementById('p_minutes').value = templates[type].minutes;
                document.getElementById('p_attendees').value = templates[type].attendees;
                document.getElementById('p_agenda').value = templates[type].agenda;
                document.getElementById('p_resolutions').value = templates[type].resolutions;
                updatePreview(templates[type].img);
            }
        }

        function updatePreview(imgName) {
            const url = "<?= base_url('public/assets/img/') ?>/" + imgName;
            document.getElementById('seal_img').src = url;
            document.getElementById('seal_text').innerText = "AUTO-SUGGESTED VISUAL";
            document.getElementById('seal_text').style.color = "#10b981";
        }

        // Auto-detect image based on title typing
        document.getElementById('p_title').addEventListener('input', function(e) {
            const val = e.target.value.toLowerCase();
            if (val.includes('budget')) updatePreview('budget_default.png');
            else if (val.includes('infra') || val.includes('road') || val.includes('construction')) updatePreview('infra_default.png');
            else if (val.includes('agri') || val.includes('farmer') || val.includes('krishi')) updatePreview('agri_default.png');
            else if (val.includes('health') || val.includes('vaccine') || val.includes('medical')) updatePreview('health_default.png');
            else if (val.includes('edu') || val.includes('school') || val.includes('library')) updatePreview('edu_default.png');
            else if (val.includes('water') || val.includes('toilet') || val.includes('sanitation')) updatePreview('water_default.png');
            else if (val.includes('welfare') || val.includes('pension') || val.includes('social')) updatePreview('welfare_default.png');
            else updatePreview('official_seal.png');
        });

        function suggest(field) {
            const currentTitle = document.getElementById('p_title').value.toLowerCase();
            let text = "";
            
            if (field === 'minutes') {
                text = currentTitle.includes('budget') ? "Budgetary review meeting to finalize upcoming fiscal priorities and community financial roadmaps." : "Comprehensive community assembly to address grievance resolutions and general developmental agendas.";
            } else if (field === 'attendees') {
                text = "Sarpanch, Gram Panchayat Secretary, Ward Councilors (1 through 7), and Invited Community Elders.";
            } else if (field === 'agenda') {
                text = currentTitle.includes('budget') ? "1. Balance Sheet Review\n2. Proposed Project Allocations\n3. Emergency Reserves Approval" : "1. Public Sanitation Audit\n2. Street Lighting Upgrades\n3. Community Hall Maintenance";
            } else if (field === 'resolutions') {
                text = "Resolved by unanimous vote to proceed with the proposed actions as documented in the minutes summary. Final approval granted by the Sarpanch.";
            }
            document.getElementById('p_' + field).value = text;
        }

        <?php if(isset($prefill) && $prefill): ?>
        window.onload = function() {
            document.getElementById('modalTitle').innerText = "Recording Minutes for: <?= esc($prefill['title']) ?>";
            document.getElementById('p_meeting_id').value = "<?= $prefill['id'] ?>";
            document.getElementById('p_title').value = "<?= esc($prefill['title']) ?>";
            document.getElementById('p_date').value = "<?= $prefill['meeting_date'] ?>";
            document.getElementById('p_agenda').value = "<?= esc($prefill['agenda']) ?>";
            document.getElementById('pModal').style.display = 'flex';
        }
        <?php endif; ?>

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Ledger Updated!', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#6366f1', borderRadius: '30px' });
        <?php endif; ?>
    </script>
</body>
</html>
