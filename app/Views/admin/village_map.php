<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIS Command Center – Burhanpur City Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Leaflet GIS Library -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        :root { --primary: #6366f1; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; height: 100vh; overflow: hidden; }
        .sidebar { width: 280px; background-color: #1e293b; height: 100vh; position: fixed; padding: 2rem 1.5rem; color: white; z-index: 1000; }
        .main-content { margin-left: 280px; width: calc(100% - 280px); height: 100vh; display: flex; flex-direction: column; position: relative; }
        .header { background: white; padding: 1.5rem 2.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--gray-200); z-index: 100; flex-shrink: 0; }
        
        #map { flex: 1; width: 100%; height: 100%; z-index: 1; }
        
        /* Off-canvas Overlay Panel */
        .map-overlay { 
            position: absolute; top: 100px; right: -400px; z-index: 1000; 
            background: rgba(255,255,255,0.98); padding: 2rem; border-radius: 24px; 
            box-shadow: 0 15px 40px rgba(0,0,0,0.1); width: 360px; 
            border: 1px solid var(--gray-200); max-height: 80vh; overflow-y: auto; 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); backdrop-filter: blur(10px);
        }
        .map-overlay.open { right: 20px; }

        .search-container { margin-bottom: 1.5rem; }
        .search-box { background: var(--gray-100); border: 1px solid var(--gray-200); border-radius: 12px; padding: 10px 15px; display: flex; align-items: center; gap: 10px; }
        .search-box input { background: none; border: none; outline: none; flex: 1; font-weight: 600; font-size: 0.85rem; }

        /* Floating Controls */
        .admin-panel-trigger { 
            position: absolute; top: 100px; right: 20px; z-index: 500; 
            background: white; width: 50px; height: 50px; border-radius: 14px; 
            display: flex; align-items: center; justify-content: center; 
            cursor: pointer; box-shadow: 0 5px 15px rgba(0,0,0,0.1); 
            border: 1px solid var(--gray-200); color: var(--primary); font-size: 1.2rem; transition: 0.3s;
        }
        .admin-panel-trigger:hover { transform: scale(1.05); color: var(--dark); }
        .admin-panel-trigger.active { translate: 100px; }

        .layer-toggle { position: absolute; bottom: 30px; left: 20px; z-index: 100; background: white; border-radius: 12px; display: flex; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden; border: 1px solid var(--gray-200); padding: 3px; }
        .layer-btn { padding: 8px 14px; font-size: 0.65rem; font-weight: 800; cursor: pointer; border: none; background: white; color: #64748b; border-radius: 10px; }
        .layer-btn.active { background: var(--primary); color: white; }

        .legend-section { margin-bottom: 1.5rem; }
        .sec-title { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: #94a3b8; margin-bottom: 12px; letter-spacing: 1px; display: flex; align-items: center; gap: 8px; }
        
        .legend-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .legend-item { display: flex; align-items: center; gap: 8px; font-size: 0.72rem; font-weight: 700; color: #475569; background: #f8fafc; padding: 8px 12px; border-radius: 12px; border: 1px solid #f1f5f9; cursor: pointer; transition: 0.2s; }
        .legend-item:hover { border-color: var(--primary); background: white; transform: translateY(-2px); }
        .legend-icon { width: 24px; height: 24px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.8rem; }
        
        /* Custom Marker */
        .marker-pin { width: 40px; height: 40px; border-radius: 50% 50% 50% 0; border: 3px solid #fff; position: absolute; transform: rotate(-45deg); left: 50%; top: 50%; margin: -20px 0 0 -20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 5px 15px rgba(0,0,0,0.3); transition: 0.2s; }
        .marker-pin i { transform: rotate(45deg); color: white; font-size: 1rem; }

        .close-overlay { position: absolute; top: 20px; right: 20px; cursor: pointer; color: #94a3b8; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; background: var(--gray-100); border-radius: 8px; }
        .close-overlay:hover { color: #ef4444; background: #fee2e2; }

        .custom-popup .leaflet-popup-content-wrapper { border-radius: 20px; padding: 0; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .p-head { padding: 18px; color: white; font-weight: 800; font-size: 1rem; line-height: 1.2; }
        .p-body { padding: 18px; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('admin/partials/sidebar') ?></div>
    <div class="main-content">
        <div class="header">
            <div>
                <h1 style="font-weight: 800;"><i class="fas fa-satellite-dish" style="color:var(--primary); margin-right:10px;"></i>City Master Plan GIS – Burhanpur</h1>
                <p style="color: #64748b;">Managing Heritage, Infrastructure, and City Assets in Real-Time</p>
            </div>
            <div style="background:var(--gray-100); padding: 10px 20px; border-radius: 12px; font-weight: 800; font-size: 0.75rem; color: var(--primary);">
                <i class="fas fa-tower-broadcast"></i> DATA SOURCE: GOOGLE MAPS CLOUD
            </div>
        </div>

        <!-- Floating Admin Trigger -->
        <div class="admin-panel-trigger" id="openOverlay">
            <i class="fas fa-list-check"></i>
        </div>

        <!-- Off-canvas Overlay Panel -->
        <div class="map-overlay" id="adminOverlay">
            <i class="fas fa-times close-overlay" id="closeOverlay"></i>
            <h3 style="font-size: 1.1rem; font-weight: 800; margin-bottom: 5px; color: var(--dark);">Registry Legend</h3>
            <p style="font-size: 0.75rem; color: #94a3b8; margin-bottom: 1.5rem;">Comprehensive asset categorization for Burhanpur City.</p>
            
            <div class="search-container">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search Master Plan Assets..." id="adminSearch">
                </div>
            </div>

            <div class="legend-section">
                <div class="sec-title"><i class="fas fa-landmark-dome"></i> Heritage & Tourism</div>
                <div class="legend-grid">
                    <div class="legend-item" onclick="filterByType('Historical Landmark')">
                        <div class="legend-icon" style="background:#9d174d"><i class="fas fa-fort-awesome"></i></div> Shahi Qila
                    </div>
                    <div class="legend-item" onclick="filterByType('Religious Place')">
                        <div class="legend-icon" style="background:#be185d"><i class="fas fa-place-of-worship"></i></div> Religious
                    </div>
                    <div class="legend-item" onclick="filterByType('Garden')">
                        <div class="legend-icon" style="background:#059669"><i class="fas fa-tree"></i></div> Gardens
                    </div>
                    <div class="legend-item" onclick="filterByType('Historical Landmark')">
                        <div class="legend-icon" style="background:#9d174d"><i class="fas fa-monument"></i></div> Monuments
                    </div>
                </div>
            </div>

            <div class="legend-section">
                <div class="sec-title"><i class="fas fa-house-medical"></i> Public Essentials</div>
                <div class="legend-grid">
                    <div class="legend-item" onclick="filterByType('Hospital')">
                        <div class="legend-icon" style="background:#dc2626"><i class="fas fa-hospital"></i></div> Medical
                    </div>
                    <div class="legend-item" onclick="filterByType('Transportation Hub')">
                        <div class="legend-icon" style="background:#1e3a8a"><i class="fas fa-bus"></i></div> Transport
                    </div>
                    <div class="legend-item" onclick="filterByType('School')">
                        <div class="legend-icon" style="background:#10b981"><i class="fas fa-graduation-cap"></i></div> Education
                    </div>
                    <div class="legend-item" onclick="filterByType('Police Station')">
                        <div class="legend-icon" style="background:#1e3a8a"><i class="fas fa-shield-halved"></i></div> Security
                    </div>
                </div>
            </div>

            <div class="legend-section">
                <div class="sec-title"><i class="fas fa-bag-shopping"></i> Commerce & Life</div>
                <div class="legend-grid">
                    <div class="legend-item" onclick="filterByType('Mall')">
                        <div class="legend-icon" style="background:#7c3aed"><i class="fas fa-bag-shopping"></i></div> Malls
                    </div>
                    <div class="legend-item" onclick="filterByType('Market')">
                        <div class="legend-icon" style="background:#2563eb"><i class="fas fa-shop"></i></div> Markets
                    </div>
                    <div class="legend-item" onclick="filterByType('Restaurant')">
                        <div class="legend-icon" style="background:#ea580c"><i class="fas fa-utensils"></i></div> Restaurants
                    </div>
                    <div class="legend-item" onclick="resetView()">
                        <div class="legend-icon" style="background:#64748b"><i class="fas fa-eye"></i></div> Show All
                    </div>
                </div>
            </div>

            <div style="background: #fdf2f2; padding: 15px; border-radius: 16px; border: 1px solid #fee2e2; margin-top:20px;">
                <p style="font-size: 0.7rem; color: #991b1b; font-weight: 700; line-height:1.5;"><i class="fas fa-info-circle"></i> Only Verified <strong>Urban Points of Interest</strong> are displayed. Unverified reports are held in Moderation.</p>
            </div>
        </div>

        <!-- Layer Toggle for Admin -->
        <div class="layer-toggle">
            <button class="layer-btn active" id="btnStreet">STREET MAP</button>
            <button class="layer-btn" id="btnSat">SATELLITE</button>
        </div>

        <div id="map"></div>
    </div>

    <script>
        // Admin Panel Toggle
        const overlay = document.getElementById('adminOverlay');
        const openBtn = document.getElementById('openOverlay');
        const closeBtn = document.getElementById('closeOverlay');

        openBtn.onclick = () => { overlay.classList.add('open'); openBtn.classList.add('active'); };
        closeBtn.onclick = () => { overlay.classList.remove('open'); openBtn.classList.remove('active'); };

        const burhanpurCenter = [21.3110, 76.2280];
        const map = L.map('map', { zoomControl: false }).setView(burhanpurCenter, 15);

        // Map Layers
        const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png').addTo(map);
        const satLayer = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}');
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        document.getElementById('btnStreet').onclick = () => { map.removeLayer(satLayer); streetLayer.addTo(map); document.getElementById('btnStreet').classList.add('active'); document.getElementById('btnSat').classList.remove('active'); };
        document.getElementById('btnSat').onclick = () => { map.removeLayer(streetLayer); satLayer.addTo(map); document.getElementById('btnSat').classList.add('active'); document.getElementById('btnStreet').classList.remove('active'); };

        const assets = <?= json_encode($assets) ?>;
        const markers = [];
        
        const typeConfigs = {
            'Historical Landmark': { color: '#9d174d', icon: 'fa-fort-awesome' },
            'Religious Place': { color: '#be185d', icon: 'fa-place-of-worship' },
            'Garden': { color: '#059669', icon: 'fa-tree' },
            'Hospital': { color: '#dc2626', icon: 'fa-hospital' },
            'Medical Shop': { color: '#ef4444', icon: 'fa-pills' },
            'Transportation Hub': { color: '#1e3a8a', icon: 'fa-bus' },
            'Mall': { color: '#7c3aed', icon: 'fa-bag-shopping' },
            'Market': { color: '#2563eb', icon: 'fa-shop' },
            'Restaurant': { color: '#ea580c', icon: 'fa-utensils' },
            'Hotel': { color: '#6366f1', icon: 'fa-bed' },
            'School': { color: '#10b981', icon: 'fa-graduation-cap' },
            'Borewell': { color: '#3b82f6', icon: 'fa-droplet' },
            'Panchayat Bhavan': { color: '#f59e0b', icon: 'fa-landmark' },
            'Building': { color: '#f59e0b', icon: 'fa-building' },
            'Clinic': { color: '#dc2626', icon: 'fa-plus' },
            'Police Station': { color: '#1e3a8a', icon: 'fa-shield-halved' }
        };

        assets.forEach(a => {
            const config = typeConfigs[a.asset_type] || { color: '#475569', icon: 'fa-location-dot' };
            const customIcon = L.divIcon({
                className: 'custom-div-icon',
                html: `<div style="background-color:${config.color};" class="marker-pin"><i class="fas ${config.icon}"></i></div>`,
                iconSize: [40, 42],
                iconAnchor: [20, 42]
            });

            const marker = L.marker([a.latitude, a.longitude], { icon: customIcon }).addTo(map);
            const popupContent = `
                <div class="custom-popup">
                    <div class="p-head" style="background:${config.color}">
                        ${a.asset_name}
                    </div>
                    <div class="p-body">
                        <div style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase; color: ${config.color}; margin-bottom: 8px;">${a.asset_type}</div>
                        <div style="font-size: 0.85rem; color: #475569; line-height:1.5; margin-bottom: 15px;">${a.description || 'Verified Urban point of interest.'}</div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:0.75rem; font-weight:800; color:#10b981;"><i class="fas fa-check-circle"></i> VERIFIED</span>
                            <a href="<?= base_url('admin/assets') ?>" style="color: var(--primary); text-decoration:none; font-size:0.75rem; font-weight:800; border-bottom:2px solid var(--primary);">MANAGE →</a>
                        </div>
                    </div>
                </div>
            `;
            marker.bindPopup(popupContent);
            marker.asset = a;
            markers.push(marker);
        });

        function filterByType(type) {
            markers.forEach(m => {
                if(m.asset.asset_type === type) m.addTo(map);
                else map.removeLayer(m);
            });
            const filtered = markers.filter(m => m.asset.asset_type === type);
            if(filtered.length > 0) map.fitBounds(new L.featureGroup(filtered).getBounds().pad(0.5));
        }

        function resetView() { markers.forEach(m => m.addTo(map)); map.setView(burhanpurCenter, 15); }

        document.getElementById('adminSearch').onkeyup = (e) => {
            const q = e.target.value.toLowerCase();
            const visibleMarkers = [];
            assets.forEach((a, i) => {
                if(a.asset_name.toLowerCase().includes(q) || a.asset_type.toLowerCase().includes(q) || (a.location && a.location.toLowerCase().includes(q))) {
                    markers[i].addTo(map);
                    visibleMarkers.push(markers[i]);
                } else {
                    map.removeLayer(markers[i]);
                }
            });

            if (visibleMarkers.length > 0 && q.length > 0) {
                const group = new L.featureGroup(visibleMarkers);
                map.fitBounds(group.getBounds().pad(0.5));
            } else if (q.length === 0) {
                resetView();
            }
        };
    </script>
</body>
</html>
