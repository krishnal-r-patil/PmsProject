<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts & Vouchers - Gram Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; --success: #10b981; --danger: #ef4444; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }
        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .sidebar-brand { font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; display: flex; align-items: center; gap: 10px; color: white; text-decoration: none; }
        .sidebar-brand span { color: var(--primary); }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 0.8rem 1rem; color: #94a3b8; text-decoration: none; border-radius: 8px; transition: all 0.3s; margin-bottom: 0.5rem; }
        .nav-link:hover, .nav-link.active { background-color: #334155; color: white; }
        .nav-link.active { background-color: var(--primary); }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); padding: 2.5rem; }
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; }
        .summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .summary-card { background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .summary-card h3 { font-size: 0.8rem; color: var(--gray-700); text-transform: uppercase; margin-bottom: 0.5rem; }
        .summary-card .value { font-size: 1.5rem; font-weight: 700; color: var(--dark); }
        .table-card { background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 1.25rem 1rem; background: var(--gray-100); color: var(--gray-700); font-size: 0.85rem; font-weight: 700; text-transform: uppercase; }
        td { padding: 1rem; border-bottom: 1px solid var(--gray-200); font-size: 0.95rem; }
        .voucher-type { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
        .type-Receipt { background: #d1fae5; color: #065f46; }
        .type-Payment { background: #fee2e2; color: #b91c1c; }
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
                <h1>Financial Accounts & Vouchers</h1>
                <p>Digital Double Entry Cashbook & Payment Tracking</p>
            </div>
            <button class="btn-add"><i class="fas fa-plus"></i> Create Voucher</button>
        </div>

        <div class="summary-grid">
            <div class="summary-card" style="border-left: 5px solid var(--success);">
                <h3>Total Receipts</h3>
                <div class="value">₹<?= number_format(array_sum(array_column(array_filter($vouchers, fn($v) => $v['type'] == 'Receipt'), 'amount')), 2) ?></div>
            </div>
            <div class="summary-card" style="border-left: 5px solid var(--danger);">
                <h3>Total Payments</h3>
                <div class="value">₹<?= number_format(array_sum(array_column(array_filter($vouchers, fn($v) => $v['type'] == 'Payment'), 'amount')), 2) ?></div>
            </div>
            <div class="summary-card" style="border-left: 5px solid var(--primary);">
                <h3>Closing Balance</h3>
                <div class="value">₹<?= number_format(array_sum(array_column(array_filter($vouchers, fn($v) => $v['type'] == 'Receipt'), 'amount')) - array_sum(array_column(array_filter($vouchers, fn($v) => $v['type'] == 'Payment'), 'amount')), 2) ?></div>
            </div>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Voucher Info</th>
                        <th>Type</th>
                        <th>Head of Account</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($vouchers)): ?>
                        <tr><td colspan="6" style="text-align: center; padding: 2rem;">No vouchers recorded for this period.</td></tr>
                    <?php else: ?>
                        <?php foreach($vouchers as $v): ?>
                        <tr>
                            <td>
                                <div style="font-weight: 700;">#<?= $v['voucher_no'] ?></div>
                                <div style="font-size: 0.8rem; color: var(--gray-700);"><?= $v['description'] ?></div>
                            </td>
                            <td><span class="voucher-type type-<?= $v['type'] ?>"><?= $v['type'] ?></span></td>
                            <td><?= $v['head_of_account'] ?></td>
                            <td style="font-weight: 700; color: <?= $v['type'] == 'Receipt' ? 'var(--success)' : 'var(--danger)' ?>;">
                                <?= $v['type'] == 'Receipt' ? '+' : '-' ?> ₹<?= number_format($v['amount'], 2) ?>
                            </td>
                            <td><?= date('d M Y', strtotime($v['date'])) ?></td>
                            <td><i class="fas fa-check-circle" style="color: var(--success);"></i> Verified</td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
