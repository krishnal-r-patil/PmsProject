<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Village Marketplace - Vocal for Local</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary: #10b981; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-700: #334155; --accent: #f59e0b; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; }

        .sidebar { width: var(--sidebar-width); background-color: var(--dark); height: 100vh; position: fixed; left: 0; top: 0; color: white; padding: 1.5rem; z-index: 100; overflow-y: auto; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 90; }
        .content-padding { padding: 2.5rem; }

        .page-header { display: flex; justify-content: space-between; align-items: end; margin-bottom: 2.5rem; }
        .btn-sell { background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: 0.3s; text-decoration: none; }
        .btn-sell:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2); }

        .category-tabs { display: flex; gap: 10px; margin-bottom: 2rem; overflow-x: auto; padding-bottom: 10px; }
        .tab { padding: 8px 20px; background: white; border: 1px solid #e2e8f0; border-radius: 50px; font-size: 0.9rem; font-weight: 600; color: #64748b; cursor: pointer; transition: 0.3s; white-space: nowrap; }
        .tab.active { background: var(--primary); color: white; border-color: var(--primary); }

        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
        .product-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #e2e8f0; transition: 0.3s; display: flex; flex-direction: column; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        
        .product-img { width: 100%; height: 180px; background: #f8fafc; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: #cbd5e1; }
        
        .product-body { padding: 1.5rem; flex-grow: 1; }
        .product-cat { font-size: 0.7rem; font-weight: 800; color: var(--primary); text-transform: uppercase; margin-bottom: 5px; }
        .product-title { font-size: 1.2rem; font-weight: 800; color: var(--dark); margin-bottom: 0.5rem; }
        .product-price { font-size: 1.4rem; font-weight: 800; color: var(--dark); display: flex; align-items: baseline; gap: 4px; }
        .product-price span { font-size: 0.8rem; color: #94a3b8; font-weight: 600; }
        
        .product-footer { padding: 1rem 1.5rem; background: #f8fafc; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
        .seller-info { display: flex; align-items: center; gap: 8px; font-size: 0.8rem; font-weight: 600; color: #64748b; }
        .seller-info i { color: var(--primary); }

        .btn-contact { background: var(--dark); color: white; padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; text-decoration: none; transition: 0.3s; }
        .btn-contact:hover { background: var(--primary); }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>

    <div class="main-content">
        <header>
            <div style="font-weight: 800;"><i class="fas fa-store" style="color: var(--primary);"></i> Village Marketplace (Vocal for Local)</div>
            <div style="font-size: 0.85rem; color: #64748b;">Direct trading between residents, farmers, and artisans.</div>
        </header>

        <div class="content-padding">
            <div class="page-header">
                <div>
                    <h1 style="font-size: 2.2rem; font-weight: 800;">Village Bazaar</h1>
                    <p style="color: #64748b;">Connecting local producers with nearby buyers.</p>
                </div>
                <a href="<?= base_url('user/my-products') ?>" class="btn-sell">
                    <i class="fas fa-plus-circle"></i> List Your Product
                </a>
            </div>

            <div class="category-tabs">
                <div class="tab active" onclick="filterCat('All')">All Products</div>
                <div class="tab" onclick="filterCat('Crops')">Crops & Grains</div>
                <div class="tab" onclick="filterCat('Vegetables & Fruits')">Vegetables & Fruits</div>
                <div class="tab" onclick="filterCat('Dairy & Poultry')">Dairy & Poultry</div>
                <div class="tab" onclick="filterCat('Processed Food')">Processed Food</div>
                <div class="tab" onclick="filterCat('Handicrafts')">Handicrafts</div>
                <div class="tab" onclick="filterCat('Livestock')">Livestock</div>
                <div class="tab" onclick="filterCat('Tools & Equipment')">Tools & Machinery</div>
                <div class="tab" onclick="filterCat('Services')">Services</div>
            </div>

            <div class="product-grid">
                <?php foreach($products as $p): ?>
                <div class="product-card" data-category="<?= $p['category'] ?>">
                    <div class="product-img" style="background: white; border-bottom: 1px solid #f1f5f9;">
                        <?php 
                            $icon = '📦';
                            if($p['category'] == 'Crops') $icon = '🌾';
                            if($p['category'] == 'Handicrafts') $icon = '🎨';
                            if($p['category'] == 'Services') $icon = '🛠️';
                            if($p['category'] == 'Livestock') $icon = '🐂';
                            if($p['category'] == 'Dairy & Poultry') $icon = '🥚';
                            if($p['category'] == 'Vegetables & Fruits') $icon = '🍎';
                            if($p['category'] == 'Tools & Equipment') $icon = '🚜';
                            if($p['category'] == 'Processed Food') $icon = '🍯';
                        ?>
                        <?= $icon ?>
                    </div>
                    <div class="product-body">
                        <div class="product-cat"><?= $p['category'] ?></div>
                        <h3 class="product-title"><?= esc($p['title']) ?></h3>
                        <div class="product-price">₹<?= number_format($p['price'], 0) ?> <span>/ <?= $p['unit'] ?></span></div>
                        <p style="color: #64748b; font-size: 0.85rem; margin-top: 0.5rem;"><?= esc($p['description']) ?></p>
                    </div>
                    <div class="product-footer">
                        <div class="seller-info">
                            <i class="fas fa-user-circle"></i> <?= esc($p['seller_name']) ?>
                        </div>
                        <button class="btn-contact" onclick="viewDetails(<?= htmlspecialchars(json_encode($p)) ?>)">
                            <i class="fas fa-info-circle"></i> View Details
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Product Details Modal -->
    <div class="modal-overlay" id="detailsModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.8); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(12px); padding: 20px;">
        <div class="modal" style="background: white; width: 100%; max-width: 850px; border-radius: 35px; overflow: hidden; box-shadow: 0 50px 100px -20px rgba(0,0,0,0.5); display: flex; flex-direction: column; max-height: 95vh; animation: modalSlide 0.4s cubic-bezier(0.16, 1, 0.3, 1);">
            <div style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); padding: 2.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; gap: 25px; align-items: center;">
                    <div id="modal-icon" style="width: 90px; height: 90px; background: white; border-radius: 24px; display: flex; align-items: center; justify-content: center; font-size: 3rem; border: 1px solid #e2e8f0; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);"></div>
                    <div>
                        <div id="modal-cat" style="font-size: 0.8rem; font-weight: 800; color: var(--primary); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 6px;"></div>
                        <h2 id="modal-title" style="font-size: 2.2rem; font-weight: 800; color: var(--dark); letter-spacing: -0.5px; line-height: 1.1;"></h2>
                    </div>
                </div>
                <button onclick="closeModal()" style="border:none; background:white; width: 45px; height: 45px; border-radius: 50%; font-size: 1.5rem; cursor:pointer; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; transition: 0.3s;" onmouseover="this.style.transform='rotate(90deg)'" onmouseout="this.style.transform='rotate(0deg)'">&times;</button>
            </div>
            
            <div style="padding: 3rem; overflow-y: auto;">
                <div style="display: grid; grid-template-columns: 1.4fr 1fr; gap: 3.5rem;">
                    <div>
                        <div style="margin-bottom: 2.5rem;">
                            <h4 style="margin-bottom: 1.2rem; color: var(--dark); font-weight: 800; font-size: 1rem; display: flex; align-items: center; gap: 12px; text-transform: uppercase; letter-spacing: 1px;">
                                <span style="width: 30px; height: 30px; background: #dcfce7; color: var(--primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;"><i class="fas fa-align-left"></i></span>
                                Description & Details
                            </h4>
                            <p id="modal-desc" style="color: #475569; line-height: 1.8; font-size: 1.05rem; background: #f8fafc; padding: 2rem; border-radius: 24px; border: 1px solid #f1f5f9; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);"></p>
                        </div>

                        <div style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); padding: 2rem; border-radius: 24px; color: white;">
                            <h4 style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 0.5rem;">Verified Panchayat Listing</h4>
                            <p style="font-size: 0.85rem; color: #cbd5e1; line-height: 1.5;">This listing is moderated by the Gram Panchayat. Please ensure you verify the product physically before final payment.</p>
                        </div>
                    </div>
                    
                    <div>
                        <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 2.5rem; border-radius: 28px; margin-bottom: 2rem; color: white; box-shadow: 0 20px 25px -5px rgba(16, 185, 129, 0.3);">
                            <div style="font-size: 0.85rem; color: rgba(255,255,255,0.8); font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 1rem;">Market Price</div>
                            <div style="display: flex; align-items: baseline; gap: 8px;">
                                <span id="modal-price" style="font-size: 3rem; font-weight: 800;"></span>
                                <span id="modal-unit" style="font-size: 1rem; font-weight: 600; opacity: 0.9;"></span>
                            </div>
                        </div>

                        <div style="padding: 2rem; background: white; border: 2px solid #f1f5f9; border-radius: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                            <h4 style="margin-bottom: 1.5rem; color: var(--dark); font-weight: 800; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1.5px;">Seller Profile</h4>
                            
                            <div style="display: flex; gap: 15px; margin-bottom: 1.5rem; align-items: center;">
                                <div style="width: 55px; height: 55px; background: #eff6ff; color: #2563eb; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div>
                                    <div id="modal-seller" style="font-weight: 800; color: var(--dark); font-size: 1.1rem;"></div>
                                    <div id="modal-pariwar" style="font-size: 0.75rem; color: #64748b; font-weight: 600;"></div>
                                </div>
                            </div>

                            <div style="display: flex; gap: 15px; margin-bottom: 2rem; padding: 1rem; background: #f8fafc; border-radius: 16px;">
                                <div style="color: #64748b; font-size: 1.2rem; flex-shrink: 0;"><i class="fas fa-map-marker-alt"></i></div>
                                <div id="modal-address" style="font-size: 0.9rem; color: #475569; line-height: 1.5; font-weight: 500;"></div>
                            </div>

                            <button onclick="revealContact()" id="modal-call-btn" style="width: 100%; border:none; display: flex; height: 60px; background: var(--dark); color: white; border-radius: 18px; align-items: center; justify-content: center; gap: 12px; font-weight: 800; font-size: 1.05rem; transition: 0.3s; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); cursor:pointer;" onmouseover="this.style.background='var(--primary)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--dark)'; this.style.transform='translateY(0)'">
                                <i class="fas fa-phone-flip"></i> Connect with Seller
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden audio or hidden data holder -->
    <input type="hidden" id="current_seller_phone">

    <style>
        @keyframes modalSlide {
            from { opacity: 0; transform: translateY(30px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function filterCat(cat) {
            const cards = document.querySelectorAll('.product-card');
            const tabs = document.querySelectorAll('.tab');
            
            tabs.forEach(t => {
                t.classList.remove('active');
                if(t.innerText === cat || (cat === 'All' && t.innerText === 'All Products')) t.classList.add('active');
            });

            cards.forEach(c => {
                if(cat === 'All' || c.dataset.category === cat) {
                    c.style.display = 'flex';
                } else {
                    c.style.display = 'none';
                }
            });
        }

        function viewDetails(p) {
            const icons = {
                'Crops': '🌾', 'Handicrafts': '🎨', 'Services': '🛠️', 
                'Livestock': '🐂', 'Dairy & Poultry': '🥚', 'Vegetables & Fruits': '🍎', 
                'Tools & Equipment': '🚜', 'Processed Food': '🍯'
            };

            document.getElementById('modal-icon').innerText = icons[p.category] || '📦';
            document.getElementById('modal-cat').innerText = p.category;
            document.getElementById('modal-title').innerText = p.title;
            document.getElementById('modal-desc').innerText = p.description;
            document.getElementById('modal-price').innerText = '₹' + parseInt(p.price).toLocaleString();
            document.getElementById('modal-unit').innerText = 'per ' + p.unit;
            document.getElementById('modal-seller').innerText = p.seller_name;
            document.getElementById('modal-pariwar').innerText = 'Pariwar ID: ' + (p.pariwar_id || 'N/A');
            document.getElementById('modal-address').innerText = p.seller_address || 'Address registered with Panchayat.';
            
            // Store phone number for the reveal function
            document.getElementById('current_seller_phone').value = p.contact_phone;
            
            document.getElementById('detailsModal').style.display = 'flex';
        }

        function revealContact() {
            const phone = document.getElementById('current_seller_phone').value;
            const seller = document.getElementById('modal-seller').innerText;
            const product = document.getElementById('modal-title').innerText;

            Swal.fire({
                title: '',
                html: `
                    <div style="background: #1e293b; border-radius: 35px; overflow: hidden; color: white; text-align: center; font-family: 'Outfit', sans-serif;">
                        <!-- Virtual Phone Screen -->
                        <div style="background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%); padding: 3rem 2rem; position: relative;">
                            <div style="width: 100px; height: 100px; background: white; border-radius: 30px; margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: #1e293b; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <h2 style="font-size: 1.8rem; font-weight: 800; margin-bottom: 5px;">${seller}</h2>
                            <p style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 2rem;">Connecting for: ${product}</p>
                            
                            <div style="font-size: 2.5rem; font-weight: 800; color: #10b981; letter-spacing: 2px; margin-bottom: 2rem;">
                                ${phone}
                            </div>

                            <div style="display: flex; justify-content: center; gap: 20px; margin-bottom: 1rem;">
                                <div onclick="navigator.clipboard.writeText('${phone}'); Swal.fire({title: 'Saved!', text: 'Number ready to paste', icon: 'success', timer: 1000, showConfirmButton: false})" style="width: 60px; height: 60px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s;">
                                    <i class="fas fa-copy"></i>
                                </div>
                                <div onclick="window.open('https://wa.me/91${phone}')" style="width: 60px; height: 60px; background: #25d366; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s;">
                                    <i class="fab fa-whatsapp" style="font-size: 1.5rem;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Scan to Call Section -->
                        <div style="background: white; padding: 2.5rem; color: #1e293b;">
                            <p style="font-weight: 800; text-transform: uppercase; font-size: 0.75rem; color: #10b981; letter-spacing: 1px; margin-bottom: 1rem;">Official Marketplace Portal</p>
                            <h4 style="font-size: 1.1rem; font-weight: 800; margin-bottom: 1.5rem; color: var(--dark);">Vocal for Local Initiative</h4>
                            
                            <div style="width: 150px; height: 150px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 24px; margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center; position: relative; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                                <div id="swalQr" style="padding: 10px; background: white; border-radius: 12px;"></div>
                            </div>
                            
                            <div style="display: flex; flex-direction: column; gap: 10px; text-align: left; background: #f0fdf4; padding: 1.2rem; border-radius: 15px; border: 1px solid #dcfce7;">
                                <div style="display: flex; gap: 8px; font-size: 0.8rem; color: #166534; font-weight: 600;">
                                    <i class="fas fa-check-circle" style="margin-top: 3px;"></i> Registered Panchayat Seller
                                </div>
                                <div style="display: flex; gap: 8px; font-size: 0.8rem; color: #166534; font-weight: 600;">
                                    <i class="fas fa-shield-halved" style="margin-top: 3px;"></i> Verified Community Listing
                                </div>
                                <div style="display: flex; gap: 8px; font-size: 0.8rem; color: #166534; font-weight: 600;">
                                    <i class="fas fa-handshake" style="margin-top: 3px;"></i> Direct-to-Consumer Pricing
                                </div>
                            </div>
                            
                            <p style="font-size: 0.85rem; color: #94a3b8; line-height: 1.5; margin-top: 1.5rem;">Scan this QR with your mobile to support local producers and complete your trade safely.</p>
                        </div>
                        
                        <div style="padding: 1rem; border-top: 1px solid #f1f5f9; background: #f8fafc;">
                           <button onclick="Swal.close()" style="border:none; background:none; color: #64748b; font-weight: 700; cursor:pointer;">Close Dialer</button>
                        </div>
                    </div>
                `,
                didOpen: () => {
                    new QRCode(document.getElementById("swalQr"), {
                        text: `tel:${phone}`,
                        width: 120,
                        height: 120,
                        colorDark : "#0f172a",
                        colorLight : "#ffffff",
                        correctLevel : QRCode.CorrectLevel.H
                    });
                },
                showConfirmButton: false,
                padding: '0',
                background: 'transparent',
                borderRadius: '35px',
                width: '450px'
            });
        }

        function closeModal() {
            document.getElementById('detailsModal').style.display = 'none';
        }

        document.onkeydown = function(evt) {
            evt = evt || window.event;
            if (evt.keyCode == 27) { closeModal(); }
        };
    </script>
</body>
</html>
