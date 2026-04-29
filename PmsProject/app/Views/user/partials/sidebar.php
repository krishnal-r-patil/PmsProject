<style>
    /* 
       USER SIDEBAR UNIVERSAL REPAIR
       Forcing absolute consistency across all citizen service modules.
    */
    :root {
        --user-sidebar-width: 260px !important;
        --user-primary: #2563eb !important;
        --user-dark: #0f172a !important;
    }

    /* Target the sidebar class with highest possible CSS specificity */
    html body .sidebar, 
    html body div.sidebar,
    .sidebar { 
        width: var(--user-sidebar-width) !important; 
        background-color: var(--user-dark) !important; 
        height: 100vh !important; 
        max-height: 100vh !important;
        position: fixed !important; 
        left: 0 !important; 
        top: 0 !important; 
        padding: 2rem 1.5rem 5rem 1.5rem !important; /* Added bottom padding buffer */
        z-index: 10001 !important; 
        overflow-y: auto !important;
        overflow-x: hidden !important;
        font-family: 'Outfit', sans-serif !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        border-right: 1px solid rgba(255, 255, 255, 0.05) !important;
    }

    /* CUSTOM SLIM SCROLLBAR */
    .sidebar::-webkit-scrollbar { width: 5px !important; }
    .sidebar::-webkit-scrollbar-track { background: transparent !important; }
    .sidebar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1) !important; border-radius: 10px !important; }
    .sidebar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.2) !important; }

    /* DEFINITIVE CONTENT ALIGNMENT */
    html body .main-content,
    html body div.main-content,
    .main-content { 
        margin-left: var(--user-sidebar-width) !important; 
        width: calc(100% - var(--user-sidebar-width)) !important; 
        display: block !important;
        min-height: 100vh !important;
    }

    .sidebar-brand { font-size: 1.5rem !important; font-weight: 700 !important; margin-bottom: 2.5rem !important; display: flex !important; align-items: center !important; gap: 10px !important; color: white !important; text-decoration: none !important; font-family: 'Outfit', sans-serif !important; }
    .sidebar-brand i { color: var(--user-primary) !important; }
    
    .nav-menu { 
        list-style: none !important; 
        padding: 0 !important; 
        margin: 0 !important; 
        display: flex !important;
        flex-direction: column !important;
    }
    
    .nav-link { 
        display: flex !important; 
        align-items: center !important; 
        gap: 12px !important; 
        padding: 0.85rem 1.2rem !important; 
        color: #94a3b8 !important; 
        text-decoration: none !important; 
        border-radius: 12px !important; 
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important; 
        margin-bottom: 0.3rem !important; 
        font-family: 'Outfit', sans-serif !important; 
        font-size: 0.94rem !important; 
        font-weight: 500 !important;
        white-space: nowrap !important;
    }
    
    .nav-link:hover, .nav-link.active { background-color: #1e293b !important; color: white !important; transform: translateX(6px) !important; }
    .nav-link.active { background-color: var(--user-primary) !important; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3) !important; }
    
    .nav-link i { width: 22px !important; text-align: center !important; font-size: 1.05rem !important; transition: transform 0.2s !important; }
    .nav-link:hover i { transform: scale(1.1) !important; }

    .nav-section-label {
        font-size: 0.72rem !important; 
        color: #4b5563 !important; 
        margin: 2rem 0 0.8rem 0.6rem !important; 
        text-transform: uppercase !important; 
        font-weight: 800 !important;
        letter-spacing: 1.5px !important;
    }

    .logout-btn-item {
        margin-top: 3rem !important;
        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding-top: 1.5rem !important;
        margin-bottom: 3rem !important;
    }
</style>

<div class="sidebar-brand">
    <i class="fas fa-landmark"></i>
    <span>E-Panchayat</span>
</div>

