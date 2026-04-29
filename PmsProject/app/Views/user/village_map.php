<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burhanpur 360 – Ultra-Mapping GIS Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Leaflet GIS Library -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        :root { --primary: #3b82f6; --dark: #0f172a; --gray-100: #f1f5f9; --gray-200: #e2e8f0; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--gray-100); display: flex; height: 100vh; overflow: hidden; }
        .sidebar { width: 260px; background: var(--dark); height: 100vh; position: fixed; padding: 1.5rem; color: white; z-index: 1000; }
        .main-content { margin-left: 260px; width: calc(100% - 260px); height: 100vh; display: flex; flex-direction: column; position: relative; }
        #map { flex: 1; width: 100%; height: 100%; z-index: 1; }

        /* Off-canvas Explorer Panel */
        .explorer-panel { 
            position: absolute; top: 15px; right: -420px; z-index: 1000; 
            background: rgba(255,255,255,0.96); width: 380px; border-radius: 30px; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.15); padding: 2rem; 
            border: 1px solid var(--gray-200); backdrop-filter: blur(14px); 
            max-height: 94vh; overflow-y: auto; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .explorer-panel.open { right: 20px; }
        .explorer-panel::-webkit-scrollbar { width: 4px; }
        .explorer-panel::-webkit-scrollbar-thumb { background: var(--gray-200); border-radius: 10px; }

        .search-box { background: var(--gray-100); border-radius: 18px; padding: 14px 20px; display: flex; align-items: center; gap: 12px; margin-bottom: 1.5rem; border: 1px solid var(--gray-200); }
        .search-box input { background: none; border: none; outline: none; flex: 1; font-weight: 600; font-size: 0.95rem; }

        .category-group { margin-bottom: 2rem; }
        .group-title { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #94a3b8; margin-bottom: 12px; letter-spacing: 1px; display: flex; align-items: center; gap: 8px; }

        .symbol-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
        .symbol-card { background: white; border: 1px solid #f1f5f9; padding: 12px 4px; border-radius: 18px; display: flex; flex-direction: column; align-items: center; gap: 8px; cursor: pointer; transition: all 0.25s; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
        .symbol-card:hover { transform: translateY(-4px); border-color: var(--primary); box-shadow: 0 10px 20px rgba(59,130,246,0.1); }
        .sym-icon { width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.9rem; }
        .symbol-card span { font-size: 0.6rem; font-weight: 800; text-transform: uppercase; color: #64748b; text-align: center; line-height: 1.1; }

        /* Floating Controls */
        .layer-toggle { position: absolute; bottom: 30px; left: 15px; z-index: 100; background: white; border-radius: 12px; display: flex; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden; border: 1px solid var(--gray-200); padding: 3px; }
        .layer-btn { padding: 10px 16px; font-size: 0.7rem; font-weight: 800; cursor: pointer; border: none; background: white; color: #64748b; border-radius: 10px; transition: 0.2s; }
        .layer-btn.active { background: var(--primary); color: white; }

        .panel-trigger { 
            position: absolute; top: 20px; right: 20px; z-index: 500; 
            background: white; width: 65px; height: 65px; border-radius: 22px; 
            display: flex; align-items: center; justify-content: center; 
            cursor: pointer; box-shadow: 0 15px 35px rgba(0,0,0,0.15); 
            border: 1px solid var(--gray-200); color: var(--primary); font-size: 1.6rem; transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .panel-trigger:hover { transform: scale(1.1) rotate(5deg); color: var(--dark); }
        .panel-trigger.active { translate: 100px; opacity: 0; }

        .close-panel { 
            position: absolute; top: 20px; right: 20px; cursor: pointer; 
            width: 38px; height: 38px; border-radius: 12px; background: var(--gray-100); 
            display: flex; align-items: center; justify-content: center; color: #64748b; transition: 0.2s;
        }
        .close-panel:hover { background: #fee2e2; color: #ef4444; }

        /* Icon Marker Styles */
        .icon-pin { width: 38px; height: 38px; border-radius: 50% 50% 50% 0; display: flex; align-items: center; justify-content: center; transform: rotate(-45deg); border: 2.5px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .icon-pin i { transform: rotate(45deg); color: white; font-size: 0.95rem; }

        .leaflet-popup-content-wrapper { border-radius: 26px !important; padding: 0 !important; overflow: hidden; }
        .p-top { padding: 25px 22px; color: white; position: relative; }
        .p-top::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom right, rgba(255,255,255,0.1), transparent); }
        .p-bot { padding: 20px 22px; background: white; }
        .nav-btn { display: flex; align-items: center; justify-content: center; gap: 10px; background: var(--primary); color: white; padding: 14px; border-radius: 16px; text-decoration: none; font-weight: 800; font-size: 0.85rem; margin-top: 15px; box-shadow: 0 8px 20px rgba(59,130,246,0.25); transition: 0.2s; }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>
    
    <div class="main-content">
        <!-- Floating Trigger -->
        <div class="panel-trigger" id="openExplorer">
            <i class="fas fa-satellite"></i>
        </div>

        <!-- Off-canvas Panel -->
        <div class="explorer-panel" id="explorerPanel">
            <div class="close-panel" id="closeExplorer">
                <i class="fas fa-times"></i>
            </div>

            <h2 style="font-weight: 800; font-size: 1.4rem; color: var(--dark); margin-bottom: 0.5rem;">Spatial Registry Legend</h2>
            <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 2rem;">Comprehensive asset categorization for Burhanpur City.</p>

            <div class="search-box">
                <i class="fas fa-search" style="color: #94a3b8;"></i>
                <input type="text" placeholder="Search infrastructure by name or type..." id="mapSearch">
            </div>

            <!-- HERITAGE & TOURISM -->
            <div class="category-group">
                <div class="group-title"><i class="fas fa-landmark-dome"></i> Heritage & Tourism</div>
                <div class="symbol-grid">
                    <div class="symbol-card" onclick="centerOnType('Historical Landmark')">
                        <div class="sym-icon" style="background: #9d174d;"><i class="fas fa-fort-awesome"></i></div>
                        <span>Shahi Qila</span>
                    </div>
                    <div class="symbol-card" onclick="centerOnType('Religious Place')">
                        <div class="sym-icon" style="background: #be185d;"><i class="fas fa-place-of-worship"></i></div>
                        <span>Religious</span>
                    </div>
                    <div class="symbol-card" onclick="centerOnType('Garden')">
                        <div class="sym-icon" style="background: #059669;"><i class="fas fa-tree-city"></i></div>
                        <span>Gardens</span>
                    </div>
                    <div class="symbol-card" onclick="centerOnType('Monument')">
                        <div class="sym-icon" style="background: #9d174d;"><i class="fas fa-monument"></i></div>
                        <span>Historical</span>
                    </div>
                </div>
            </div>

            <!-- PUBLIC ESSENTIALS -->
            <div class="category-group">
                <div class="group-title"><i class="fas fa-house-medical"></i> Public Essentials</div>
                <div class="symbol-grid">
                    <div class="symbol-card" onclick="centerOnType('Hospital')">
                        <div class="sym-icon" style="background: #dc2626;"><i class="fas fa-hospital"></i></div>
                        <span>Medical</span>
                    </div>
                    <div class="symbol-card" onclick="centerOnType('Transportation Hub')">
                        <div class="sym-icon" style="background: #1e3a8a;"><i class="fas fa-bus-simple"></i></div>
                        <span>Transport</span>
                    </div>
                    <div class="symbol-card" onclick="centerOnType('School')">
                        <div class="sym-icon" style="background: #10b981;"><i class="fas fa-graduation-cap"></i></div>
                        <span>Education</span>
                    </div>
                    <div class="symbol-card" onclick="centerOnType('Clinic')">
                        <div class="sym-icon" style="background: #dc2626;"><i class="fas fa-plus"></i></div>
                        <span>Clinics</span>
                    </div>
                </div>
            </div>

            <!-- COMMERCE & LIFE -->
            <div class="category-group">
                <div class="group-title"><i class="fas fa-cart-shopping"></i> Commerce & Life</div>
                <div class="symbol-grid">
                    <div class="symbol-card" onclick="centerOnType('Mall')">
                        <div class="sym-icon" style="background: #7c3aed;"><i class="fas fa-bag-shopping"></i></div>
                        <span>Malls</span>
                    </div>
                    <div class="symbol-card" onclick="centerOnType('Market')">
                        <div class="sym-icon" style="background: #2563eb;"><i class="fas fa-shop"></i></div>
                        <span>Markets</span>
                    </div>
                    <div class="symbol-card" onclick="centerOnType('Restaurant')">
                        <div class="sym-icon" style="background: #f97316;"><i class="fas fa-utensils"></i></div>
                        <span>Food</span>
                    </div>
                    <div class="symbol-card" onclick="resetMarkers()">
                        <div class="sym-icon" style="background: #64748b;"><i class="fas fa-rotate"></i></div>
                        <span>Reset All</span>
                    </div>
                </div>
            </div>

            <div style="background: #eff6ff; padding: 18px; border-radius: 20px; border: 1px dashed var(--primary);">
                <p style="font-size: 0.75rem; color: #1d4ed8; font-weight: 700; line-height: 1.5;"><i class="fas fa-shield-check"></i> Only Verified <strong>Urban Points of Interest</strong> are displayed. Unverified reports are held in Moderation.</p>
            </div>
        </div>

        <div class="layer-toggle">
            <button class="layer-btn active" id="btnStreet">STREET MAP</button>
            <button class="layer-btn" id="btnSat">SATELLITE</button>
        </div>

        <div id="map"></div>
    </div>

    <script>
        // Panel Toggle Logic
        const explorer = document.getElementById('explorerPanel');
        const trigger = document.getElementById('openExplorer');
        const closeBtn = document.getElementById('closeExplorer');

        trigger.onclick = () => { explorer.classList.add('open'); trigger.classList.add('active'); };
        closeBtn.onclick = () => { explorer.classList.remove('open'); trigger.classList.remove('active'); };

        const burhanpurCenter = [21.3110, 76.2280];
        const map = L.map('map', { zoomControl: false }).setView(burhanpurCenter, 15);

        const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png').addTo(map);
        const satLayer = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}');
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        document.getElementById('btnStreet').onclick = () => { map.removeLayer(satLayer); streetLayer.addTo(map); document.getElementById('btnStreet').classList.add('active'); document.getElementById('btnSat').classList.remove('active'); };
        document.getElementById('btnSat').onclick = () => { map.removeLayer(streetLayer); satLayer.addTo(map); document.getElementById('btnSat').classList.add('active'); document.getElementById('btnStreet').classList.remove('active'); };

        const assets = <?= json_encode($assets) ?>;
        const markers = [];

        const configs = {
            'Historical Landmark': { color: '#9d174d', icon: 'fa-fort-awesome' },
            'Religious Place': { color: '#be185d', icon: 'fa-place-of-worship' },
            'Garden': { color: '#059669', icon: 'fa-tree-city' },
            'Hospital': { color: '#dc2626', icon: 'fa-hospital' },
            'Medical Shop': { color: '#ef4444', icon: 'fa-pills' },
            'Transportation Hub': { color: '#1e3a8a', icon: 'fa-bus-simple' },
            'Mall': { color: '#7c3aed', icon: 'fa-bag-shopping' },
            'Market': { color: '#2563eb', icon: 'fa-shop' },
            'Restaurant': { color: '#f97316', icon: 'fa-utensils' },
            'Hotel': { color: '#6366f1', icon: 'fa-bed' },
            'School': { color: '#10b981', icon: 'fa-graduation-cap' },
            'Borewell': { color: '#3b82f6', icon: 'fa-droplet' },
            'Panchayat Bhavan': { color: '#f59e0b', icon: 'fa-landmark' },
            'Clinic': { color: '#dc2626', icon: 'fa-plus' }
        };

        assets.forEach(a => {
            const conf = configs[a.asset_type] || { color: '#4b5563', icon: 'fa-location-dot' };
            const customIcon = L.divIcon({
                className: 'custom-icon',
                html: `<div style="background-color:${conf.color}" class="icon-pin"><i class="fas ${conf.icon}"></i></div>`,
                iconSize: [38, 38],
                iconAnchor: [19, 38]
            });

            const marker = L.marker([a.latitude, a.longitude], { icon: customIcon }).addTo(map);
            const popup = `
                <div class="p-wrap">
                    <div class="p-top" style="background:${conf.color}">
                        <div style="font-size:0.6rem; text-transform:uppercase; font-weight:800; opacity:0.8;">${a.asset_type}</div>
                        <div style="font-weight:800; font-size:1.15rem; line-height:1.2;">${a.asset_name}</div>
                    </div>
                    <div class="p-bot">
                        <p style="font-size:0.88rem; color:#475569; line-height:1.5;">${a.description || 'Verified Burhanpur city infrastructure asset.'}</p>
                        <div style="margin-top:12px; font-size:0.75rem; color:#64748b; font-weight:700;"><i class="fas fa-map-pin"></i> ${a.location}</div>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=${a.latitude},${a.longitude}" target="_blank" class="nav-btn">
                            <i class="fas fa-location-arrow"></i> GET DIRECTIONS
                        </a>
                    </div>
                </div>
            `;
            marker.bindPopup(popup);
            marker.asset_type = a.asset_type;
            markers.push(marker);
        });

        function centerOnType(type) {
            markers.forEach(m => {
                if(m.asset_type === type) m.addTo(map);
                else map.removeLayer(m);
            });
            const filtered = markers.filter(m => m.asset_type === type);
            if(filtered.length > 0) map.fitBounds(new L.featureGroup(filtered).getBounds().pad(0.5));
        }

        function resetMarkers() { markers.forEach(m => m.addTo(map)); map.setView(burhanpurCenter, 15); }

        document.getElementById('mapSearch').onkeyup = (e) => {
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
                resetMarkers();
            }
        };
    </script>
</body>
</html>
