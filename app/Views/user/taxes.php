<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Village Taxes - E-Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #2563eb; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        header { background: white; padding: 1.1rem 2.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; position: sticky; top: 0; z-index: 100; }
        .content-body { padding: 2.5rem; }

        .tax-header { margin-bottom: 2.5rem; }
        .tax-header h1 { font-size: 2.2rem; font-weight: 800; color: var(--dark); margin-bottom: 0.5rem; }
        .tax-header p { color: #64748b; font-size: 1.1rem; }

        .section-title { font-size: 1.25rem; font-weight: 800; color: var(--dark); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; }
        
        .tax-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem; margin-bottom: 4rem; }
        .tax-card { background: white; border-radius: 20px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; position: relative; overflow: hidden; transition: 0.3s; }
        .tax-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
        .tax-card.unpaid { border-left: 6px solid #ef4444; }
        
        .tax-icon { width: 50px; height: 50px; background: #eff6ff; color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; margin-bottom: 1.5rem; }
        .tax-name { font-size: 1.3rem; font-weight: 800; color: var(--dark); margin-bottom: 0.5rem; }
        .tax-amount { font-size: 2rem; font-weight: 800; color: var(--dark); margin: 1rem 0; }
        .tax-due { font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }

        .btn-pay { width: 100%; padding: 1rem; background: var(--dark); color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: 0.3s; margin-top: 1.5rem; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .btn-pay:hover { background: var(--primary); transform: scale(1.02); }

        .paid-item { background: white; padding: 1.25rem 2rem; border-radius: 16px; margin-bottom: 1rem; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; }
        .paid-status { color: #10b981; font-weight: 800; font-size: 0.8rem; text-transform: uppercase; background: #dcfce7; padding: 4px 12px; border-radius: 20px; }

        /* Payment Gateway Modal */
        .gateway-overlay { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(8px); z-index: 9999; align-items: center; justify-content: center; }
        .gateway-overlay.open { display: flex; }
        .gateway-modal { background: white; width: 440px; border-radius: 28px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); position: relative; }
        
        .gateway-header { background: var(--dark); color: white; padding: 2rem; text-align: center; }
        .gateway-body { padding: 2rem; }
        
        .payment-option { border: 2px solid #f1f5f9; padding: 1rem; border-radius: 16px; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 15px; cursor: pointer; transition: 0.3s; }
        .payment-option:hover { border-color: var(--primary); background: #f8faff; }
        .payment-option.active { border-color: var(--primary); background: #eff6ff; }
        .payment-option i { font-size: 1.4rem; color: #64748b; }
        .payment-option.active i { color: var(--primary); }

        .processing-overlay { display: none; position: absolute; inset: 0; background: white; z-index: 10; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 2rem; }
        .processing-overlay.active { display: flex; }
        
        .loader { width: 60px; height: 60px; border: 5px solid #f3f3f3; border-top: 5px solid var(--primary); border-radius: 50%; animation: spin 1s linear infinite; margin-bottom: 1.5rem; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        .success-tick { width: 80px; height: 80px; background: #dcfce7; color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin-bottom: 1.5rem; animation: scaleUp 0.3s ease-out; }
        @keyframes scaleUp { from { transform: scale(0.5); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 700; color: var(--gray-700);"><i class="fas fa-hand-holding-dollar" style="color: var(--primary);"></i> Village Revenue & Taxation</div>
            <div style="font-size: 0.85rem; color: #64748b;">Citizen: <strong><?= session()->get('user_name') ?></strong></div>
        </header>

        <div class="content-body">
            <div class="tax-header">
                <h1>Property & Service Taxes</h1>
                <p>Digital contribution towards village development and essential maintenance.</p>
            </div>

            <?php if(session()->getFlashdata('success')): ?>
                <div style="background: #dcfce7; color: #166534; padding: 1rem 1.5rem; border-radius: 15px; margin-bottom: 2rem; font-weight: 700; display: flex; align-items: center; gap: 10px; border: 1px solid #86efac;">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="section-title"><i class="fas fa-clock" style="color: #ef4444;"></i> Unpaid Liabilities</div>
            <div class="tax-grid">
                <?php if(empty($unpaid_taxes)): ?>
                    <div style="grid-column: 1/-1; background: white; padding: 3rem; text-align: center; border-radius: 20px; border: 1px dashed #e2e8f0; color: #94a3b8;">
                        <i class="fas fa-smile-beam" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                        All taxes are settled! No pending dues.
                    </div>
                <?php else: ?>
                    <?php foreach($unpaid_taxes as $t): ?>
                        <div class="tax-card unpaid">
                            <div class="tax-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                            <div class="tax-due">Payable Before: <?= date('d M Y', strtotime($t['due_date'])) ?></div>
                            <div class="tax-name"><?= esc($t['tax_type']) ?></div>
                            <div class="tax-amount">₹<?= number_format($t['amount'], 2) ?></div>
                            <button type="button" class="btn-pay" onclick="startPayment(<?= $t['id'] ?>, '<?= esc($t['tax_type']) ?>', <?= $t['amount'] ?>)">
                                <i class="fas fa-shield-halved"></i> Secure Payment
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="section-title"><i class="fas fa-history" style="color: var(--primary);"></i> Recently Paid</div>
            <div style="max-width: 900px;">
                <?php if(empty($paid_taxes)): ?>
                    <div style="color: #94a3b8; font-style: italic;">No payment history found for current session.</div>
                <?php else: ?>
                    <?php foreach($paid_taxes as $t): ?>
                        <div class="paid-item">
                            <div>
                                <div style="font-weight: 800; color: var(--dark); font-size: 1.1rem;"><?= esc($t['tax_type']) ?></div>
                                <div style="font-size: 0.8rem; color: #64748b;">Paid On: <?= date('d M Y H:i', strtotime($t['paid_at'])) ?></div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 20px;">
                                <div style="font-weight: 800; color: var(--dark); font-size: 1.2rem;">₹<?= number_format($t['amount'], 2) ?></div>
                                <span class="paid-status"><i class="fas fa-check"></i> Paid</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <!-- Secure Payment Gateway Modal -->
    <div class="gateway-overlay" id="gatewayModal">
        <div class="gateway-modal">
            <!-- Processing State -->
            <div class="processing-overlay" id="paymentLoading">
                <div class="loader"></div>
                <h3 style="font-weight: 800; font-size: 1.2rem;">Securing Transaction...</h3>
                <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">Contacting Payment Gateway</p>
            </div>

            <!-- Success State -->
            <div class="processing-overlay" id="paymentSuccess">
                <div class="success-tick"><i class="fas fa-check"></i></div>
                <h3 style="font-weight: 800; font-size: 1.5rem; color: #065f46;">Payment Success!</h3>
                <div style="font-size: 2.2rem; font-weight: 800; color: var(--dark); margin: 0.5rem 0;">₹<span id="successAmount">0.00</span></div>
                <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">Your tax record has been updated.</p>
                <div style="margin-top: 1.5rem; font-family: monospace; background: #f8fafc; padding: 10px; border-radius: 8px; font-size: 0.8rem;">
                    TXN ID: <span id="successTxnId">TXN-XXXXXX</span>
                </div>
            </div>

            <div class="gateway-header">
                <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8; margin-bottom: 5px;">Secure Settlement</p>
                <h2 id="modalTaxType" style="font-weight: 800; font-size: 1.4rem;">Property Tax</h2>
                <div style="font-size: 2.2rem; font-weight: 800; margin-top: 10px;">₹<span id="modalAmount">0.00</span></div>
            </div>
            
            <div class="gateway-body">
                <p style="font-weight: 800; font-size: 0.85rem; color: #64748b; margin-bottom: 1rem; text-transform: uppercase;">Select Payment Method</p>
                
                <div class="payment-option active">
                    <i class="fas fa-mobile-screen-button"></i>
                    <div style="flex: 1;">
                        <div style="font-weight: 800; font-size: 0.95rem;">UPI / Google Pay / PhonePe</div>
                        <div style="font-size: 0.75rem; color: #94a3b8;">Pay using any UPI App</div>
                    </div>
                    <i class="fas fa-circle-check" style="color: var(--primary); font-size: 1.2rem;"></i>
                </div>

                <div class="payment-option">
                    <i class="fas fa-credit-card"></i>
                    <div style="flex: 1;">
                        <div style="font-weight: 800; font-size: 0.95rem;">Credit / Debit Card</div>
                        <div style="font-size: 0.75rem; color: #94a3b8;">Visa, Mastercard, RuPay</div>
                    </div>
                </div>

                <div class="payment-option">
                    <i class="fas fa-building-columns"></i>
                    <div style="flex: 1;">
                        <div style="font-weight: 800; font-size: 0.95rem;">Net Banking</div>
                        <div style="font-size: 0.75rem; color: #94a3b8;">All major Indian banks</div>
                    </div>
                </div>

                <form id="finalPayForm" action="" method="POST" style="margin-top: 2rem;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-pay" style="height: 60px; font-size: 1.1rem; background: var(--primary); margin-top: 0;">
                        Confirm & Pay Now
                    </button>
                    <button type="button" onclick="closeGateway()" style="width: 100%; border: none; background: none; color: #94a3b8; font-weight: 700; font-size: 0.85rem; margin-top: 1rem; cursor: pointer;">
                        Cancel Transaction
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function startPayment(id, type, amount) {
            document.getElementById('modalTaxType').innerText = type;
            document.getElementById('modalAmount').innerText = amount.toFixed(2);
            document.getElementById('finalPayForm').action = "<?= base_url('user/taxes/pay') ?>/" + id;
            document.getElementById('gatewayModal').classList.add('open');
        }

        function closeGateway() {
            document.getElementById('gatewayModal').classList.remove('open');
            // Reset modal states
            document.getElementById('paymentLoading').classList.remove('active');
            document.getElementById('paymentSuccess').classList.remove('active');
        }

        // Add selection logic for all payment options
        document.querySelectorAll('.payment-option').forEach(opt => {
            opt.addEventListener('click', function() {
                document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('active'));
                document.querySelectorAll('.payment-option .fa-circle-check').forEach(i => i.remove());
                
                this.classList.add('active');
                this.innerHTML += '<i class="fas fa-circle-check" style="color: var(--primary); font-size: 1.2rem;"></i>';
            });
        });

        document.getElementById('finalPayForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const overlay = document.getElementById('paymentLoading');
            const success = document.getElementById('paymentSuccess');
            const selectedMethod = document.querySelector('.payment-option.active div div').innerText;
            const form = this;

            overlay.classList.add('active');
            
            // PHASE 1: Initialize
            overlay.innerHTML = `
                <div class="loader"></div>
                <h3 style="font-weight: 800; font-size: 1.2rem;">Initializing ${selectedMethod}...</h3>
                <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">Secure Handshake in Progress</p>
            `;
            
            // PHASE 2: Bank Handshake
            setTimeout(() => {
                overlay.innerHTML = `
                    <div class="loader" style="border-top-color: #f59e0b;"></div>
                    <h3 style="font-weight: 800; font-size: 1.2rem;">Waiting for Bank...</h3>
                    <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">Please do not refresh or close this window</p>
                `;
                
                // PHASE 3: Approval
                setTimeout(() => {
                    overlay.innerHTML = `
                        <div class="loader" style="border-top-color: #10b981;"></div>
                        <h3 style="font-weight: 800; font-size: 1.2rem;">Payment Approved</h3>
                        <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">Finalizing Village Records</p>
                    `;

                    // FINAL: Success Screen
                    setTimeout(() => {
                        overlay.classList.remove('active');
                        success.classList.add('active');
                        document.getElementById('successAmount').innerText = document.getElementById('modalAmount').innerText;
                        document.getElementById('successTxnId').innerText = 'TXN-' + Math.random().toString(36).substr(2, 9).toUpperCase();
                        
                        // Final submission
                        setTimeout(() => {
                            form.submit();
                        }, 2500);
                    }, 1500);
                }, 2500);
            }, 2000);
        });
    </script>
</body>
</html>
