<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citizen Dashboard - Panchayat Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #2563eb;
            --dark: #0f172a;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-700: #334155;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        /* Sidebar Styles (Matching Admin) */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--dark);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            color: white;
            padding: 1.5rem;
            z-index: 100;
            overflow-y: auto;
        }

        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            text-decoration: none;
        }
        .sidebar-brand span { color: var(--primary); }

        .nav-menu { list-style: none; }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.8rem 1rem;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
            margin-bottom: 0.5rem;
        }
        .nav-link:hover, .nav-link.active { background-color: #334155; color: white; }
        .nav-link.active { background-color: var(--primary); }

        .badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; display: inline-block; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-approved { background: #dcfce7; color: #166534; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
        }

        header {
            background-color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .content-body { padding: 2rem; }

        /* Dashboard Overview cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .stat-icon { width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; background: #eff6ff; color: var(--primary); }

        /* Application Status Table */
        .table-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th { text-align: left; padding: 1rem; background: var(--gray-100); color: var(--gray-700); font-size: 0.85rem; }
        td { padding: 1rem; border-bottom: 1px solid var(--gray-200); font-size: 0.95rem; }

        .badge { padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-approved { background: #d1fae5; color: #065f46; }
    </style>
</head>
<body>

    <div class="sidebar">
        <?= view('user/partials/sidebar') ?>
    </div>

    <div class="main-content">
        <header>
            <div style="font-weight: 600; color: var(--gray-700);">Citizen Portal Access</div>
            <div style="display: flex; align-items: center; gap: 10px;">
                <span>Welcome, <strong><?= session()->get('user_name') ?></strong></span>
                <div style="width: 35px; height: 35px; background: var(--gray-200); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800;"><?= substr(session()->get('user_name'), 0, 1) ?></div>
            </div>
        </header>

        <div class="content-body">
            <!-- Emergency Broadcast System -->
            <?php if(!empty($broadcast_alerts)): ?>
                <?php foreach($broadcast_alerts as $alert): 
                    $color = '#2563eb'; $bg = '#eff6ff'; $icon = 'fa-info-circle';
                    if($alert['severity'] === 'High') { $color = '#ef4444'; $bg = '#fef2f2'; $icon = 'fa-exclamation-triangle'; }
                    elseif($alert['severity'] === 'Medium') { $color = '#f59e0b'; $bg = '#fffbeb'; $icon = 'fa-bullhorn'; }
                ?>
                <div style="background: <?= $bg ?>; border: 1px solid <?= $color ?>; color: <?= $color ?>; padding: 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: start; gap: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border-left: 10px solid <?= $color ?>;">
                    <div style="font-size: 2rem; margin-top: 5px;"><i class="fas <?= $icon ?>"></i></div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                             <h3 style="font-weight: 800; font-size: 1.1rem; text-transform: uppercase;"><?= esc($alert['title']) ?></h3>
                             <span style="font-size: 0.7rem; font-weight: 700; opacity: 0.8;"><?= date('d M, H:i', strtotime($alert['created_at'])) ?></span>
                        </div>
                        <p style="font-size: 0.95rem; margin-top: 5px; font-weight: 500; line-height: 1.4;"><?= esc($alert['message']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <h1 style="margin-bottom: 2rem;">Digital Dashboard</h1>

            <!-- User Profile Information Card -->
            <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 2rem; border-left: 5px solid var(--primary);">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem;">
                    <div>
                        <h2 style="font-size: 1.4rem; color: var(--dark);"><i class="fas fa-id-card" style="margin-right: 10px; color: var(--primary);"></i> My Registered Profile</h2>
                        <p style="color: var(--gray-700); font-size: 0.85rem;">Official records as per Gram Panchayat Register</p>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
                    <div>
                        <p style="color: #64748b; font-size: 0.75rem; text-transform: uppercase; font-weight: 700; margin-bottom: 5px;">Citizen Name</p>
                        <p style="font-weight: 700; color: var(--dark);"><?= $citizen['name'] ?></p>
                        <p style="font-size: 0.8rem; color: #64748b; margin-top: 5px;">S/O: <?= $citizen['father_name'] ?></p>
                    </div>
                    <div>
                        <p style="color: #64748b; font-size: 0.75rem; text-transform: uppercase; font-weight: 700; margin-bottom: 5px;">Family ID</p>
                        <p style="font-weight: 700; color: var(--primary); font-family: monospace;"><?= $citizen['family_id'] ?></p>
                    </div>
                    <div>
                        <p style="color: #64748b; font-size: 0.75rem; text-transform: uppercase; font-weight: 700; margin-bottom: 5px;">Document Details</p>
                        <p style="font-weight: 600;"><i class="fas fa-fingerprint" style="margin-right: 5px; color: #94a3b8;"></i> <?= $citizen['aadhar_no'] ?></p>
                        <p style="font-size: 0.85rem; margin-top: 5px;"><i class="fas fa-phone" style="margin-right: 5px; color: #94a3b8;"></i> <?= $citizen['phone'] ?></p>
                    </div>
                    <div>
                        <p style="color: #64748b; font-size: 0.75rem; text-transform: uppercase; font-weight: 700; margin-bottom: 5px;">Resident Status</p>
                        <p style="font-weight: 600;">Ward <?= $citizen['ward_no'] ?>, <?= $citizen['village'] ?></p>
                        <span style="font-size: 0.75rem; background: #eff6ff; color: var(--primary); padding: 2px 8px; border-radius: 4px; font-weight: 700; display: inline-block; margin-top: 5px;"><?= $citizen['category'] ?></span>
                    </div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-file-invoice"></i></div>
                    <div>
                        <p style="color: #64748b; font-size: 0.85rem;">Pending Applications</p>
                        <h3 style="font-size: 1.5rem;">0<?= count($applications) ?></h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #fef2f2; color: #ef4444;"><i class="fas fa-exclamation-triangle"></i></div>
                    <div>
                        <p style="color: #64748b; font-size: 0.85rem;">Active Grievances</p>
                        <h3 style="font-size: 1.5rem;">0<?= count($grievances) ?></h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #ecfdf5; color: #10b981;"><i class="fas fa-rupee-sign"></i></div>
                    <div>
                        <p style="color: #64748b; font-size: 0.85rem;">Unpaid Taxes</p>
                        <h3 style="font-size: 1.5rem;">₹<?= $total_taxes_unpaid * 150 ?></h3>
                    </div>
                </div>
            </div>

            <!-- Digital Services Hub -->
            <h2 style="font-size: 1.4rem; margin-bottom: 1.5rem; color: var(--dark);"><i class="fas fa-th-large" style="margin-right: 10px; color: var(--primary);"></i> Digital Services Hub</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
                <a href="<?= base_url('user/certificates') ?>" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; text-decoration: none; transition: 0.3s; color: inherit; border-top: 4px solid var(--primary);">
                    <div style="width: 60px; height: 60px; background: #eff6ff; color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1.2rem;"><i class="fas fa-file-contract"></i></div>
                    <h3 style="color: var(--dark); font-size: 1.1rem; margin-bottom: 0.5rem;">Apply Certificates</h3>
                    <p style="color: #64748b; font-size: 0.85rem;">Birth, Death, Income, or Residency certificates.</p>
                </a>
                
                <a href="<?= base_url('user/schemes') ?>" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; text-decoration: none; transition: 0.3s; color: inherit; border-top: 4px solid #10b981;">
                    <div style="width: 60px; height: 60px; background: #ecfdf5; color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1.2rem;"><i class="fas fa-award"></i></div>
                    <h3 style="color: var(--dark); font-size: 1.1rem; margin-bottom: 0.5rem;">Welfare Schemes</h3>
                    <p style="color: #64748b; font-size: 0.85rem;">Explore benefit programs for Farmers, Students, etc.</p>
                </a>

                <a href="<?= base_url('user/grievances') ?>" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; text-decoration: none; transition: 0.3s; color: inherit; border-top: 4px solid #ef4444;">
                    <div style="width: 60px; height: 60px; background: #fef2f2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1.2rem;"><i class="fas fa-exclamation-circle"></i></div>
                    <h3 style="color: var(--dark); font-size: 1.1rem; margin-bottom: 0.5rem;">Online Complaints</h3>
                    <p style="color: #64748b; font-size: 0.85rem;">Lodge complaints for Water, Road, or Light issues.</p>
                </a>

                <a href="<?= base_url('user/permissions') ?>" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; text-decoration: none; transition: 0.3s; color: inherit; border-top: 4px solid #8b5cf6;">
                    <div style="width: 60px; height: 60px; background: #f5f3ff; color: #8b5cf6; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1.2rem;"><i class="fas fa-handshake"></i></div>
                    <h3 style="color: var(--dark); font-size: 1.1rem; margin-bottom: 0.5rem;">Work/Event Permission</h3>
                    <p style="color: #64748b; font-size: 0.85rem;">Apply for events, social gatherings, or construction.</p>
                </a>

                <a href="<?= base_url('user/pay-taxes') ?>" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; text-decoration: none; transition: 0.3s; color: inherit; border-top: 4px solid #f59e0b;">
                    <div style="width: 60px; height: 60px; background: #fff7ed; color: #f59e0b; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1.2rem;"><i class="fas fa-rupee-sign"></i></div>
                    <h3 style="color: var(--dark); font-size: 1.1rem; margin-bottom: 0.5rem;">Pay Taxes Online</h3>
                    <p style="color: #64748b; font-size: 0.85rem;">Property taxes, water charges, and trade license.</p>
                </a>

                <a href="<?= base_url('user/marketplace') ?>" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; text-decoration: none; transition: 0.3s; color: inherit; border-top: 4px solid #10b981;">
                    <div style="width: 60px; height: 60px; background: #ecfdf5; color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1.2rem;"><i class="fas fa-store"></i></div>
                    <h3 style="color: var(--dark); font-size: 1.1rem; margin-bottom: 0.5rem;">Village Bazaar</h3>
                    <p style="color: #64748b; font-size: 0.85rem;">"Vocal for Local" - Buy/Sell local village products.</p>
                </a>

                <a href="<?= base_url('user/utilities') ?>" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; text-decoration: none; transition: 0.3s; color: inherit; border-top: 4px solid #3b82f6;">
                    <div style="width: 60px; height: 60px; background: #eff6ff; color: #3b82f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1.2rem;"><i class="fas fa-bolt"></i></div>
                    <h3 style="color: var(--dark); font-size: 1.1rem; margin-bottom: 0.5rem;">Utility Connections</h3>
                    <p style="color: #64748b; font-size: 0.85rem;">Electricity, Water, Gas & Internet Connections.</p>
                </a>

                <a href="<?= base_url('user/village-map') ?>" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; text-decoration: none; transition: 0.3s; color: inherit; border-top: 4px solid #f97316; grid-column: span 1;">
                    <div style="width: 60px; height: 60px; background: #fff7ed; color: #f97316; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1.2rem;"><i class="fas fa-map-marked-alt"></i></div>
                    <h3 style="color: var(--dark); font-size: 1.1rem; margin-bottom: 0.5rem;">Village GIS Hub</h3>
                    <p style="color: #64748b; font-size: 0.85rem;">Explore infrastructure, schools & healthcare on map.</p>
                </a>

                <a href="<?= base_url('user/elearning') ?>" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; text-decoration: none; transition: 0.3s; color: inherit; border-top: 4px solid #6366f1;">
                    <div style="width: 60px; height: 60px; background: #eef2ff; color: #6366f1; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1.2rem;"><i class="fas fa-graduation-cap"></i></div>
                    <h3 style="color: var(--dark); font-size: 1.1rem; margin-bottom: 0.5rem;">E-Learning & Skills</h3>
                    <p style="color: #64748b; font-size: 0.85rem;">Scholarships, online courses & vocational training.</p>
                </a>

                <a href="<?= base_url('user/staff-directory') ?>" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; text-decoration: none; transition: 0.3s; color: inherit; border-top: 4px solid #4b5563;">
                    <div style="width: 60px; height: 60px; background: #f3f4f6; color: #374151; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1.2rem;"><i class="fas fa-id-badge"></i></div>
                    <h3 style="color: var(--dark); font-size: 1.1rem; margin-bottom: 0.5rem;">Staff Directory</h3>
                    <p style="color: #64748b; font-size: 0.85rem;">Contact details of Gram Panchayat officials & staff.</p>
                </a>
            </div>

            <!-- Issued Certificates Section -->
            <?php if(!empty($issued_certificates)): ?>
            <div class="table-section" style="margin-bottom: 2rem; border-top: 4px solid #10b981;">
                <h2 style="color: #065f46;"><i class="fas fa-file-pdf" style="margin-right: 10px;"></i> My Issued Certificates</h2>
                <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 1rem;">The following official documents have been issued to you by the Gram Panchayat office.</p>
                <table>
                    <thead>
                        <tr>
                            <th>Reg No</th>
                            <th>Certificate Type</th>
                            <th>Person Name</th>
                            <th>Issued Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($issued_certificates as $cert): ?>
                        <tr>
                            <td style="font-family: monospace; font-weight: 700;"><?= $cert['registration_no'] ?></td>
                            <td><strong><?= $cert['type'] ?> Certificate</strong></td>
                            <td><?= $cert['person_name'] ?></td>
                            <td><?= date('d M Y', strtotime($cert['created_at'])) ?></td>
                            <td>
                                <a href="<?= base_url('user/certificate/view/'.$cert['id']) ?>" target="_blank" style="background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 700;">
                                    <i class="fas fa-download"></i> View / Download
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>

            <div class="table-section">
                <h2>Application Status Tracking</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Service Type</th>
                            <th>Applied At</th>
                            <th>Current Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($applications as $app): ?>
                        <tr>
                            <td style="font-weight: 600;"><?= $app['service_type'] ?></td>
                            <td><?= date('d M Y', strtotime($app['applied_at'])) ?></td>
                                <td>
                                    <span class="badge badge-<?= strtolower($app['status']) ?>"><?= $app['status'] ?></span>
                                    <?php if($app['status'] == 'Rejected'): ?>
                                        <div style="background: #fff1f2; color: #991b1b; padding: 8px; border-radius: 6px; font-size: 0.75rem; margin-top: 8px; border-left: 3px solid #ef4444;">
                                            <i class="fas fa-comment-dots"></i> <strong>Admin Note:</strong><br>
                                            <?= esc($app['remarks'] ?: 'No specific reason provided.') ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($app['status'] == 'Approved' && !empty($app['certificate_id'])): ?>
                                        <a href="<?= base_url('user/certificate/view/'.$app['certificate_id']) ?>" target="_blank" style="background: #2563eb; color: white; padding: 4px 10px; border-radius: 6px; text-decoration: none; font-size: 0.75rem; font-weight: 700;">
                                            <i class="fas fa-download"></i> Download Certificate
                                        </a>
                                    <?php elseif($app['status'] == 'Pending'): ?>
                                        <span style="color: #64748b; font-size: 0.8rem; font-style: italic;">In Progress...</span>
                                    <?php else: ?>
                                        <span style="color: #ef4444; font-size: 0.8rem; font-weight: 600;">Rejected</span>
                                    <?php endif; ?>
                                </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Great!',
                text: '<?= session()->getFlashdata('success') ?>',
                confirmButtonColor: '#2563eb'
            });
        <?php endif; ?>  
    </script>
</body>
</html>
