<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Operations Desk - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #ef4444; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }
        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 90; }
        .content-padding { padding: 3rem; }

        .broadcast-card { background: white; border-radius: 28px; border: 1px solid #e2e8f0; padding: 2rem; margin-bottom: 2.5rem; position: relative; overflow: hidden; }
        .broadcast-card::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 6px; background: var(--primary); }

        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-size: 0.8rem; font-weight: 800; color: #64748b; text-transform: uppercase; }
        input, select, textarea { width: 100%; padding: 0.9rem; border: 1px solid #e2e8f0; border-radius: 12px; outline: none; }
        .btn-broadcast { padding: 1rem 2rem; background: var(--primary); color: white; border: none; border-radius: 12px; font-weight: 800; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: 0.3s; }
        .btn-broadcast:hover { background: #b91c1c; transform: scale(1.02); }

        .alert-row { background: white; padding: 1.2rem; border-radius: 15px; border: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; transition: 0.3s; }
        .alert-row:hover { border-color: var(--primary); }
        .severity-badge { padding: 4px 10px; border-radius: 50px; font-size: 0.65rem; font-weight: 800; }
        .sev-Critical { background: #fee2e2; color: #ef4444; }
        .sev-High { background: #fffbeb; color: #d97706; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800;"><i class="fas fa-bullhorn" style="color: var(--primary);"></i> Emergency Control Station</div>
            <div style="background: #fef2f2; color: #ef4444; padding: 6px 15px; border-radius: 50px; font-size: 0.8rem; font-weight: 800;">
                <i class="fas fa-satellite-dish"></i> Broadcast Live
            </div>
        </header>

        <div class="content-padding">
            <div style="display: grid; grid-template-columns: 350px 1fr; gap: 2.5rem; align-items: start;">
                <!-- LEFT: FORM SECTION -->
                <div style="position: sticky; top: 100px;">
                    <div class="broadcast-card" style="padding: 1.5rem;">
                        <h2 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 1.5rem;">Issue Mass Alert</h2>
                        <form action="<?= base_url('admin/emergency/alert/save') ?>" method="POST">
                            <?= csrf_field() ?>
                            <div class="form-group">
                                <label>Alert Title</label>
                                <input type="text" name="title" placeholder="e.g. Cyclone Warning" required>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="type">
                                        <option value="Health">Health Warning</option>
                                        <option value="Weather">Weather Emergency</option>
                                        <option value="Public Safety">Public Safety</option>
                                        <option value="Traffic/Road">Road Closure</option>
                                        <option value="Utility">Power/Water Cut</option>
                                        <option value="General">General News</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Severity</label>
                                    <select name="severity">
                                        <option value="Low">Low</option>
                                        <option value="Medium">Medium</option>
                                        <option value="High">High</option>
                                        <option value="Critical">Critical</option>
                                    </select>
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <div class="form-group">
                                    <label>Target Ward</label>
                                    <select name="ward_no">
                                        <option value="All">All Village</option>
                                        <option value="Ward 01">Ward 01</option>
                                        <option value="Ward 02">Ward 02</option>
                                        <option value="Ward 03">Ward 03</option>
                                        <option value="Ward 04">Ward 04</option>
                                        <option value="Ward 05">Ward 05</option>
                                        <option value="Ward 06">Ward 06</option>
                                        <option value="Ward 07">Ward 07</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Auto-Expiry</label>
                                    <input type="datetime-local" name="expiry_date">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Detailed Message</label>
                                <textarea name="message" rows="3" placeholder="Provide clear instructions..." required></textarea>
                            </div>
                            <button type="submit" class="btn-broadcast" style="width: 100%;"><i class="fas fa-paper-plane"></i> Dispatch Alert</button>
                        </form>
                    </div>

                    <div class="broadcast-card" style="padding: 1.5rem; border-color: #10b981; background: #f0fdf4;">
                        <h2 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 1.5rem; color: #065f46;">Add to Directory</h2>
                        <form action="<?= base_url('admin/emergency/directory/save') ?>" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" id="dir_id">
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category" id="dir_category" onchange="toggleBloodGroup()" required>
                                    <option value="Hospital">Hospital</option>
                                    <option value="Ambulance">Ambulance</option>
                                    <option value="Blood Donor">Blood Donor</option>
                                    <option value="Pharmacy">Pharmacy</option>
                                    <option value="Oxygen Supply">Medical Oxygen</option>
                                    <option value="Veterinary">Veterinary Clinic</option>
                                    <option value="Old Age Home">Old Age Home</option>
                                    <option value="Fire Station">Fire Station</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Full Name / Title</label>
                                <input type="text" name="name" id="dir_name" placeholder="Name" required>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input type="text" name="contact_no" id="dir_phone" placeholder="Phone" required>
                                </div>
                                <div class="form-group">
                                    <label>Service Hours</label>
                                    <input type="text" name="service_hours" id="dir_hours" placeholder="e.g. 24/7" value="24/7">
                                </div>
                            </div>
                            <div class="form-group" id="blood_group_div" style="display: none;">
                                <label>Blood Group</label>
                                <select name="blood_group" id="dir_blood">
                                    <option value="">N/A</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Map Link / Capacity Info</label>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                    <input type="text" name="map_link" id="dir_map" placeholder="Google Maps URL">
                                    <input type="text" name="available_capacity" id="dir_capacity" placeholder="Beds/Stock Level">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Address & Website</label>
                                <input type="text" name="address" id="dir_address" placeholder="Physical Address" style="margin-bottom: 8px;">
                                <input type="url" name="website" id="dir_website" placeholder="https://website.com (Optional)">
                            </div>
                            <button type="submit" class="btn-broadcast" style="width: 100%; background: #10b981;"><i class="fas fa-plus-circle"></i> Save to Official Directory</button>
                        </form>
                    </div>
                </div>

                <!-- RIGHT: LIST SECTION -->
                <div>
                    <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1.5rem;">Recent Alert Broadcasts</h2>
                    <div class="alert-list" style="margin-bottom: 3rem;">
                        <?php if(empty($alerts)): ?>
                            <div style="padding: 2rem; text-align: center; color: #94a3b8; background: white; border-radius: 15px;">No alerts issued yet.</div>
                        <?php endif; ?>
                        <?php foreach($alerts as $a): ?>
                        <div class="alert-row">
                            <div style="display: flex; gap: 15px; align-items: center;">
                                <span class="severity-badge sev-<?= $a['severity'] ?>"><?= $a['severity'] ?></span>
                                <div>
                                    <div style="font-weight: 800; color: var(--dark);"><?= esc($a['title']) ?></div>
                                    <div style="font-size: 0.8rem; color: #64748b;"><?= date('d M Y, H:i', strtotime($a['created_at'])) ?> | <?= $a['type'] ?></div>
                                </div>
                            </div>
                             <a href="javascript:void(0)" onclick="askConfirm('<?= base_url('admin/emergency/alert/delete/'.$a['id']) ?>', 'Delete this alert?')" style="color: #94a3b8; font-size: 1.1rem;"><i class="fas fa-trash-alt"></i></a>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1.5rem;">Emergency Health Directory</h2>
                    <div class="directory-list">
                        <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                            <thead>
                                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                    <th style="text-align: left; padding: 1.2rem; font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Category</th>
                                    <th style="text-align: left; padding: 1.2rem; font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Name</th>
                                    <th style="text-align: left; padding: 1.2rem; font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Contact & Location</th>
                                    <th style="text-align: center; padding: 1.2rem; font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($directory as $item): ?>
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                                    <td style="padding: 1.2rem;">
                                        <span style="font-size: 0.7rem; font-weight: 800; padding: 4px 10px; border-radius: 50px; background: #f1f5f9; color: #475569;">
                                            <i class="fas <?= $item['category'] == 'Hospital' ? 'fa-hospital' : ($item['category'] == 'Ambulance' ? 'fa-ambulance' : 'fa-tint') ?>"></i> <?= $item['category'] ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1.2rem;">
                                        <div style="font-weight: 800; color: var(--dark);"><?= esc($item['name']) ?></div>
                                        <?php if($item['blood_group']): ?>
                                            <span style="color: #ef4444; font-weight: 900; font-size: 0.8rem;">Group: <?= $item['blood_group'] ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1.2rem;">
                                        <div style="font-weight: 700; color: #ef4444;"><?= esc($item['contact_no']) ?></div>
                                        <div style="font-size: 0.75rem; color: #64748b;"><?= esc($item['address']) ?></div>
                                    </td>
                                    <td style="padding: 1.2rem; text-align: center;">
                                        <div style="display: flex; gap: 10px; justify-content: center;">
                                            <button onclick="editItem(<?= htmlspecialchars(json_encode($item)) ?>)" style="background: none; border: none; color: #10b981; cursor: pointer; font-size: 1.1rem;"><i class="fas fa-edit"></i></button>
                                             <a href="javascript:void(0)" onclick="askConfirm('<?= base_url('admin/emergency/directory/delete/'.$item['id']) ?>', 'Delete this contact?')" style="color: #94a3b8; font-size: 1.1rem;"><i class="fas fa-trash-alt"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleBloodGroup() {
            const cat = document.getElementById('dir_category').value;
            const div = document.getElementById('blood_group_div');
            div.style.display = (cat === 'Blood Donor') ? 'block' : 'none';
        }

        function editItem(item) {
            document.getElementById('dir_id').value = item.id;
            document.getElementById('dir_category').value = item.category;
            document.getElementById('dir_name').value = item.name;
            document.getElementById('dir_phone').value = item.contact_no;
            document.getElementById('dir_address').value = item.address;
            document.getElementById('dir_hours').value = item.service_hours;
            document.getElementById('dir_blood').value = item.blood_group || '';
            document.getElementById('dir_map').value = item.map_link || '';
            document.getElementById('dir_capacity').value = item.available_capacity || '';
            document.getElementById('dir_website').value = item.website || '';
            
            toggleBloodGroup();
            
            // Scroll to form
            document.getElementById('dir_category').scrollIntoView({ behavior: 'smooth' });
        }

        function askConfirm(url, msg) {
            Swal.fire({
                title: msg,
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Delete',
                borderRadius: '20px'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Action Successful', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#10b981' });
        <?php endif; ?>
    </script>
</body>
</html>
