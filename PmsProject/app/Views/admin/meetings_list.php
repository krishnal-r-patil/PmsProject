<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Management - Gram Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }
        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; display: flex; align-items: center; gap: 10px; color: white; text-decoration: none; }
        .sidebar-brand span { color: var(--primary); }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 0.8rem 1rem; color: #94a3b8; text-decoration: none; border-radius: 8px; transition: all 0.3s; margin-bottom: 0.5rem; font-size: 0.9rem; }
        .nav-link:hover, .nav-link.active { background-color: #334155; color: white; }
        .nav-link.active { background-color: var(--primary); }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); padding: 2.5rem; }
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; }
        .meeting-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 1.5rem; }
        .meeting-card { background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border-top: 5px solid var(--primary); }
        .meeting-date { display: inline-block; padding: 6px 15px; background: #eff6ff; color: var(--primary); border-radius: 20px; font-weight: 700; font-size: 0.8rem; margin-bottom: 1rem; }
        .meeting-title { font-size: 1.4rem; font-weight: 700; color: var(--dark); margin-bottom: 0.5rem; }
        .meeting-type { font-size: 0.85rem; color: var(--gray-700); margin-bottom: 1.5rem; font-weight: 600; text-transform: uppercase; }
        .meeting-info { display: flex; gap: 20px; font-size: 0.9rem; margin-bottom: 1.5rem; }
        .info-item { display: flex; align-items: center; gap: 8px; color: var(--gray-700); }
        .agenda-box { background: var(--gray-100); padding: 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; }
        .btn-add { background: var(--primary); color: white; padding: 0.8rem 1.5rem; border-radius: 10px; text-decoration: none; font-weight: 600; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="sidebar">
        <?= view('admin/partials/sidebar') ?>
    </div>
    <div class="main-content">
        <div class="header-actions">
            <div>
                <h1>Meeting & Resolution Mgmt</h1>
                <p>Scheduling Gram Sabha, Ward Sabha and Committee Meetings</p>
            </div>
            <button class="btn-add" onclick="openMeetingModal()"><i class="fas fa-plus"></i> Schedule Meeting</button>
        </div>
        <div class="meeting-grid">
            <?php foreach($meetings as $m): ?>
            <div class="meeting-card" style="position: relative;">
                <div style="position: absolute; top: 15px; right: 15px; display: flex; gap: 8px;">
                    <button onclick="editMeeting(<?= htmlspecialchars(json_encode($m)) ?>)" style="border:none; background:none; cursor:pointer; color: #94a3b8;"><i class="fas fa-pencil"></i></button>
                    <button onclick="confirmDelete('<?= base_url('admin/meetings/delete/'.$m['id']) ?>')" style="border:none; background:none; cursor:pointer; color: #ef4444;"><i class="fas fa-trash"></i></button>
                </div>
                <span class="meeting-date"><?= date('D, d M Y', strtotime($m['meeting_date'])) ?></span>
                <div class="meeting-title"><?= esc($m['title']) ?></div>
                <div class="meeting-type"><?= esc($m['meeting_type']) ?></div>
                <div class="meeting-info">
                    <div class="info-item"><i class="fas fa-map-marker-alt"></i> <?= esc($m['venue']) ?></div>
                    <div class="info-item"><i class="fas fa-circle-info" style="color: <?= $m['status'] == 'Scheduled' ? '#2563eb' : ($m['status'] == 'Completed' ? '#059669' : '#dc2626') ?>"></i> <?= $m['status'] ?></div>
                </div>
                <div class="agenda-box">
                    <strong style="font-size: 0.8rem; display: block; margin-bottom: 5px; color: var(--gray-700);">AGENDA</strong>
                    <p style="font-size: 0.95rem; line-height: 1.5;"><?= esc($m['agenda']) ?></p>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <a href="<?= base_url('admin/proceedings?meeting_id='.$m['id']) ?>" style="color: var(--primary); font-weight: 700; text-decoration: none; font-size: 0.9rem;">
                        <i class="fas fa-file-pen"></i> Record Minutes & Resolutions
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal -->
    <div id="meetingModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; padding: 2rem;">
        <div style="background: white; width: 100%; max-width: 550px; border-radius: 20px; overflow: hidden;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
                <h2 id="modalTitle" style="font-size: 1.25rem; font-weight: 800;">Schedule New Assembly</h2>
                <button onclick="closeMeetingModal()" style="border:none; background:none; font-size: 1.5rem; cursor:pointer;">&times;</button>
            </div>
            <form action="<?= base_url('admin/meetings/save') ?>" method="POST" style="padding: 1.5rem;">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="meetingId">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.4rem; font-weight: 700; font-size: 0.8rem;">Meeting Title *</label>
                    <input type="text" name="title" id="meetingTitle" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 10px;">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.4rem; font-weight: 700; font-size: 0.8rem;">Date *</label>
                        <input type="date" name="meeting_date" id="meetingDate" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 10px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.4rem; font-weight: 700; font-size: 0.8rem;">Assembly Type</label>
                        <select name="meeting_type" id="meetingType" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 10px;">
                            <option value="Gram Sabha">Gram Sabha</option>
                            <option value="Ward Sabha">Ward Sabha</option>
                            <option value="Committee Meeting">Committee Meeting</option>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.4rem; font-weight: 700; font-size: 0.8rem;">Venue / Location *</label>
                    <input type="text" name="venue" id="meetingVenue" required placeholder="e.g. Panchayat Bhawan" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 10px;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.4rem; font-weight: 700; font-size: 0.8rem;">Primary Agenda</label>
                    <textarea name="agenda" id="meetingAgenda" rows="3" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 10px;"></textarea>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.4rem; font-weight: 700; font-size: 0.8rem;">Status</label>
                    <select name="status" id="meetingStatus" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 10px;">
                        <option value="Scheduled">Scheduled</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <button type="submit" style="width: 100%; padding: 1rem; background: var(--primary); color: white; border: none; border-radius: 12px; font-weight: 800; cursor: pointer;">Finalize Schedule</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openMeetingModal() {
            document.getElementById('modalTitle').innerText = "Schedule New Assembly";
            document.getElementById('meetingId').value = "";
            document.getElementById('meetingTitle').value = "";
            document.getElementById('meetingDate').value = "";
            document.getElementById('meetingVenue').value = "";
            document.getElementById('meetingAgenda').value = "";
            document.getElementById('meetingModal').style.display = 'flex';
        }

        function editMeeting(m) {
            document.getElementById('modalTitle').innerText = "Update Meeting Details";
            document.getElementById('meetingId').value = m.id;
            document.getElementById('meetingTitle').value = m.title;
            document.getElementById('meetingDate').value = m.meeting_date;
            document.getElementById('meetingType').value = m.meeting_type;
            document.getElementById('meetingVenue').value = m.venue;
            document.getElementById('meetingAgenda').value = m.agenda;
            document.getElementById('meetingStatus').value = m.status;
            document.getElementById('meetingModal').style.display = 'flex';
        }

        function closeMeetingModal() { document.getElementById('meetingModal').style.display = 'none'; }

        function confirmDelete(url) {
            Swal.fire({
                title: 'Cancel & Remove Meeting?',
                text: "This will permanently remove the record from the upcoming calendar.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Yes, Remove'
            }).then((result) => {
                if (result.isConfirmed) { window.location.href = url; }
            });
        }

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Action Recorded', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#2563eb' });
        <?php endif; ?>
    </script>
</body>
</html>

