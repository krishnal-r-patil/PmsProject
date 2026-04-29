<style>
    /* 
       UNIVERSAL SIDEBAR REPAIR 
       Forcing absolute consistency across all Gram Panchayat service modules.
    */
    :root {
        --sidebar-width: 280px !important;
        --sidebar-primary: #6366f1 !important;
        --sidebar-dark: #1e293b !important;
    }

    /* Target the sidebar class with highest possible CSS specificity */
    html body .sidebar, 
    html body div.sidebar,
    .sidebar { 
        width: var(--sidebar-width) !important; 
        padding: 2.5rem 1.5rem 5rem 1.5rem !important; /* Added bottom padding for scroll room */
        background-color: var(--sidebar-dark) !important; 
        font-family: 'Outfit', sans-serif !important;
        height: 100vh !important;
        max-height: 100vh !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        position: fixed !important;
        left: 0 !important;
        top: 0 !important;
        z-index: 10000 !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    /* PREMIUM SCROLLBAR */
    .sidebar::-webkit-scrollbar { width: 6px !important; }
    .sidebar::-webkit-scrollbar-track { background: transparent !important; }
    .sidebar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15) !important; border-radius: 10px !important; }
    .sidebar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.25) !important; }

    /* Fix the main content area overlap definitively */
    html body .main-content,
    html body div.main-content,
    .main-content { 
        margin-left: var(--sidebar-width) !important; 
        width: calc(100% - var(--sidebar-width)) !important; 
        display: block !important;
        min-height: 100vh !important;
    }

    /* Brand Styling */
    #sidebar-premium-brand.sidebar-brand { 
        font-size: 1.6rem !important; 
        font-weight: 800 !important; 
        margin-bottom: 3rem !important; 
        display: flex !important; 
        align-items: center !important; 
        gap: 12px !important; 
        color: white !important; 
        text-decoration: none !important; 
        letter-spacing: -0.5px !important;
        padding: 0 !important;
        width: 100% !important;
        white-space: nowrap !important;
        overflow: visible !important;
    }
    
    #sidebar-premium-brand.sidebar-brand i { 
        color: var(--sidebar-primary) !important; 
        background: rgba(99, 102, 241, 0.15) !important;
        width: 45px !important;
        height: 45px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 12px !important;
        font-size: 1.2rem !important;
        flex-shrink: 0 !important;
    }

    #sidebar-premium-brand.sidebar-brand span {
        color: white !important;
        text-transform: none !important;
        font-family: 'Outfit', sans-serif !important;
        white-space: nowrap !important;
    }
    
    .nav-menu { 
        list-style: none !important; 
        padding: 0 !important; 
        margin: 0 !important; 
        display: flex !important;
        flex-direction: column !important;
    }

    .nav-label {
        font-size: 0.72rem !important; 
        color: #64748b !important; 
        margin: 2.2rem 0 0.8rem 0.5rem !important; 
        text-transform: uppercase !important; 
        font-weight: 800 !important;
        letter-spacing: 1.5px !important;
    }

    .nav-link { 
        display: flex !important; 
        align-items: center !important; 
        gap: 12px !important; 
        padding: 0.9rem 1.2rem !important; 
        color: #94a3b8 !important; 
        text-decoration: none !important; 
        border-radius: 14px !important; 
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important; 
        margin-bottom: 0.4rem !important; 
        font-weight: 500 !important;
        font-size: 0.95rem !important;
        white-space: nowrap !important;
    }

    .nav-link i { 
        width: 24px !important; 
        text-align: center !important; 
        font-size: 1.1rem !important;
        transition: transform 0.3s ease !important;
    }

    .nav-link:hover { 
        background-color: rgba(255, 255, 255, 0.05) !important; 
        color: white !important; 
        transform: translateX(6px) !important;
    }

    .nav-link.active { 
        background: linear-gradient(135deg, var(--sidebar-primary), #4f46e5) !important;
        color: white !important; 
        box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3) !important;
    }

    .logout-btn {
        margin-top: 3.5rem !important;
        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding-top: 2rem !important;
        margin-bottom: 3rem !important; /* Buffer at bottom */
    }

    .logout-btn .nav-link {
        color: #fda4af !important;
    }

    .sidebar-user-glance {
        background: rgba(255, 255, 255, 0.03) !important;
        padding: 1.2rem !important;
        border-radius: 18px !important;
        margin-bottom: 1.5rem !important;
        border: 1px solid rgba(255, 255, 255, 0.06) !important;
    }

    .glance-role {
        font-size: 0.65rem !important;
        text-transform: uppercase !important;
        color: var(--sidebar-primary) !important;
        font-weight: 800 !important;
        display: block !important;
        margin-bottom: 6px !important;
        letter-spacing: 0.5px !important;
    }

    .glance-status {
        font-size: 0.82rem !important;
        color: #e2e8f0 !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        font-weight: 500 !important;
    }

    .status-dot {
        width: 9px !important;
        height: 9px !important;
        background: #10b981 !important;
        border-radius: 50% !important;
        box-shadow: 0 0 12px #10b981 !important;
        animation: pulse_sidebar 2s infinite !important;
    }

    @keyframes pulse_sidebar {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
</style>

<div class="sidebar-brand" id="sidebar-premium-brand">
    <i class="fas fa-landmark"></i>
    <span>E-Panchayat</span>
</div>

<div class="sidebar-user-glance">
    <span class="glance-role">Authenticated Hub</span>
    <div class="glance-status">
        <div class="status-dot"></div>
        <span>System Admin Online</span>
    </div>
</div>

<ul class="nav-menu">
    <li>
        <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= current_url() == base_url('admin/dashboard') ? 'active' : '' ?>">
            <i class="fas fa-chart-pie"></i> Executive Dashboard
        </a>
    </li>
    
    <div class="nav-label">Citizen Registry</div>
    <li><a href="<?= base_url('register') ?>" class="nav-link"><i class="fas fa-user-plus"></i> Enrollment Hub</a></li>
    <li><a href="<?= base_url('admin/residents') ?>" class="nav-link <?= current_url() == base_url('admin/residents') ? 'active' : '' ?>"><i class="fas fa-users-viewfinder"></i> Pariwar Register</a></li>
    <li><a href="<?= base_url('admin/register-docs') ?>" class="nav-link <?= current_url() == base_url('admin/register-docs') ? 'active' : '' ?>"><i class="fas fa-address-book"></i> Birth/Death Register</a></li>
    <li><a href="<?= base_url('admin/permissions') ?>" class="nav-link <?= current_url() == base_url('admin/permissions') ? 'active' : '' ?>"><i class="fas fa-signature"></i> Official Permits</a></li>
    <li><a href="<?= base_url('admin/staff') ?>" class="nav-link <?= current_url() == base_url('admin/staff') ? 'active' : '' ?>"><i class="fas fa-id-badge"></i> Staff Management</a></li>

    <div class="nav-label">Service & Scheme Mgmt</div>
    <li><a href="<?= base_url('admin/categories') ?>" class="nav-link <?= current_url() == base_url('admin/categories') ? 'active' : '' ?>"><i class="fas fa-tags"></i> Service Categories</a></li>
    <li><a href="<?= base_url('admin/cert-approvals') ?>" class="nav-link <?= current_url() == base_url('admin/cert-approvals') ? 'active' : '' ?>"><i class="fas fa-file-shield"></i> E-Cert Approvals</a></li>
    <li><a href="<?= base_url('admin/scheme-applications') ?>" class="nav-link <?= current_url() == base_url('admin/scheme-applications') ? 'active' : '' ?>"><i class="fas fa-check-double"></i> Scheme Submissions</a></li>
    <li><a href="<?= base_url('admin/schemes') ?>" class="nav-link <?= current_url() == base_url('admin/schemes') ? 'active' : '' ?>"><i class="fas fa-award"></i> Welfare Schemes</a></li>

    <div class="nav-label">Communication & Support</div>
    <li><a href="<?= base_url('admin/complaints') ?>" class="nav-link <?= current_url() == base_url('admin/complaints') ? 'active' : '' ?>"><i class="fas fa-headset"></i> Citizen Desk</a></li>
    <li><a href="<?= base_url('admin/notices') ?>" class="nav-link <?= current_url() == base_url('admin/notices') ? 'active' : '' ?>"><i class="fas fa-bullhorn"></i> Notices & Tenders</a></li>

    <div class="nav-label">Finance & Revenue</div>
    <li><a href="<?= base_url('admin/transactions') ?>" class="nav-link <?= current_url() == base_url('admin/transactions') ? 'active' : '' ?>"><i class="fas fa-scale-balanced"></i> Financial Ledger</a></li>
    <li><a href="<?= base_url('admin/taxes') ?>" class="nav-link <?= current_url() == base_url('admin/taxes') ? 'active' : '' ?>"><i class="fas fa-hand-holding-dollar"></i> Revenue Tracking</a></li>

    <div class="nav-label">Infrastructure Mgmt</div>
    <li><a href="<?= base_url('admin/marketplace') ?>" class="nav-link <?= current_url() == base_url('admin/marketplace') ? 'active' : '' ?>"><i class="fas fa-store"></i> Village Bazaar</a></li>
    <li><a href="<?= base_url('admin/utilities') ?>" class="nav-link <?= current_url() == base_url('admin/utilities') ? 'active' : '' ?>"><i class="fas fa-bolt"></i> Utility Moderation</a></li>
    <li><a href="<?= base_url('admin/agriculture') ?>" class="nav-link <?= current_url() == base_url('admin/agriculture') ? 'active' : '' ?>"><i class="fas fa-tractor"></i> Agriculture Hub</a></li>
    <li><a href="<?= base_url('admin/emergency') ?>" class="nav-link <?= current_url() == base_url('admin/emergency') ? 'active' : '' ?>"><i class="fas fa-ambulance"></i> Emergency Alerts</a></li>

    <div class="nav-label">Development & GIS</div>
    <li><a href="<?= base_url('admin/projects') ?>" class="nav-link <?= current_url() == base_url('admin/projects') ? 'active' : '' ?>"><i class="fas fa-road"></i> GPDP Projects</a></li>
    <li><a href="<?= base_url('admin/transparency') ?>" class="nav-link <?= current_url() == base_url('admin/transparency') ? 'active' : '' ?>"><i class="fas fa-shield-alt"></i> Transparency Vault</a></li>
    <li><a href="<?= base_url('admin/assets') ?>" class="nav-link <?= current_url() == base_url('admin/assets') ? 'active' : '' ?>"><i class="fas fa-city"></i> Asset Inventory</a></li>
    <li><a href="<?= base_url('admin/village-map') ?>" class="nav-link <?= current_url() == base_url('admin/village-map') ? 'active' : '' ?>"><i class="fas fa-map-location-dot"></i> GIS Village Mapping</a></li>

    <div class="nav-label">Direct Governance</div>
    <li><a href="<?= base_url('admin/proceedings') ?>" class="nav-link <?= current_url() == base_url('admin/proceedings') ? 'active' : '' ?>"><i class="fas fa-file-invoice"></i> Gram Sabha Minutes</a></li>
    <li><a href="<?= base_url('admin/democracy') ?>" class="nav-link <?= current_url() == base_url('admin/democracy') ? 'active' : '' ?>"><i class="fas fa-check-to-slot"></i> Polling & Suggestions</a></li>
    
    <div class="nav-label">Education Hub</div>
    <li><a href="<?= base_url('admin/elearning') ?>" class="nav-link <?= current_url() == base_url('admin/elearning') ? 'active' : '' ?>"><i class="fas fa-graduation-cap"></i> E-Learning & Skills</a></li>

    <div class="nav-label">AI Assistant Hub</div>
    <li><a href="<?= base_url('ai-assistant') ?>" class="nav-link <?= current_url() == base_url('ai-assistant') ? 'active' : '' ?>"><i class="fas fa-brain" style="color: #6366f1;"></i> AI Gram-Sahayak</a></li>

    <li class="logout-btn"><a href="<?= base_url('logout') ?>" class="nav-link"><i class="fas fa-power-off"></i> Secure Logout</a></li>
</ul>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function askConfirm(url, msg = "Are you sure you want to perform this action?") {
        Swal.fire({
            title: 'Wait!',
            text: msg,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6366f1',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Yes, Proceed',
            cancelButtonText: 'Cancel',
            borderRadius: '20px',
            backdrop: `rgba(15, 23, 42, 0.4)`
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
        return false;
    }
</script>
