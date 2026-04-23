<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Hub - E-Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #10b981; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --accent: #f59e0b; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }
        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 90; }
        .content-padding { padding: 3rem; }

        .tabs { display: flex; gap: 20px; margin-bottom: 2rem; border-bottom: 2px solid var(--gray-200); }
        .tab-btn { padding: 1rem 2rem; border: none; background: none; font-weight: 700; color: #64748b; cursor: pointer; position: relative; }
        .tab-btn.active { color: var(--primary); }
        .tab-btn.active::after { content: ''; position: absolute; bottom: -2px; left: 0; right: 0; height: 3px; background: var(--primary); }

        .mandi-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
        .mandi-card { background: white; padding: 1.5rem; border-radius: 20px; border-left: 5px solid var(--primary); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .mandi-crop { font-size: 1.2rem; font-weight: 800; color: var(--dark); margin-bottom: 5px; }
        .price-box { font-size: 1.5rem; font-weight: 800; color: var(--primary); margin: 10px 0; }
        .trend-badge { padding: 4px 10px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; }
        .trend-Up { background: #dcfce7; color: #16a34a; }
        .trend-Down { background: #fee2e2; color: #dc2626; }

        .eq-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem; }
        .eq-card { background: white; border-radius: 24px; overflow: hidden; border: 1px solid #e2e8f0; transition: 0.3s; }
         .eq-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.08); }
        .eq-image { height: 180px; background: #f8fafc; display: flex; align-items: center; justify-content: center; font-size: 4.5rem; }
        
        /* Vibrant Icon Colors */
        .icon-tractor { color: #ef4444; }
        .icon-sprayer { color: #3b82f6; }
        .icon-roller { color: #64748b; }
        .icon-cultivator { color: #f59e0b; }
        .icon-default { color: #10b981; }
        .eq-content { padding: 1.5rem; }
        .btn-book { width: 100%; padding: 1rem; border: none; background: var(--dark); color: white; border-radius: 12px; font-weight: 700; cursor: pointer; margin-top: 1rem; transition: 0.3s; }
        .btn-book:hover { background: var(--primary); }

        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px); }
        .modal { background: white; width: 450px; border-radius: 30px; overflow: hidden; animation: slideUp 0.3s ease; }
        .form-group { margin-bottom: 1.2rem; padding: 0 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-size: 0.8rem; font-weight: 800; color: #64748b; }
        input, select { width: 100%; padding: 0.9rem; border: 1px solid #e2e8f0; border-radius: 12px; outline: none; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800;"><i class="fas fa-tractor" style="color: var(--primary);"></i> Agriculture & Krishi Hub</div>
            <div style="background: #ecfdf5; color: #059669; padding: 6px 15px; border-radius: 50px; font-size: 0.75rem; font-weight: 800;">
                <i class="fas fa-signal"></i> Market Rates Live
            </div>
        </header>

        <div class="content-padding">
            <div class="tabs">
                <button class="tab-btn active" onclick="showSection('mandi')">Panchayat Mandi Rates</button>
                <button class="tab-btn" onclick="showSection('equipment')">Equipment Booking</button>
                <button class="tab-btn" onclick="showSection('bookings')">My Requests</button>
            </div>

            <!-- Mandi Rates Section -->
            <div id="mandi-section">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <h2 style="font-size: 1.8rem; font-weight: 800;">Krishi Mandi Bhav (Daily Rates)</h2>
                    <p style="color: #64748b; font-size: 0.9rem;">Source: Burhanpur APMC Market</p>
                </div>
                <div class="mandi-grid">
                    <?php foreach($mandi_rates as $m): ?>
                    <div class="mandi-card">
                        <div style="display: flex; justify-content: space-between;">
                            <span class="mandi-crop"><?= $m['crop_name'] ?></span>
                            <span class="trend-badge trend-<?= $m['trend'] ?>"><?= $m['trend'] ?> <i class="fas fa-chart-line"></i></span>
                        </div>
                        <div class="price-box">₹<?= number_format($m['price_min']) ?> - <?= number_format($m['price_max']) ?></div>
                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Rate per Quintal (100kg)</div>
                        <hr style="margin: 1rem 0; opacity: 0.1;">
                        <div style="font-size: 0.8rem; color: #94a3b8;"><i class="fas fa-map-marker-alt"></i> <?= $m['market_name'] ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Equipment Section -->
            <div id="equipment-section" style="display: none;">
                <h2 style="font-size: 1.8rem; font-weight: 800; margin-bottom: 2rem;">Available Agricultural Equipment</h2>
                <div class="eq-grid">
                    <?php foreach($equipment as $e): ?>
                     <div class="eq-card">
                        <div class="eq-image">
                            <?php 
                                $n = strtolower($e['name']);
                                $icon = 'fa-gears';
                                $colorClass = 'icon-default';
                                
                                if(strpos($n, 'tractor') !== false) { $icon = 'fa-tractor'; $colorClass = 'icon-tractor'; }
                                elseif(strpos($n, 'sprayer') !== false || strpos($n, 'battery') !== false) { $icon = 'fa-spray-can-sparkles'; $colorClass = 'icon-sprayer'; }
                                elseif(strpos($n, 'roller') !== false) { $icon = 'fa-road'; $colorClass = 'icon-roller'; }
                                elseif(strpos($n, 'cultivator') !== false || strpos($n, 'plough') !== false) { $icon = 'fa-wheat-awn'; $colorClass = 'icon-cultivator'; }
                            ?>
                            <i class="fas <?= $icon ?> <?= $colorClass ?>"></i>
                        </div>
                        <div class="eq-content">
                            <h3 style="font-weight: 800; color: var(--dark); margin-bottom: 5px;"><?= $e['name'] ?></h3>
                            <div style="font-size: 0.8rem; color: #64748b; margin-bottom: 1rem;"><?= $e['vehicle_no'] ?></div>
                            <div style="font-size: 1.5rem; font-weight: 800; color: var(--accent);">₹<?= number_format($e['rate_per_hour']) ?><span style="font-size: 0.9rem; font-weight: 500; color: #94a3b8;"> / Hour</span></div>
                            <p style="font-size: 0.85rem; color: #64748b; margin-top: 10px; border-top: 1px solid #f1f5f9; padding-top: 10px;"><?= $e['description'] ?></p>
                            <button class="btn-book" onclick="openBooking('<?= $e['id'] ?>', '<?= $e['name'] ?>', '<?= $e['rate_per_hour'] ?>')">Book Now</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- My Bookings Section -->
            <div id="bookings-section" style="display: none;">
                <h2 style="font-size: 1.8rem; font-weight: 800; margin-bottom: 2rem;">My Booking History</h2>
                <div style="background: white; border-radius: 24px; padding: 1.5rem; border: 1px solid #e2e8f0;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="text-align: left; background: #f8fafc; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">
                                <th style="padding: 1.2rem; border-radius: 12px 0 0 12px;">Equipment</th>
                                <th>Booking Date</th>
                                <th>Duration</th>
                                <th>Est. Cost</th>
                                <th style="border-radius: 0 12px 12px 0;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($my_bookings as $b): ?>
                            <tr>
                                <td style="padding: 1.2rem; font-weight: 800;"><?= $b['eq_name'] ?></td>
                                <td style="color: #64748b;"><?= date('d M, Y', strtotime($b['booking_date'])) ?></td>
                                <td style="font-weight: 700;"><?= $b['hours_req'] ?> Hours</td>
                                <td style="color: #059669; font-weight: 800;">₹<?= number_format($b['total_amount']) ?></td>
                                <td>
                                    <div style="padding: 4px 10px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; display: inline-block; background: 
                                        <?php if($b['status'] == 'Pending') echo '#fef3c7; color: #d97706;'; 
                                              elseif($b['status'] == 'Approved') echo '#dcfce7; color: #16a34a;'; 
                                              elseif($b['status'] == 'Cancelled') echo '#fee2e2; color: #dc2626;';
                                              else echo '#f1f5f9; color: #64748b;'; ?>">
                                        <?= $b['status'] ?>
                                    </div>
                                    <?php if($b['admin_remarks']): ?>
                                        <div style="font-size: 0.65rem; color: #64748b; margin-top: 5px; font-style: italic;">
                                            <i class="fas fa-comment-dots"></i> <?= esc($b['admin_remarks']) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Modal -->
    <div class="modal-overlay" id="bookingModal">
        <div class="modal">
            <div style="padding: 1.5rem 2rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <h2 id="modalTitle" style="font-weight: 800; font-size: 1.2rem;">Book Equipment</h2>
                <button onclick="closeModal()" style="border:none; background:none; font-size: 1.5rem; cursor:pointer;">&times;</button>
            </div>
            <form action="<?= base_url('user/agriculture/book') ?>" method="POST" style="padding-top: 1.5rem;">
                <?= csrf_field() ?>
                <input type="hidden" name="equipment_id" id="hiddenEqId">
                <div class="form-group">
                    <label>Selected Equipment</label>
                    <input type="text" id="eqName" readonly style="background: #f8fafc; font-weight: 800;">
                </div>
                <div class="form-group">
                    <label>Usage Date *</label>
                    <input type="date" name="booking_date" required min="<?= date('Y-m-d') ?>">
                </div>
                <div class="form-group">
                    <label>Req. Hours *</label>
                    <input type="number" name="hours_req" id="hoursInput" value="1" min="1" oninput="uCost()" required>
                </div>
                <div style="padding: 1rem 1.5rem; background: #f0fdf4; margin: 1.5rem; border-radius: 12px; display: flex; justify-content: space-between; align-items: center;">
                    <div style="font-size: 0.8rem; font-weight: 700; color: #065f46;">ESTIMATED TOTAL:</div>
                    <div id="estTotal" style="font-size: 1.2rem; font-weight: 800; color: #10b981;">₹0.00</div>
                </div>
                <div style="padding: 0 1.5rem 1.5rem;">
                    <button type="submit" class="btn-book" style="margin-top: 0;">Confirm Booking Request</button>
                    <p style="font-size: 0.7rem; color: #94a3b8; text-align: center; margin-top: 10px;"><i class="fas fa-info-circle"></i> Rates are government-fixed. Subject to availability.</p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let currentRate = 0;

        // Smart Tab Persistence
        window.onload = function() {
            const lastTab = localStorage.getItem('activeAgriTabUser') || 'mandi';
            showSection(lastTab, false);
        };

        function showSection(id, saveState = true) {
            document.getElementById('mandi-section').style.display = id === 'mandi' ? 'block' : 'none';
            document.getElementById('equipment-section').style.display = id === 'equipment' ? 'block' : 'none';
            document.getElementById('bookings-section').style.display = id === 'bookings' ? 'block' : 'none';
            
            // UI Updates
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active');
                if(b.getAttribute('onclick').includes("'"+id+"'")) b.classList.add('active');
            });

            if(saveState) localStorage.setItem('activeAgriTabUser', id);
        }

        function openBooking(id, name, rate) {
            document.getElementById('hiddenEqId').value = id;
            document.getElementById('eqName').value = name;
            currentRate = rate;
            uCost();
            document.getElementById('bookingModal').style.display = 'flex';
        }

        function uCost() {
            const h = document.getElementById('hoursInput').value || 0;
            const total = h * currentRate;
            document.getElementById('estTotal').innerText = '₹' + total.toLocaleString();
        }

        function closeModal() {
            document.getElementById('bookingModal').style.display = 'none';
        }

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Done!', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#10b981' });
        <?php endif; ?>
    </script>
</body>
</html>
