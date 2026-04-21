<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Ledger - E-Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { 
            --sidebar-width: 260px; 
            --primary: #4f46e5; 
            --success: #10b981; 
            --danger: #ef4444; 
            --dark: #0f172a; 
            --glass: rgba(255, 255, 255, 0.9);
            --bg: #f8fafc;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--bg); display: flex; color: var(--dark); overflow: hidden; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); height: 100vh; overflow-y: auto; display: flex; flex-direction: column; }

        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; position: sticky; top: 0; z-index: 90; }
        .content-padding { padding: 2.5rem; flex: 1; }

        /* Realistic Wallet Cards */
        .wallet-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-bottom: 3rem; }
        .ledger-card { 
            background: white; padding: 2rem; border-radius: 24px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; 
            transition: 0.3s; position: relative; overflow: hidden;
        }
        .ledger-card::before { content: ''; position: absolute; top: 0; left: 0; width: 6px; height: 100%; border-radius: 6px 0 0 6px; }
        .card-received::before { background: var(--success); }
        .card-paid::before { background: var(--danger); }
        .card-balance::before { background: var(--primary); }

        .card-label { font-size: 0.85rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        .card-value { font-size: 2.2rem; font-weight: 700; margin: 0.5rem 0; font-family: 'Inter', sans-serif; }
        .card-meta { font-size: 0.8rem; color: #94a3b8; display: flex; align-items: center; gap: 5px; }

        /* Modern Transaction Timeline */
        .history-section { background: white; border-radius: 24px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02); overflow: hidden; }
        .history-header { padding: 1.5rem 2rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #fafafa; }
        .history-title { font-size: 1.2rem; font-weight: 700; border-left: 4px solid var(--primary); padding-left: 12px; }

        .txn-table { width: 100%; border-collapse: collapse; }
        .txn-table th { text-align: left; padding: 1.25rem 2rem; background: #fff; color: #64748b; font-size: 0.85rem; font-weight: 700; border-bottom: 2px solid #f1f5f9; }
        .txn-row { border-bottom: 1px solid #f1f5f9; transition: 0.2s; cursor: pointer; }
        .txn-row:hover { background: #f8fafc; }
        .txn-cell { padding: 1.5rem 2rem; }

        .txn-type-icon { 
            width: 45px; height: 45px; border-radius: 12px; display: flex; 
            align-items: center; justify-content: center; font-size: 1.1rem;
        }
        .icon-credit { background: #ecfdf5; color: #059669; }
        .icon-debit { background: #fef2f2; color: #dc2626; }

        .txn-main { display: flex; align-items: center; gap: 15px; }
        .txn-name { font-weight: 700; color: var(--dark); display: block; }
        .txn-cat { font-size: 0.75rem; color: #94a3b8; font-weight: 500; text-transform: uppercase; margin-top: 2px; }

        .txn-amt { font-weight: 800; font-size: 1.1rem; }
        .amt-credit { color: #059669; }
        .amt-debit { color: #dc2626; }

        .txn-status { padding: 4px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }
        .status-completed { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef3c7; color: #92400e; }

        .btn-receipt { 
            padding: 8px 16px; border-radius: 10px; border: 1px solid #e2e8f0; 
            background: white; font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: 0.3s;
        }
        .btn-receipt:hover { background: #f1f5f9; border-color: #cbd5e1; }

        /* Realistic Background Elements */
        .wallet-bg { position: absolute; right: -50px; bottom: -50px; font-size: 10rem; color: #f1f5f9; transform: rotate(-15deg); z-index: -1; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>

    <div class="main-content">
        <header style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 2.5rem; background: white; border-bottom: 1px solid #e2e8f0; position: sticky; top: 0; z-index: 100;">
            <div style="font-weight: 700; font-size: 1.1rem;"><i class="fas fa-wallet" style="color: var(--primary);"></i> Centralized Account Ledger</div>
            <div style="display: flex; gap: 20px; align-items: center;">
                <div style="position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.8rem;"></i>
                    <input type="text" id="txnSearch" placeholder="Search entries..." 
                           style="padding: 0.6rem 1rem 0.6rem 2.25rem; width: 250px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.85rem; background: #f8fafc;">
                </div>
                <button class="btn-receipt" onclick="window.print()"><i class="fas fa-file-pdf"></i> Export PDF</button>
            </div>
        </header>

        <div class="content-padding">
            <h1 style="margin-bottom: 0.5rem; font-size: 2rem;">Financial Passport</h1>
            <p style="color: #64748b; margin-bottom: 2.5rem;">Tracking both Government Scheme Funds received and Taxes paid.</p>

            <div class="wallet-grid">
                <div class="ledger-card card-received">
                    <div class="card-label">Total Govt Funds Received</div>
                    <div class="card-value">₹<?= number_format($total_received, 2) ?></div>
                    <div class="card-meta"><i class="fas fa-arrow-up"></i> Disbursed via DBT</div>
                </div>
                <div class="ledger-card card-paid">
                    <div class="card-label">Total Taxes/Fees Paid</div>
                    <div class="card-value">₹<?= number_format($total_paid, 2) ?></div>
                    <div class="card-meta"><i class="fas fa-arrow-down"></i> Paid to Panchayat</div>
                </div>
                <div class="ledger-card card-balance">
                    <div class="card-label">Net Fiscal Impact</div>
                    <div class="card-value">₹<?= number_format($total_received - $total_paid, 2) ?></div>
                    <div class="card-meta"><i class="fas fa-chart-line"></i> Overall Welfare Benefit</div>
                </div>
            </div>

            <div class="history-section">
                <div class="history-header">
                    <div class="history-title">Detailed Transaction Statement</div>
                    <div style="font-size: 0.8rem; color: #64748b;">Showing all Scheme disbursements and Tax settlements.</div>
                </div>
                <table class="txn-table" id="txnTable">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Transaction ID</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Receipt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($transactions as $t): ?>
                        <tr class="txn-row">
                            <td class="txn-cell">
                                <div class="txn-main">
                                    <div class="txn-type-icon <?= $t['type'] == 'Credit' ? 'icon-credit' : 'icon-debit' ?>">
                                        <i class="fas <?= $t['type'] == 'Credit' ? 'fa-hand-holding-dollar' : 'fa-receipt' ?>"></i>
                                    </div>
                                    <div>
                                        <span class="txn-name"><?= esc($t['title']) ?></span>
                                        <span class="txn-cat"><?= esc($t['category']) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="txn-cell" style="font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.85rem; color: #64748b;">
                                <?= $t['transaction_id'] ?>
                            </td>
                            <td class="txn-cell" style="font-weight: 500; font-size: 0.9rem;">
                                <?= date('d M Y', strtotime($t['created_at'])) ?>
                            </td>
                            <td class="txn-cell">
                                <div class="txn-amt <?= $t['type'] == 'Credit' ? 'amt-credit' : 'amt-debit' ?>">
                                    <?= $t['type'] == 'Credit' ? '+' : '-' ?> ₹<?= number_format($t['amount'], 2) ?>
                                </div>
                            </td>
                            <td class="txn-cell">
                                <span class="txn-status status-<?= strtolower($t['status']) ?>"><?= $t['status'] ?></span>
                            </td>
                            <td class="txn-cell">
                                <button class="btn-receipt" onclick='viewReceipt(<?= json_encode($t) ?>)'><i class="fas fa-file-invoice"></i> View</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Receipt Modal -->
            <div id="receiptModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(5px); z-index: 2000; align-items: center; justify-content: center;">
                <div style="background: white; width: 450px; border-radius: 24px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);">
                    <div style="padding: 2rem; border-bottom: 2px dashed #e2e8f0; text-align: center; position: relative; background: #f8fafc;">
                        <div style="width: 60px; height: 60px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1rem;">
                            <i class="fas fa-landmark"></i>
                        </div>
                        <h2 style="font-size: 1.25rem; font-weight: 800;">Gram Panchayat Digital Receipt</h2>
                        <p style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">Official Transaction Voucher</p>
                        
                        <!-- Decorative Holes -->
                        <div style="position: absolute; bottom: -10px; left: -10px; width: 20px; height: 20px; background: #0f172a; border-radius: 50%;"></div>
                        <div style="position: absolute; bottom: -10px; right: -10px; width: 20px; height: 20px; background: #0f172a; border-radius: 50%;"></div>
                    </div>
                    
                    <div style="padding: 2.5rem;" id="receipt-content">
                        <!-- Content Injected via JS -->
                    </div>

                    <div style="padding: 1.5rem; background: #f8fafc; text-align: center; display: flex; gap: 10px;">
                        <button onclick="closeReceipt()" style="flex: 1; padding: 1rem; border-radius: 12px; border: 1px solid #e2e8f0; background: white; font-weight: 700; cursor: pointer;">Close</button>
                        <button onclick="window.print()" style="flex: 1; padding: 1rem; border-radius: 12px; border: none; background: var(--dark); color: white; font-weight: 700; cursor: pointer;"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
            </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function viewReceipt(txn) {
            const dateStr = new Date(txn.created_at).toLocaleDateString('en-IN', { day: '2-digit', month: 'long', year: 'numeric' });
            const amountStr = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(txn.amount);
            const typeColor = txn.type === 'Credit' ? '#059669' : '#dc2626';
            const typeLabel = txn.type === 'Credit' ? 'Fund Disbursed (Credit)' : 'Amount Paid (Debit)';

            const content = `
                <div style="text-align: center; margin-bottom: 2rem;">
                    <div style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; margin-bottom: 5px;">Transaction Reference</div>
                    <div style="font-family: 'Courier New', monospace; font-size: 1.2rem; font-weight: 800; color: var(--dark); letter-spacing: 1px;">${txn.transaction_id}</div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem;">
                        <span style="color: #64748b;">Transaction Date</span>
                        <span style="font-weight: 700;">${dateStr}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem;">
                        <span style="color: #64748b;">Category</span>
                        <span style="font-weight: 700;">${txn.category}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem;">
                        <span style="color: #64748b;">Payment Type</span>
                        <span style="font-weight: 700; color: ${typeColor}">${typeLabel}</span>
                    </div>
                    <div style="margin-top: 1rem; padding: 1rem; background: #f8fafc; border-radius: 12px; text-align: center;">
                        <span style="display: block; font-size: 0.75rem; color: #64748b;">Net Amount</span>
                        <span style="font-size: 1.8rem; font-weight: 800; color: var(--dark);">${amountStr}</span>
                    </div>
                    <div style="margin-top: 1rem; text-align: center;">
                        <div style="display: inline-block; padding: 10px 15px; border: 2px solid #10b981; color: #10b981; font-weight: 800; border-radius: 8px; transform: rotate(-5deg); text-transform: uppercase; font-size: 0.7rem;">
                            Digitally Signed by Sarpanch
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('receipt-content').innerHTML = content;
            document.getElementById('receiptModal').style.display = 'flex';
        }

        function closeReceipt() {
            document.getElementById('receiptModal').style.display = 'none';
        }

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

            <div style="margin-top: 2rem; background: #fffbeb; border: 1px dashed #f59e0b; padding: 1.5rem; border-radius: 16px; display: flex; align-items: start; gap: 1rem;">
                <i class="fas fa-info-circle" style="color: #f59e0b; margin-top: 3px;"></i>
                <div style="font-size: 0.85rem; color: #92400e; line-height: 1.6;">
                    <strong>About Government Funds:</strong> Disbursements marked with <i class="fas fa-hand-holding-dollar" style="color: #059669;"></i> are credits directly received from the Gram Panchayat or Central/State Government via DBT (Direct Benefit Transfer). Taxes paid are marked with <i class="fas fa-receipt" style="color: #dc2626;"></i> and contribute to the village's development funds.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
