<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Moderation - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #10b981; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }
        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 90; }
        .content-padding { padding: 3rem; }

        .tabs { display: flex; gap: 20px; margin-bottom: 2rem; }
        .tab-btn { padding: 0.8rem 1.5rem; border-radius: 12px; border: 1px solid var(--gray-200); background: white; font-weight: 700; color: #64748b; cursor: pointer; transition: 0.3s; }
        .tab-btn.active { background: var(--primary); color: white; border-color: var(--primary); }

        .form-card { background: white; padding: 2rem; border-radius: 24px; border: 1px solid #e2e8f0; margin-bottom: 2rem; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-size: 0.8rem; font-weight: 800; color: #64748b; }
        input, select { width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 10px; outline: none; }
        .btn-save { padding: 0.8rem 2rem; background: var(--dark); color: white; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; }
        
        .table-card { background: white; border-radius: 24px; padding: 1.5rem; border: 1px solid #e2e8f0; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 1.2rem; background: #f8fafc; color: #64748b; font-size: 0.75rem; text-transform: uppercase; border-radius: 10px; }
        td { padding: 1.2rem; border-bottom: 1px solid #f1f5f9; }

        .btn-action { padding: 6px 12px; border: none; border-radius: 8px; font-size: 0.75rem; font-weight: 700; cursor: pointer; color: white; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800;"><i class="fas fa-tractor" style="color: var(--primary);"></i> Krishi & Mandi Operations</div>
            <div style="font-size: 0.85rem; color: #64748b;">Daily Price Control & Machinery Management.</div>
        </header>

        <div class="content-padding">
            <div class="tabs">
                <button class="tab-btn active" onclick="showPane('mandi')">Daily Mandi Rates</button>
                <button class="tab-btn" onclick="showPane('booking')">Equipment Bookings</button>
                <button class="tab-btn" onclick="showPane('inventory')">Manage Inventory</button>
            </div>

            <!-- Mandi Update Pane -->
            <div id="mandi-pane">
                <div class="form-card">
                    <h3 style="margin-bottom: 1.5rem; font-weight: 800;">Update Mandi Bhav</h3>
                    <form action="<?= base_url('admin/agriculture/mandi/save') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="grid-3">
                            <div class="form-group">
                                <label>Crop Name</label>
                                <input type="text" name="crop_name" placeholder="e.g. Soyabean" required>
                            </div>
                            <div class="form-group">
                                <label>Min Price (₹)</label>
                                <input type="number" name="price_min" required>
                            </div>
                            <div class="form-group">
                                <label>Max Price (₹)</label>
                                <input type="number" name="price_max" required>
                            </div>
                            <div class="form-group">
                                <label>Market Name</label>
                                <input type="text" name="market_name" value="Burhanpur Mandi" required>
                            </div>
                            <div class="form-group">
                                <label>Price Trend</label>
                                <select name="trend">
                                    <option value="Stable">Stable</option>
                                    <option value="Up">Upward Trend</option>
                                    <option value="Down">Lower Trend</option>
                                </select>
                            </div>
                            <div class="form-group" style="display: flex; align-items: end;">
                                <button type="submit" class="btn-save" style="width: 100%;">Update Live Rates</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-card">
                    <table>
                        <thead>
                            <tr>
                                <th>Crop</th>
                                <th>Min Price</th>
                                <th>Max Price</th>
                                <th>Trend</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($mandi_rates as $mr): ?>
                            <tr>
                                <td style="font-weight: 800;"><?= $mr['crop_name'] ?></td>
                                <td>₹<?= number_format($mr['price_min']) ?></td>
                                <td>₹<?= number_format($mr['price_max']) ?></td>
                                <td><span style="font-weight: 700; color: <?= $mr['trend'] == 'Up' ? '#16a34a' : ($mr['trend'] == 'Down' ? '#dc2626' : '#d97706') ?>"><?= $mr['trend'] ?></span></td>
                                <td style="font-size: 0.8rem; color: #94a3b8;"><?= date('d M, H:i', strtotime($mr['updated_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bookings Pane -->
            <div id="booking-pane" style="display: none;">
                <div class="table-card">
                    <table>
                        <thead>
                            <tr>
                                <th>Farmer Name</th>
                                <th>Equipment</th>
                                <th>Date</th>
                                <th>Duration</th>
                                <th>Total Cost</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($bookings)): ?>
                                <tr><td colspan="6" style="text-align:center; padding: 3rem; color: #94a3b8;">No machinery bookings yet.</td></tr>
                            <?php endif; ?>
                            <?php foreach($bookings as $b): ?>
                            <tr>
                                <td style="font-weight: 800; color: var(--dark);"><?= esc($b['farmer_name']) ?></td>
                                <td>
                                    <div style="font-weight: 700;"><?= esc($b['eq_name']) ?></div>
                                    <div style="font-size: 0.75rem; color: #94a3b8;"><?= $b['status'] ?></div>
                                </td>
                                <td><?= date('d M, Y', strtotime($b['booking_date'])) ?></td>
                                <td><?= $b['hours_req'] ?> hrs</td>
                                <td style="font-weight: 800; color: #059669;">₹<?= number_format($b['total_amount']) ?></td>
                                <td>
                                    <div style="display: flex; gap: 8px;">
                                        <?php if($b['status'] == 'Pending'): ?>
                                            <button onclick="handleBooking(<?= $b['id'] ?>, 'Approved')" class="btn-action" style="background: #10b981;"><i class="fas fa-check"></i> Approve</button>
                                            <button onclick="handleBooking(<?= $b['id'] ?>, 'Cancelled')" class="btn-action" style="background: #ef4444;"><i class="fas fa-times"></i> Reject</button>
                                        <?php elseif($b['status'] == 'Approved'): ?>
                                            <button onclick="handleBooking(<?= $b['id'] ?>, 'Completed')" class="btn-action" style="background: var(--dark);"><i class="fas fa-flag-checkered"></i> Mark Completed</button>
                                        <?php else: ?>
                                            <div style="font-size: 0.7rem; color: #94a3b8; font-weight: 800;"><?= $b['status'] ?></div>
                                            <?php if($b['admin_remarks']): ?>
                                                <div style="font-size: 0.65rem; color: #64748b; font-style: italic; max-width: 150px;"><?= esc($b['admin_remarks']) ?></div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Inventory Pane -->
            <div id="inventory-pane" style="display: none;">
                <div class="form-card">
                    <h3 style="margin-bottom: 1.5rem; font-weight: 800;"><i class="fas fa-plus-circle"></i> Add New Village Machinery</h3>
                    <form action="<?= base_url('admin/agriculture/inventory/save') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="grid-3">
                            <div class="form-group">
                                <label>Machinery Name</label>
                                <input type="text" name="name" placeholder="e.g. Combine Harvester" required>
                            </div>
                            <div class="form-group">
                                <label>Vehicle Number (Plate)</label>
                                <input type="text" name="vehicle_no" placeholder="e.g. MP-12-G-0000" required>
                            </div>
                            <div class="form-group">
                                <label>Goverment Rate (per hour)</label>
                                <input type="number" name="rate_per_hour" placeholder="₹" required>
                            </div>
                            <div class="form-group" style="grid-column: span 2;">
                                <label>Brief Description / Features</label>
                                <input type="text" name="description" placeholder="Technical details, fuel capacity, etc.">
                            </div>
                            <div class="form-group" style="display: flex; align-items: end;">
                                <button type="submit" class="btn-save" style="width: 100%; background: var(--primary);">Add to Inventory</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-card">
                    <table id="inventoryTable">
                        <thead>
                            <tr>
                                <th>Machinery Name</th>
                                <th>Plate Number</th>
                                <th>Rate/Hr</th>
                                <th>Current Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($equipment as $e): ?>
                            <tr>
                                <td style="font-weight: 800; color: var(--dark);"><?= esc($e['name']) ?></td>
                                <td><code style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px; font-weight: 700;"><?= esc($e['vehicle_no']) ?></code></td>
                                <td style="font-weight: 800; color: var(--primary);">₹<?= number_format($e['rate_per_hour']) ?></td>
                                <td>
                                    <span style="padding: 5px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; 
                                        background: <?= $e['status'] == 'Available' ? '#dcfce7; color: #16a34a;' : ($e['status'] == 'Booked' ? '#fef3c7; color: #d97706;' : '#f1f5f9; color: #64748b;') ?>">
                                        <?= $e['status'] ?>
                                    </span>
                                </td>
                                <td>
                                     <a href="javascript:void(0)" onclick="askConfirm('<?= base_url('admin/agriculture/inventory/delete/'.$e['id']) ?>', 'Remove this equipment?')" style="color: #ef4444; font-size: 1.1rem;"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Smart Tab Persistence for Admin
        window.onload = function() {
            const lastPane = localStorage.getItem('activeAgriPaneAdmin') || 'mandi';
            showPane(lastPane, false);
        };

        async function handleBooking(id, status) {
            let label = "Add official remarks for this status update:";
            if(status === 'Cancelled') label = "Provide reason for rejection (this will be shown to the farmer):";
            if(status === 'Approved') label = "Add coordination notes (e.g. Pickup time):";
            if(status === 'Completed') label = "Final completion notes / Hours confirmed:";

            const { value: remarks } = await Swal.fire({
                title: 'Update Booking: ' + status,
                input: 'textarea',
                inputLabel: label,
                inputPlaceholder: 'Type remarks here...',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                background: '#fff',
                borderRadius: '30px'
            });

            if (remarks !== undefined) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "<?= base_url('admin/agriculture/booking/update') ?>/" + id + "/" + status;
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = "<?= csrf_token() ?>";
                csrf.value = "<?= csrf_hash() ?>";
                form.appendChild(csrf);

                const remarkInput = document.createElement('input');
                remarkInput.type = 'hidden';
                remarkInput.name = 'remarks';
                remarkInput.value = remarks;
                form.appendChild(remarkInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        function showPane(id, saveState = true) {
            document.getElementById('mandi-pane').style.display = id === 'mandi' ? 'block' : 'none';
            document.getElementById('booking-pane').style.display = id === 'booking' ? 'block' : 'none';
            document.getElementById('inventory-pane').style.display = id === 'inventory' ? 'block' : 'none';
            
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active');
                if(b.getAttribute('onclick').includes("'"+id+"'")) b.classList.add('active');
            });

            if(saveState) localStorage.setItem('activeAgriPaneAdmin', id);
        }

        function askConfirm(url, msg) {
            Swal.fire({
                title: msg,
                text: "This record will be permanently deleted.",
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
            Swal.fire({ icon: 'success', title: 'Confirmed', text: '<?= session()->getFlashdata('success') ?>', confirmButtonColor: '#10b981' });
        <?php endif; ?>
    </script>
</body>
</html>
