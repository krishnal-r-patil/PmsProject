<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Financial Ledger - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 90; }
        .content-body { padding: 2.5rem; }

        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .page-header h1 { font-size: 1.8rem; color: var(--dark); }

        .btn-add { background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 10px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: 0.3s; }
        .btn-add:hover { background: #1d4ed8; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); }

        .card { background: white; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 1.25rem 1.5rem; background: #f8fafc; color: #64748b; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; }
        td { padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; font-size: 0.95rem; }

        .badge { padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; }
        .type-credit { background: #dcfce7; color: #166534; }
        .type-debit { background: #fee2e2; color: #991b1b; }

        /* Modal Styles */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: white; width: 600px; border-radius: 20px; overflow: hidden; }
        .modal-header { padding: 1.5rem; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center; }
        .modal-body { padding: 2rem; }
        
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--gray-700); font-size: 0.9rem; }
        input, select, textarea { width: 100%; padding: 0.8rem; border: 1px solid var(--gray-200); border-radius: 10px; font-size: 1rem; }
        
        .btn-submit { background: var(--dark); color: white; padding: 1rem; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; width: 100%; transition: 0.3s; margin-top: 1rem; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 700; color: var(--gray-700);"><i class="fas fa-file-invoice-dollar" style="color: var(--primary);"></i> Village Financial Audit Log</div>
            <div style="font-size: 0.85rem; color: #64748b;">Fiscal Year: 2025-26</div>
        </header>

        <div class="content-body">
            <?php if(session()->getFlashdata('success')): ?>
                <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid #bbf7d0;">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="page-header">
                <div>
                    <h1>Financial Ledger</h1>
                    <p style="color: #64748b;">Manage Citizen Grants, Tax Collections, and Manual Corrections.</p>
                </div>
                <div style="display: flex; gap: 15px;">
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                        <input type="text" id="txnSearch" placeholder="Search transactions..." 
                               style="padding-left: 45px; width: 350px; border-radius: 12px; border: 1px solid var(--gray-200); box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    </div>
                    <button class="btn-add" onclick="openModal()">
                        <i class="fas fa-plus"></i> Post New Transaction
                    </button>
                </div>
            </div>

            <div class="card">
                <table id="txnTable">
                    <thead>
                        <tr>
                            <th>Citizen</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>TXN ID</th>
                            <th>Date</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($transactions as $t): ?>
                        <tr>
                            <td style="font-weight: 700; color: var(--dark);"><?= esc($t['citizen_name']) ?></td>
                            <td><?= esc($t['title']) ?></td>
                            <td style="font-size: 0.8rem; font-weight: 600; color: #64748b;"><?= esc($t['category']) ?></td>
                            <td style="font-weight: 800; color: <?= $t['type'] == 'Credit' ? '#059669' : '#dc2626' ?>;">
                                <?= $t['type'] == 'Credit' ? '+' : '-' ?> ₹<?= number_format($t['amount'], 2) ?>
                            </td>
                            <td style="font-family: monospace; color: #64748b;"><?= $t['transaction_id'] ?></td>
                            <td><?= date('d M Y', strtotime($t['created_at'])) ?></td>
                            <td>
                                <span class="badge <?= $t['type'] == 'Credit' ? 'type-credit' : 'type-debit' ?>">
                                    <?= $t['type'] == 'Credit' ? 'Funds Disbursed' : 'Tax Paid' ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Transaction Modal -->
    <div class="modal-overlay" id="addModal">
        <div class="modal">
            <div class="modal-header">
                <h2 style="font-weight: 800;">Manual Ledger Entry</h2>
                <button style="border:none; background:none; font-size: 1.5rem; cursor:pointer;" onclick="closeModal()">&times;</button>
            </div>
            <form action="<?= base_url('admin/transactions/add') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Select Citizen *</label>
                        <select name="user_id" class="citizen-select" required style="width: 100%;">
                            <option value="">-- Choose Resident --</option>
                            <?php foreach($users as $u): ?>
                                <option value="<?= $u['id'] ?>"><?= esc($u['name']) ?> (ID: <?= $u['id'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label>Transaction Type *</label>
                            <select name="type" required>
                                <option value="Credit">Credit (Money to Citizen)</option>
                                <option value="Debit">Debit (Tax/Fee from Citizen)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Amount (INR) *</label>
                            <input type="number" name="amount" step="0.01" placeholder="e.g. 1500" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Transaction Title *</label>
                        <input type="text" name="title" placeholder="e.g. Special COVID Relief Grant" required>
                    </div>

                    <div class="form-group">
                        <label>Category *</label>
                        <select name="category" required>
                            <option value="Govt Fund">Govt Fund / Grant</option>
                            <option value="Tax">Property/Village Tax</option>
                            <option value="Fee">General Service Fee</option>
                            <option value="Scheme Grant">Direct Scheme Benefit</option>
                            <option value="Pension Fund">Pension Disbursement</option>
                            <option value="Housing Subsidy">Housing / Raw Material Subsidy</option>
                            <option value="Agricultural Support">Agricultural / Fertilizer Grant</option>
                            <option value="Education Scholarship">Education Scholarship</option>
                            <option value="Emergency Relief">Emergency / Disaster Relief</option>
                            <option value="Trade License Fee">Trade License / Shop Fee</option>
                            <option value="Building Permission Fee">Building / Construction Fee</option>
                            <option value="Fine">Penalty / Fine Collection</option>
                            <option value="Donation">Public / NGO Donation</option>
                            <option value="Welfare Aid">Aid for Poor & Needy</option>
                            <option value="Other">Other / Miscellaneous</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-submit">Post to Ledger</button>
                    <p style="text-align: center; font-size: 0.75rem; color: #64748b; margin-top: 1rem;">
                        <i class="fas fa-shield-alt"></i> This entry will be immediately reflected in the citizen's Finance Portal.
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
            // Initialize Select2 on the citizen dropdown
            $('.citizen-select').select2({
                placeholder: "-- Search Resident by Name --",
                allowClear: true,
                dropdownParent: $('#addModal') // Essential for search to work inside a fixed modal
            });
        });

        function openModal() { document.getElementById('addModal').classList.add('open'); }
        function closeModal() { document.getElementById('addModal').classList.remove('open'); }

        // Live Search Logic
        document.getElementById('txnSearch').addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('#txnTable tbody tr');
            
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