<ul class="nav-menu">
    <li><a href="<?= base_url('user/dashboard') ?>" class="nav-link <?= current_url() == base_url('user/dashboard') ? 'active' : '' ?>"><i class="fas fa-home"></i> Home Dashboard</a></li>
    
    <div class="nav-section-label">Registry & Records</div>
    <li>
        <a href="<?= base_url('user/my-documents') ?>" class="nav-link <?= current_url() == base_url('user/my-documents') ? 'active' : '' ?>">
            <i class="fas fa-vault"></i> My Digital Vault
        </a>
    </li>
    <li><a href="<?= base_url('user/certificates') ?>" class="nav-link <?= current_url() == base_url('user/certificates') ? 'active' : '' ?>"><i class="fas fa-file-invoice"></i> Apply for E-Certificates</a></li>
    <li><a href="<?= base_url('user/staff-directory') ?>" class="nav-link <?= current_url() == base_url('user/staff-directory') ? 'active' : '' ?>"><i class="fas fa-id-badge"></i> Staff Directory</a></li>

    <div class="nav-section-label">Welfare & Public Services</div>
    <li><a href="<?= base_url('user/schemes') ?>" class="nav-link <?= current_url() == base_url('user/schemes') ? 'active' : '' ?>"><i class="fas fa-award"></i> Welfare Schemes</a></li>
    <li><a href="<?= base_url('user/agriculture') ?>" class="nav-link <?= current_url() == base_url('user/agriculture') ? 'active' : '' ?>"><i class="fas fa-tractor"></i> Agriculture Hub</a></li>
    <li><a href="<?= base_url('user/emergency') ?>" class="nav-link <?= current_url() == base_url('user/emergency') ? 'active' : '' ?>"><i class="fas fa-ambulance"></i> Emergency & Health Hub</a></li>
    <li><a href="<?= base_url('user/grievances') ?>" class="nav-link <?= current_url() == base_url('user/grievances') ? 'active' : '' ?>"><i class="fas fa-exclamation-circle"></i> Online Complaints</a></li>

    <div class="nav-section-label">Development & Infrastructure</div>
    <li><a href="<?= base_url('user/projects') ?>" class="nav-link <?= current_url() == base_url('user/projects') ? 'active' : '' ?>"><i class="fas fa-city"></i> Work Progress</a></li>
    <li><a href="<?= base_url('user/village-map') ?>" class="nav-link <?= current_url() == base_url('user/village-map') ? 'active' : '' ?>"><i class="fas fa-map-marked-alt"></i> Village GIS Hub</a></li>
    <li><a href="<?= base_url('user/assets') ?>" class="nav-link <?= current_url() == base_url('user/assets') ? 'active' : '' ?>"><i class="fas fa-landmark-flag"></i> Asset Directory</a></li>
    <li><a href="<?= base_url('user/notices') ?>" class="nav-link <?= current_url() == base_url('user/notices') ? 'active' : '' ?>"><i class="fas fa-bullhorn"></i> Notice Board</a></li>

    <div class="nav-section-label">Village Utilities & Market</div>
    <li><a href="<?= base_url('user/pay-taxes') ?>" class="nav-link <?= current_url() == base_url('user/pay-taxes') ? 'active' : '' ?>"><i class="fas fa-hand-holding-dollar"></i> Village Taxes</a></li>
    <li><a href="<?= base_url('user/marketplace') ?>" class="nav-link <?= current_url() == base_url('user/marketplace') ? 'active' : '' ?>"><i class="fas fa-store"></i> Village Bazaar</a></li>
    <li><a href="<?= base_url('user/utilities') ?>" class="nav-link <?= current_url() == base_url('user/utilities') ? 'active' : '' ?>"><i class="fas fa-bolt"></i> Utilities Hub</a></li>
    <li><a href="<?= base_url('user/permissions') ?>" class="nav-link <?= current_url() == base_url('user/permissions') ? 'active' : '' ?>"><i class="fas fa-handshake"></i> Event Permission</a></li>

    <div class="nav-section-label">Direct Governance</div>
    <li><a href="<?= base_url('user/transparency') ?>" class="nav-link <?= current_url() == base_url('user/transparency') ? 'active' : '' ?>"><i class="fas fa-shield-alt"></i> Transparency Vault</a></li>
    <li><a href="<?= base_url('user/proceedings') ?>" class="nav-link <?= current_url() == base_url('user/proceedings') ? 'active' : '' ?>"><i class="fas fa-file-invoice"></i> Gram Sabha Minutes</a></li>
    <li><a href="<?= base_url('user/democracy') ?>" class="nav-link <?= current_url() == base_url('user/democracy') ? 'active' : '' ?>"><i class="fas fa-check-to-slot"></i> Polling Hub</a></li>

    <div class="nav-section-label">Education Hub</div>
    <li><a href="<?= base_url('user/elearning') ?>" class="nav-link <?= current_url() == base_url('user/elearning') ? 'active' : '' ?>"><i class="fas fa-graduation-cap"></i> E-Learning & Skills</a></li>

    <div class="nav-section-label">Profile Hub</div>
    <li><a href="<?= base_url('user/payment-history') ?>" class="nav-link <?= current_url() == base_url('user/payment-history') ? 'active' : '' ?>"><i class="fas fa-receipt"></i> Payment Records</a></li>
    <li><a href="<?= base_url('user/profile') ?>" class="nav-link <?= current_url() == base_url('user/profile') ? 'active' : '' ?>"><i class="fas fa-user-circle"></i> My Profile</a></li>

    <div class="nav-section-label">AI Assistant</div>
    <li><a href="<?= base_url('ai-assistant') ?>" class="nav-link <?= current_url() == base_url('ai-assistant') ? 'active' : '' ?>"><i class="fas fa-robot" style="color: #6366f1;"></i> AI Gram-Sahayak</a></li>
    
    <li class="logout-btn-item"><a href="<?= base_url('logout') ?>" class="nav-link" style="color: #fb7185 !important;"><i class="fas fa-power-off"></i> Secure Logout</a></li>
</ul>
