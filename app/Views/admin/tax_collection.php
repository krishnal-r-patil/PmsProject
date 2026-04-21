<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Collection & Revenue - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; --success: #10b981; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 90; }
        .content-body { padding: 2.5rem; }

        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2.5rem; }
        .stat-card { background: white; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .stat-val { font-size: 1.8rem; font-weight: 800; color: var(--dark); margin: 0.5rem 0; }
        .stat-label { font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; }

        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .btn-demand { background: var(--dark); color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: 0.3s; }
        .btn-demand:hover { background: #1e293b; transform: translateY(-2px); }

        .card { background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 1.25rem 1.5rem; background: #f8fafc; color: #64748b; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; border-bottom: 1px solid var(--gray-200); }
        td { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--gray-200); font-size: 0.95rem; }

        .badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
        .status-paid { background: #dcfce7; color: #166534; }
        .status-unpaid { background: #fee2e2; color: #991b1b; }

        /* Modal */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: white; width: 550px; border-radius: 24px; overflow: hidden; }
        .modal-header { padding: 1.5rem 2rem; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center; background: #f8fafc; }
        .modal-body { padding: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--gray-700); font-size: 0.9rem; }
        input, select { width: 100%; padding: 0.8rem; border: 1px solid var(--gray-200); border-radius: 10px; font-size: 1rem; }
        .btn-submit { background: var(--primary); color: white; padding: 1rem; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; width: 100%; transition: 0.3s; margin-top: 1rem; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 700;"><i class="fas fa-hand-holding-dollar" style="color: var(--primary);"></i> Revenue & Tax Collection Hub</div>
            <div style="font-size: 0.85rem; color: #64748b;">Financial Year: 2025-26</div>
        </header>

        <div class="content-body">
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-label">Total Tax Demand</div>
                    <div class="stat-val">₹<?= number_format($stats['total_demand'], 2) ?></div>
                    <div style="font-size: 0.75rem; color: #64748b;">Active fiscal year</div>
                </div>
                <div class="stat-card" style="border-left: 4px solid var(--success);">
                    <div class="stat-label">Total Collected</div>
                    <div class="stat-val" style="color: var(--success);">₹<?= number_format($stats['total_collected'], 2) ?></div>
                    <div style="font-size: 0.75rem; color: #64748b;">Paid by citizens</div>
                </div>
                <div class="stat-card" style="border-left: 4px solid #ef4444;">
                    <div class="stat-label">Outstanding Arrears</div>
                    <div class="stat-val" style="color: #ef4444;">₹<?= number_format($stats['total_pending'], 2) ?></div>
                    <div style="font-size: 0.75rem; color: #64748b;">Awaiting payment</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Collection Rate</div>
                    <div class="stat-val" style="color: var(--primary);"><?= $stats['collection_rate'] ?>%</div>
                    <div style="font-size: 0.75rem; color: #64748b;">Target: 95%</div>
                </div>
            </div>

            <div class="page-header">
                <div>
                    <h1 style="font-size: 1.8rem; font-weight: 800;">Citizen Tax Records</h1>
                    <p style="color: #64748b;">Monitor individual tax liabilities and collection status.</p>
                </div>
                <div style="display: flex; gap: 15px;">
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem;"></i>
                        <input type="text" id="taxSearch" placeholder="Search by name/type..." 
                               style="padding: 0.7rem 1rem 0.7rem 2.5rem; width: 280px; border-radius: 12px; border: 1px solid var(--gray-200); font-size: 0.9rem;">
                    </div>
                    <button class="btn-demand" onclick="openModal()">
                        <i class="fas fa-plus-circle"></i> Generate Tax Demand
                    </button>
                </div>
            </div>

            <div class="card">
                <table id="taxTable">
                    <thead>
                        <tr>
                            <th>Citizen Name</th>
                            <th>Tax Type</th>
                            <th>Amount</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Last Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($taxes as $t): ?>
                        <tr>
                            <td style="font-weight: 700; color: var(--dark);"><?= esc($t['citizen_name']) ?></td>
                            <td>
                                <div style="font-weight: 600; color: var(--gray-700);"><?= esc($t['tax_type']) ?></div>
                                <div style="font-size: 0.75rem; color: #64748b;">ID: #TX-<?= $t['id'] ?></div>
                            </td>
                            <td style="font-weight: 800; color: var(--dark);">₹<?= number_format($t['amount'], 2) ?></td>
                            <td style="font-size: 0.9rem; font-weight: 500; color: #64748b;"><?= date('d M Y', strtotime($t['due_date'])) ?></td>
                            <td>
                                <span class="badge status-<?= strtolower($t['status']) ?>">
                                    <?= $t['status'] ?>
                                </span>
                            </td>
                            <td style="font-size: 0.85rem; color: #94a3b8;">
                                <?= $t['paid_at'] ? date('d M Y H:i', strtotime($t['paid_at'])) : '---' ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Demand Tax Modal -->
    <div class="modal-overlay" id="demandModal">
        <div class="modal">
            <div class="modal-header">
                <h2 style="font-weight: 800;"><i class="fas fa-file-invoice"></i> Generate New Tax Bill</h2>
                <button style="border:none; background:none; font-size: 1.5rem; cursor:pointer;" onclick="closeModal()">&times;</button>
            </div>
            <form action="<?= base_url('admin/taxes/demand') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Select Resident *</label>
                        <select name="user_id" class="citizen-select" required style="width: 100%;">
                            <option value="">-- Choose Resident --</option>
                            <?php foreach($users as $u): ?>
                                <option value="<?= $u['id'] ?>"><?= esc($u['name']) ?> (ID: <?= $u['id'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label>Tax Category *</label>
                            <select name="tax_type" required>
                                <optgroup label="Core Property & Land">
                                    <option value="Property Tax">Residential Property Tax (House Tax)</option>
                                    <option value="Commercial Property Tax">Commercial Property Tax</option>
                                    <option value="Vacant Land Tax">Vacant Land / Plot Tax</option>
                                    <option value="Building Permission Fee">New Building Construction Fee</option>
                                </optgroup>
                                <optgroup label="Essential Utilities">
                                    <option value="Water Tax">Drinking Water Utility Fee</option>
                                    <option value="Sanitation Fee">Sanitation & Garbage Collection</option>
                                    <option value="Street Light Tax">Public Street Light Cess</option>
                                    <option value="Drainage Fee">Drainage & Sewage Maintenance</option>
                                </optgroup>
                                <optgroup label="Trade & Business">
                                    <option value="Trade License">General Trade / Shop License</option>
                                    <option value="Professional Tax">Professional Tax (Service Holders)</option>
                                    <option value="Market Fee">Weekly Market / Bazaar Fee</option>
                                    <option value="Advertising Fee">Signage & Advertising Fee</option>
                                </optgroup>
                                <optgroup label="Special & Event Fees">
                                    <option value="Marriage Fee">Marriage Registration Fee</option>
                                    <option value="Fair/Mela Fee">Village Fair / Event Stall Fee</option>
                                    <option value="Parking Fee">Public Parking / Vehicle Stand Fee</option>
                                    <option value="Other Fee">Other Administrative Charges</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Amount (INR) *</label>
                            <input type="number" name="amount" step="0.01" value="500" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Payment Due Date *</label>
                        <input type="date" name="due_date" value="<?= date('Y-m-d', strtotime('+30 days')) ?>" required>
                    </div>

                    <button type="submit" class="btn-submit">Issue Tax Notice</button>
                    <p style="text-align: center; font-size: 0.75rem; color: #64748b; margin-top: 1rem;">
                        <i class="fas fa-bell"></i> This will notify the citizen and appear in their "Pay Taxes" portal.
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.citizen-select').select2({
                placeholder: "-- Search Resident by Name --",
                allowClear: true,
                dropdownParent: $('#demandModal')
            });

            // Live Search
            $('#taxSearch').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $("#taxTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // Flash Alerts
            <?php if(session()->getFlashdata('success')): ?>
                Swal.fire({ icon: 'success', title: 'Action Successful', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#2563eb' });
            <?php endif; ?>
            <?php if(session()->getFlashdata('error')): ?>
                Swal.fire({ icon: 'error', title: 'Update Failed', text: '<?= session()->getFlashdata('error') ?>', confirmButtonColor: '#ef4444' });
            <?php endif; ?>
        });

        function openModal() { document.getElementById('demandModal').classList.add('open'); }
        function closeModal() { document.getElementById('demandModal').classList.remove('open'); }
    </script>
</body>
</html>
