<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panchayat Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #10b981;
            --dark: #1e293b;
            --light: #f8fafc;
            --text-main: #334155;
            --text-light: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--light);
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Navbar */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo span {
            color: var(--primary);
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-main);
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white !important;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
            transition: transform 0.3s, box-shadow 0.3s !important;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
            color: white !important;
        }

        /* Hero Section */
        .hero {
            min-height: 85vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 120px 5% 40px; /* Added 120px top padding instead of margin to prevent overlap */
            background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.05), transparent 50%),
                        radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.05), transparent 50%);
        }

        .hero-content {
            text-align: center;
            max-width: 800px;
        }

        .badge {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: inline-block;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero h1 span {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-bottom: 2.5rem;
        }

        .hero-btns {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .btn {
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: var(--dark);
            border: 2px solid #e2e8f0;
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Separated Slider Section */
        .slider-section {
            position: relative;
            width: 100%;
            background: var(--dark); /* dark background looks good for pure images */
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slider-container {
            width: 100%;
            max-width: 1920px;
            display: grid;
        }

        .slide {
            grid-area: 1 / 1;
            width: 100%;
            height: auto;
            object-fit: contain;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            display: block; /* removes bottom line spacing */
        }

        .slide.active {
            opacity: 1;
        }

        .slider-controls {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 12px;
            z-index: 10;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.8);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dot.active {
            background: #ffffff;
            transform: scale(1.3);
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }

        /* Features Section */
        .features {
            padding: 5rem 5%;
            background: white;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .section-header p {
            color: var(--text-light);
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: var(--light);
            padding: 2.5rem;
            border-radius: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            z-index: 1;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon,
        .feature-card:hover h3,
        .feature-card:hover p {
            color: white;
            -webkit-text-fill-color: white;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .feature-card p {
            color: var(--text-light);
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 3rem 5% 1.5rem;
            text-align: center;
        }
        
        .footer-content {
            margin-bottom: 2rem;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            .hero h1 {
                font-size: 2.5rem;
            }
            .hero-btns {
                flex-direction: column;
            }
        }

        /* Notice Board Specific Styles */
        .notices-section {
            padding: 5rem 5%;
            background: #fff;
        }
        .notices-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        .notice-item {
            background: #f8fafc;
            border-left: 5px solid var(--primary);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        .notice-item:hover {
            transform: translateY(-5px);
        }
        .notice-tag {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 1rem;
        }
        .tag-Notice { background: #dbeafe; color: #1e40af; }
        .tag-Tender { background: #fef3c7; color: #92400e; }
        .tag-News { background: #dcfce7; color: #166534; }
        
        .notice-item h3 {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
            color: var(--dark);
        }
        .notice-item p {
            font-size: 0.95rem;
            color: var(--text-light);
            margin-bottom: 1.5rem;
        }
        .notice-date {
            font-size: 0.85rem;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav>
        <a href="<?= base_url() ?>" class="logo">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary)"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            E-<span>Panchayat</span>
        </a>
        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="<?= base_url('login') ?>" class="btn-login">Login Portal</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <div class="badge">Next-Gen Governance</div>
            <h1>Empowering Rural Administration with <span>Digital Excellence</span></h1>
            <p>A comprehensive Panchayat Management System for efficient, transparent, and responsive local governance. Streamlining daily operations, citizen services, and resource management.</p>
            <div class="hero-btns">
                <a href="#features" class="btn btn-primary">Explore Features</a>
                <a href="#about" class="btn btn-outline">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Dedicated Image Slider Section (Just Above Features) -->
    <section id="slider" class="slider-section">
        <!-- Slider Images Container -->
        <div class="slider-container">
            <img class="slide active" src="https://mppanchayatdarpan.gov.in/Resources/images/prd02.jpg" alt="Slide 1">
            <img class="slide" src="https://mppanchayatdarpan.gov.in/Resources/images/prd01.jpg" alt="Slide 2">
            <img class="slide" src="https://mppanchayatdarpan.gov.in/Resources/images/Slider_ViskitBharat.jpg" alt="Slide 3">
        </div>

        <!-- Slider Controls -->
        <div class="slider-controls">
            <div class="dot active" onclick="setSlide(0)"></div>
            <div class="dot" onclick="setSlide(1)"></div>
            <div class="dot" onclick="setSlide(2)"></div>
        </div>
    </section>

    <!-- Digital Notice Board & Tenders Section -->
    <?php if(!empty($notices)): ?>
    <section id="notices" class="notices-section">
        <div class="section-header">
            <div class="badge">Live Updates</div>
            <h2>Notice Board & Tenders</h2>
            <p>Stay updated with the latest announcements, government tenders, and news from your Gram Panchayat.</p>
        </div>
        <div class="notices-container">
            <?php foreach($notices as $notice): ?>
            <div class="notice-item">
                <span class="notice-tag tag-<?= $notice['type'] ?>"><?= $notice['type'] ?></span>
                <h3><?= esc($notice['title']) ?></h3>
                <p><?= esc($notice['content']) ?></p>
                <div class="notice-date">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    Posted on: <?= date('d M, Y', strtotime($notice['created_at'])) ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="section-header">
            <h2>Core Capabilities</h2>
            <p>Our platform offers a wide range of modules designed specifically for modern Gram Panchayat operations and citizen welfare.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3>Citizen Records</h3>
                <p>Maintain digital, secure, and easily accessible records of all village residents, demographic data, and family details.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📄</div>
                <h3>E-Certificates</h3>
                <p>Swift processing and automated issuance of crucial documents like birth, death, caste, and income certificates.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💰</div>
                <h3>Tax & Revenue</h3>
                <p>Efficiently manage tax collections, property assessments, water bills, and overall financial accounting.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🏗️</div>
                <h3>Project Tracking</h3>
                <p>Monitor village development projects, allocate budgets, track progress, and ensure transparent fund utilization.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚖️</div>
                <h3>Grievance Redressal</h3>
                <p>A dedicated portal for citizens to raise complaints, track status, and get timely resolutions from the authority.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📜</div>
                <h3>Gram Sabha Mgmt</h3>
                <p>Schedule meetings, manage agendas, record minutes, and track resolutions of Gram Sabha and Panchayat meetings.</p>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="features" style="background: var(--gray-100);">
        <div class="section-header">
            <h2>Our Digital Services</h2>
            <p>Access various government schemes and citizen services directly through our online portal.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🏨</div>
                <h3>Scheme Enrollment</h3>
                <p>Register for state and central government welfare schemes easily.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💡</div>
                <h3>Utility Bills</h3>
                <p>Pay your water, electricity, and local panchayat taxes online.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📚</div>
                <h3>Education Support</h3>
                <p>Information regarding local schools and student scholarship programs.</p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="features" style="padding: 8rem 5%;">
        <div style="display: flex; align-items: center; gap: 4rem; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 300px;">
                <h2 style="font-size: 2.5rem; color: var(--dark); margin-bottom: 1.5rem;">Dedicated to <span style="color: var(--primary);">Rural Progress</span></h2>
                <p style="color: var(--text-light); margin-bottom: 2rem; font-size: 1.1rem;">E-Panchayat is a transformative initiative designed to bring digital transparency and administrative efficiency to the grassroots of our nation. Our goal is to empower every citizen by providing seamless access to local governance services.</p>
                <ul style="list-style: none;">
                    <li style="margin-bottom: 1rem; display: flex; align-items: center; gap: 10px; color: var(--text-dark); font-weight: 500;">
                        <i class="fas fa-check-circle" style="color: var(--secondary);"></i> 100% Digital Documentation
                    </li>
                    <li style="margin-bottom: 1rem; display: flex; align-items: center; gap: 10px; color: var(--text-dark); font-weight: 500;">
                        <i class="fas fa-check-circle" style="color: var(--secondary);"></i> Transparent Fund Tracking
                    </li>
                    <li style="margin-bottom: 1rem; display: flex; align-items: center; gap: 10px; color: var(--text-dark); font-weight: 500;">
                        <i class="fas fa-check-circle" style="color: var(--secondary);"></i> 24/7 Grievance Support
                    </li>
                </ul>
            </div>
            <div style="flex: 1; min-width: 300px; height: 400px; border-radius: 30px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1); border: 1px solid var(--gray-200);">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d59834.78761271241!2d76.1953!3d21.3121!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bd82d9669527945%3A0xc6cb1c0d508e67f0!2sBurhanpur%2C%20Madhya%20Pradesh!5e0!3m2!1sen!2sin!4v1713091100000!5m2!1sen!2sin" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <h3>E-Panchayat Management System</h3>
            <p>A Project by KRISHNAL PATIL</p>
            <p>Bringing transparency and efficiency to local governance.</p>
        </div>
        <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1.5rem; font-size: 0.9rem;">
            &copy; 2026 E-Panchayat. All Rights Reserved. Designed for modern India.
        </div>
    </footer>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Navbar shadow on scroll
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 10) {
                nav.style.boxShadow = '0 4px 20px rgba(0,0,0,0.1)';
            } else {
                nav.style.boxShadow = '0 2px 15px rgba(0,0,0,0.05)';
            }
        });

        // Slider Functionality
        let currentSlideIndex = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        const totalSlides = slides.length;
        let slideInterval;

        function showSlide(index) {
            // Remove active classes
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            // Set specific slide as active
            slides[index].classList.add('active');
            dots[index].classList.add('active');
            currentSlideIndex = index;
        }

        function nextSlide() {
            let nextIndex = (currentSlideIndex + 1) % totalSlides;
            showSlide(nextIndex);
        }

        function startSlider() {
            // Change slide every 5 seconds
            slideInterval = setInterval(nextSlide, 5000);
        }

        function setSlide(index) {
            clearInterval(slideInterval);
            showSlide(index);
            startSlider();
        }

        // Initialize Slider
        if(totalSlides > 0){
            startSlider();
        }
    </script>
</body>
</html>
