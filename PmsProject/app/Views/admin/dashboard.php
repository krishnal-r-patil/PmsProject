<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Hub | Gram Panchayat Management System</title>
    <!-- Fonts: Outfit for a premium feel -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --sidebar-width: 280px;
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #ec4899;
            --dark: #0f172a;
            --dark-sidebar: #1e293b;
            --glass-bg: rgba(255, 255, 255, 0.85);
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            --accent-blue: #3b82f6;
            --accent-green: #10b981;
            --accent-purple: #8b5cf6;
            --accent-orange: #f59e0b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(236, 72, 153, 0.05) 0px, transparent 50%);
            display: flex;
            min-height: 100vh;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* Sidebar Styles Overrides */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--dark-sidebar);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            color: white;
            padding: 2rem 1.5rem;
            z-index: 1000;
            overflow-y: auto;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            scrollbar-width: thin;
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        /* Main Content wrapper */
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            display: flex;
            flex-direction: column;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Header / Navbar */
        header {
            height: 80px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .header-title h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
        }

        .user-controls {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-btn {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .notification-btn:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--secondary);
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid white;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            box-shadow: 0 0 10px rgba(236, 72, 153, 0.4);
        }

        /* Notification Dropdown */
        .notification-wrapper { position: relative; }
        .notification-dropdown {
            position: absolute;
            top: 55px;
            right: 0;
            width: 350px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            padding: 1.5rem;
            display: none;
            z-index: 1100;
            transform-origin: top right;
            animation: dropdownFade 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @keyframes dropdownFade {
            from { opacity: 0; transform: scale(0.95) translateY(-10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .notification-dropdown.show { display: block; }
        .nt-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding-bottom: 10px; border-bottom: 1px solid #f1f5f9; }
        .nt-header h4 { font-size: 1rem; font-weight: 700; color: var(--dark); }
        .nt-item { padding: 12px; border-radius: 12px; transition: 0.2s; cursor: pointer; display: flex; gap: 12px; margin-bottom: 8px; text-decoration: none; }
        .nt-item:hover { background: #f8fafc; }
        .nt-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: #eff6ff; color: #3b82f6; flex-shrink: 0; }
        .nt-info { line-height: 1.4; }
        .nt-title { font-size: 0.85rem; font-weight: 700; color: var(--dark); display: block; }
        .nt-desc { font-size: 0.75rem; color: #64748b; display: block; }
        
        .nt-list { 
            max-height: 400px; 
            overflow-y: auto; 
            padding-right: 5px;
            scrollbar-width: thin;
        }
        .nt-list::-webkit-scrollbar { width: 5px; }
        .nt-list::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }

        .profile-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 12px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
            border: 1px solid #f1f5f9;
        }

        .avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--accent-purple));
            color: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .profile-info {
            line-height: 1.2;
        }

        .profile-name {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--dark);
        }

        .profile-role {
            display: block;
            font-size: 0.75rem;
            color: #64748b;
        }

        /* Content Area */
        .content-body {
            padding: 2rem;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .welcome-section {
            margin-bottom: 2.5rem;
        }

        .welcome-section h1 {
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(to right, var(--dark), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        .welcome-section p {
            color: #64748b;
            font-size: 1.1rem;
        }

        /* Stats Grid - Vibrant & Glassy */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: white;
            padding: 1.75rem;
            border-radius: 24px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.5);
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle at top right, var(--card-glow), transparent 70%);
            opacity: 0.4;
            pointer-events: none;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-icon-box {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-info .stat-label {
            font-size: 0.95rem;
            font-weight: 500;
            color: #64748b;
            margin-bottom: 4px;
        }

        .stat-info .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .trend-up { color: var(--accent-green); }
        .trend-down { color: #ef4444; }

        /* Specific Color Variations */
        .card-blue { --card-glow: #bfdbfe; }
        .card-green { --card-glow: #bbf7d0; }
        .card-orange { --card-glow: #ffedd5; }
        .card-purple { --card-glow: #e9d5ff; }

        .bg-blue-soft { background: #eff6ff; color: #3b82f6; }
        .bg-green-soft { background: #f0fdf4; color: #22c55e; }
        .bg-orange-soft { background: #fff7ed; color: #f59e0b; }
        .bg-purple-soft { background: #faf5ff; color: #a855f7; }

        /* Dashboard Mid-Section */
        .visual-card {
            background: white;
            border-radius: 24px;
            padding: 1.75rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255,255,255,0.5);
        }

        /* 3D and Mini Charts Styles */
        .visual-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
            perspective: 1200px;
        }

        .premium-3d-card {
            background: white;
            border-radius: 24px;
            padding: 1.75rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255,255,255,0.5);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transform-style: preserve-3d;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .premium-3d-card:hover {
            transform: rotateX(4deg) rotateY(-4deg) translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        }

        .premium-3d-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.4), transparent);
            transform: skewX(-25deg);
            transition: 0.75s;
        }

        .premium-3d-card:hover::before {
            left: 125%;
        }

        .card-3d-inner {
            transform: translateZ(50px);
        }

        .mini-bar-chart {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            height: 100px;
            margin-top: 1.5rem;
        }

        .bar-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .bar {
            width: 100%;
            background: linear-gradient(to top, var(--primary), var(--accent-purple));
            border-radius: 6px;
            transition: height 1s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            min-height: 5px;
        }

        .bar-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: #64748b;
        }

        .progress-3d-wrapper {
            margin-top: 2rem;
        }

        .progress-3d-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
        }

        .progress-3d-track {
            height: 14px;
            background: #f1f5f9;
            border-radius: 20px;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
            position: relative;
        }

        .progress-3d-fill {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: linear-gradient(90deg, var(--accent-blue), var(--accent-green));
            border-radius: 20px;
            transition: width 2s ease-in-out;
            box-shadow: 0 2px 5px rgba(16, 185, 129, 0.3);
        }

        .card-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .card-title h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .view-all-btn {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
            padding: 8px 16px;
            background: var(--glass-bg);
            border-radius: 10px;
            transition: all 0.2s;
        }

        .view-all-btn:hover {
            background: var(--primary);
            color: white;
        }

        /* Recent Activity Table */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        th {
            padding: 12px 16px;
            text-align: left;
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
        }

        tbody tr {
            background: #fff;
            transition: all 0.2s;
            cursor: pointer;
        }

        tbody tr:hover {
            transform: scale(1.01);
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        td {
            padding: 20px 16px;
            border-top: 1px solid #f8fafc;
            border-bottom: 1px solid #f8fafc;
            font-size: 0.95rem;
            vertical-align: middle;
        }

        td:first-child { border-left: 1px solid #f8fafc; border-top-left-radius: 12px; border-bottom-left-radius: 12px; }
        td:last-child { border-right: 1px solid #f8fafc; border-top-right-radius: 12px; border-bottom-right-radius: 12px; }

        .name-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .initial-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--primary);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: capitalize;
        }

        .badge-pending { background: #fef3c7; color: #b45309; }
        .badge-approved { background: #dcfce7; color: #15803d; }
        .badge-rejected { background: #fee2e2; color: #b91c1c; }

        .action-link {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Quick Actions Grid */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .action-card {
            padding: 1.25rem;
            border-radius: 18px;
            background: #f8fafc;
            text-align: center;
            text-decoration: none;
            color: var(--dark);
            transition: all 0.2s;
            border: 1px solid #e2e8f0;
        }

        .action-card:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-4px);
        }

        .action-card i {
            font-size: 1.5rem;
            margin-bottom: 10px;
            display: block;
        }

        .action-card span {
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* Responsive Fixes */
        @media (max-width: 1200px) {
            .dashboard-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; width: 100%; }
            header { padding: 0 1rem; }
            .welcome-section h1 { font-size: 1.75rem; }
        }
        .demographic-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .demo-bar-box {
            background: #f8fafc;
            padding: 12px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .demo-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 8px;
            display: block;
        }

        .demo-value {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--dark);
        }

        /* 3D Flip Card */
        .flip-card-3d {
            perspective: 1000px;
            height: 220px;
        }

        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.8s;
            transform-style: preserve-3d;
        }

        .flip-card-3d:hover .flip-card-inner {
            transform: rotateY(180deg);
        }

        .flip-front, .flip-back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 1.75rem;
            box-shadow: var(--card-shadow);
        }

        .flip-front {
            background: white;
            border: 1px solid rgba(255,255,255,0.5);
        }

        .flip-back {
            background: linear-gradient(135deg, var(--primary), var(--accent-purple));
            color: white;
            transform: rotateY(180deg);
        }

        /* SVG Wave Chart Mini */
        .svg-chart-container {
            height: 80px;
            width: 100%;
            margin-top: 15px;
        }

        .svg-line {
            fill: none;
            stroke: var(--primary);
            stroke-width: 3;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 500;
            stroke-dashoffset: 500;
            animation: draw 2s forwards ease-in-out;
        }

        @keyframes draw {
            to { stroke-dashoffset: 0; }
        }

        .svg-area {
            fill: rgba(99, 102, 241, 0.1);
        }
        /* Pie Chart CSS */
        .pie-chart-3d {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: conic-gradient(
                var(--primary) 0% 45%,
                var(--accent-green) 45% 75%,
                var(--accent-orange) 75% 90%,
                #ef4444 90% 100%
            );
            margin: 20px auto;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1), inset 0 0 15px rgba(255,255,255,0.3);
            transform: translateZ(50px);
            transition: transform 0.5s ease;
        }

        .pie-chart-3d:hover {
            transform: translateZ(70px) rotate(10deg);
        }

        /* Donut hole for extra 'premium' look */
        .pie-chart-3d::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50%;
            height: 50%;
            background: white;
            border-radius: 50%;
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.1);
        }

        .chart-legend {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 15px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 3px;
        }

        /* Stacked Bar Graph */
        .stacked-graph {
            display: flex;
            height: 30px;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
            width: 100%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .stack-segment {
            height: 100%;
            transition: width 1s ease-in-out;
            position: relative;
        }

        .stack-segment:hover::after {
            content: attr(data-label);
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--dark);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            white-space: nowrap;
            z-index: 10;
        }
        /* Pillar Bar Chart CSS */
        .pillar-chart {
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            height: 150px;
            margin-top: 2rem;
            padding-bottom: 20px;
            border-bottom: 2px solid #f1f5f9;
        }

        .pillar-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            width: 30px;
        }

        .pillar {
            width: 100%;
            background: linear-gradient(to top, var(--primary), var(--secondary));
            border-radius: 8px 8px 4px 4px;
            transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            transform-style: preserve-3d;
            box-shadow: 5px 5px 15px rgba(0,0,0,0.05);
        }

        .pillar:hover {
            transform: translateZ(30px) scaleX(1.1);
            filter: brightness(1.1);
        }

        .pillar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.3), transparent);
            border-radius: 8px 8px 4px 4px;
        }

        .pillar-val {
            font-size: 0.65rem;
            font-weight: 800;
            color: #64748b;
        }

        .pillar-label {
            font-size: 0.7rem;
            font-weight: 700;
            color: #94a3b8;
            transform: rotate(-45deg);
            margin-top: 10px;
            white-space: nowrap;
        }
        /* Pictograph Styles */
        .pictograph-row {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 20px;
        }

        .pictograph-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 8px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .picto-label {
            width: 80px;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--dark);
        }

        .picto-icons {
            display: flex;
            gap: 6px;
            color: var(--primary);
            font-size: 0.9rem;
        }

        /* Enhanced Pie Chart with Labels */
        .pie-container {
            position: relative;
            width: 180px;
            height: 180px;
            margin: 0 auto;
        }

        .pie-label-text {
            position: absolute;
            font-size: 0.7rem;
            font-weight: 800;
            color: white;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
            pointer-events: none;
        }

        /* Bar Chart with Axes */
        .axis-y {
            position: absolute;
            left: -15px;
            top: 0;
            height: 100%;
            width: 2px;
            background: #cbd5e1;
        }

        .axis-x {
            position: absolute;
            bottom: -2px;
            left: -15px;
            width: calc(100% + 15px);
            height: 2px;
            background: #cbd5e1;
        }

        .axis-tick-y {
            position: absolute;
            left: -20px;
            font-size: 0.6rem;
            color: #94a3b8;
            font-weight: 700;
        }
        /* Complete Bar Chart Styles */
        .full-width-card {
            grid-column: 1 / -1;
            background: white;
            border-radius: 24px;
            padding: 2rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255,255,255,0.5);
            margin-bottom: 2.5rem;
        }

        .grand-bar-container {
            position: relative;
            height: 300px;
            width: 100%;
            margin-top: 2rem;
            margin-left: 30px;
            padding-right: 20px;
            background-image: 
                linear-gradient(rgba(226, 232, 240, 0.5) 1px, transparent 1px),
                linear-gradient(90deg, rgba(226, 232, 240, 0.5) 1px, transparent 1px);
            background-size: 100% 25%, 10% 100%; /* Creates a mathematical grid */
            border-left: 2px solid #94a3b8;
            border-bottom: 2px solid #94a3b8;
        }

        .y-axis-labels {
            position: absolute;
            left: -40px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            padding: 5px 0;
        }

        .x-axis-wrapper {
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            height: 100%;
            width: 100%;
        }

        .grand-pillar-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 8%;
            height: 100%;
            justify-content: flex-end;
        }

        .grand-pillar {
            width: 100%;
            background: linear-gradient(180deg, var(--primary), var(--accent-purple));
            border-radius: 6px 6px 0 0;
            transition: all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.2);
        }

        .grand-pillar:hover {
            transform: scaleX(1.1) translateY(-5px);
            filter: saturate(1.2);
            z-index: 10;
        }

        .grand-pillar::after {
            content: attr(data-value);
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.7rem;
            font-weight: 800;
            color: var(--primary);
        }

        .grand-label {
            position: absolute;
            bottom: -30px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #94a3b8;
            white-space: nowrap;
        }
    </style>
</head>
<body>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar">
        <?= view('admin/partials/sidebar') ?>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <div class="header-title">
                <h2>Admin Command Center</h2>
            </div>
            <div class="user-controls">
                <div class="notification-wrapper">
                    <div class="notification-btn" id="notif-btn">
                        <i class="fa-regular fa-bell"></i>
                        <span class="notification-badge"><?= $total_pending ?></span>
                    </div>
                    <!-- Dropdown -->
                    <div class="notification-dropdown" id="notif-dropdown">
                        <div class="nt-header">
                            <h4>Recent Alerts</h4>
                            <span style="font-size: 0.75rem; color: var(--primary); font-weight: 600; cursor: pointer;">Clear All</span>
                        </div>
                        <div class="nt-list">
                            <?php if(empty($recent_apps)): ?>
                                <p style="font-size: 0.8rem; color: #94a3b8; text-align: center; padding: 1rem;">No new alerts.</p>
                            <?php else: ?>
                                <?php foreach(array_slice($recent_apps, 0, 10) as $app): ?>
                                    <a href="<?= base_url('admin/applications') ?>" class="nt-item">
                                        <div class="nt-icon"><i class="fas fa-file-invoice"></i></div>
                                        <div class="nt-info">
                                            <span class="nt-title">New Application</span>
                                            <span class="nt-desc"><?= $app['citizen_name'] ?> applied for <?= $app['service_type'] ?>.</span>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <div style="height: 10px;"></div>
                            <a href="<?= base_url('admin/applications') ?>" class="view-all-btn" style="display: block; text-align: center; width: 100%;">View Action Center</a>
                        </div>
                    </div>
                </div>
                <div class="profile-card">
                    <div class="avatar"><?= strtoupper(substr(session()->get('user_name') ?? 'Admin', 0, 2)) ?></div>
                    <div class="profile-info">
                        <span class="profile-name"><?= session()->get('user_name') ?></span>
                        <span class="profile-role"><?= ucfirst(session()->get('user_role')) ?></span>
                    </div>
                </div>
            </div>
        </header>

        <div class="content-body">
            <div class="welcome-section">
                <h1>Welcome, <?= session()->get('user_name') ?></h1>
                <p>Monitor and manage village operations for year 2026</p>
            </div>

            <!-- Enhanced Stats Section -->
            <div class="stats-grid">
                <!-- Residents -->
                <div class="stat-card card-blue">
                    <div class="stat-header">
                        <div class="stat-icon-box bg-blue-soft">
                            <i class="fas fa-users-viewfinder"></i>
                        </div>
                        <div class="stat-trend trend-up">
                            <i class="fas fa-arrow-up"></i> 12%
                        </div>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Total Registered Citizens</div>
                        <div class="stat-value"><?= number_format($total_residents) ?></div>
                    </div>
                </div>

                <!-- Certificates -->
                <div class="stat-card card-green">
                    <div class="stat-header">
                        <div class="stat-icon-box bg-green-soft">
                            <i class="fas fa-file-shield"></i>
                        </div>
                        <div class="stat-trend trend-up">
                            <i class="fas fa-arrow-up"></i> 8%
                        </div>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Certificates Dispatched</div>
                        <div class="stat-value"><?= number_format($total_approved) ?></div>
                    </div>
                </div>

                <!-- Pending -->
                <div class="stat-card card-orange">
                    <div class="stat-header">
                        <div class="stat-icon-box bg-orange-soft">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div class="stat-trend trend-down">
                            <i class="fas fa-exclamation-triangle"></i> Action Required
                        </div>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Applications Under Review</div>
                        <div class="stat-value"><?= number_format($total_pending) ?></div>
                    </div>
                </div>

                <!-- Revenue -->
                <div class="stat-card card-purple">
                    <div class="stat-header">
                        <div class="stat-icon-box bg-purple-soft">
                            <i class="fas fa-indian-rupee-sign"></i>
                        </div>
                        <div class="stat-trend trend-up">
                            <i class="fas fa-arrow-up"></i> 15%
                        </div>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Fiscal Revenue Hub</div>
                        <div class="stat-value">₹<?= number_format($total_revenue) ?></div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Section (Simplified) -->
            <div class="visual-card" style="margin-bottom: 2.5rem;">
                <div class="card-title">
                    <h3>Quick Administration Actions</h3>
                </div>
                <div class="quick-actions" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                    <a href="<?= base_url('register') ?>" class="action-card">
                        <i class="fas fa-user-plus" style="color: var(--accent-blue)"></i>
                        <span>Enroll New Citizen</span>
                    </a>
                    <a href="<?= base_url('admin/cert-approvals') ?>" class="action-card">
                        <i class="fas fa-file-signature" style="color: var(--accent-green)"></i>
                        <span>Issue Certificates</span>
                    </a>
                    <a href="<?= base_url('admin/taxes') ?>" class="action-card">
                        <i class="fas fa-hand-holding-dollar" style="color: var(--accent-orange)"></i>
                        <span>Revenue Collection</span>
                    </a>
                    <a href="<?= base_url('admin/complaints') ?>" class="action-card">
                        <i class="fas fa-headset" style="color: #ef4444"></i>
                        <span>Citizen Support</span>
                    </a>
                    <a href="<?= base_url('admin/projects') ?>" class="action-card">
                        <i class="fas fa-road" style="color: var(--accent-purple)"></i>
                        <span>Monitor Works</span>
                    </a>
                    <a href="<?= base_url('admin/assets') ?>" class="action-card">
                        <i class="fas fa-city" style="color: var(--primary)"></i>
                        <span>Asset Mgmt</span>
                    </a>
                </div>
            </div>

            <!-- Visual Analysis Section (3D & CSS Charts) -->
            <div class="visual-container">
                <!-- 3D Card 1: Revenue Mix -->
                <div class="premium-3d-card">
                    <div class="card-3d-inner">
                        <div class="card-title">
                            <h3>Revenue Streams</h3>
                            <span style="font-size: 0.75rem; color: #10b981; font-weight: 700;">+14% Growth</span>
                        </div>
                        <div class="mini-bar-chart">
                            <div class="bar-container">
                                <div class="bar" style="height: 60%;"></div>
                                <span class="bar-label">Tax</span>
                            </div>
                            <div class="bar-container">
                                <div class="bar" style="height: 40%; opacity: 0.8;"></div>
                                <span class="bar-label">Fees</span>
                            </div>
                            <div class="bar-container">
                                <div class="bar" style="height: 85%; opacity: 0.9;"></div>
                                <span class="bar-label">Grants</span>
                            </div>
                            <div class="bar-container">
                                <div class="bar" style="height: 25%; opacity: 0.7;"></div>
                                <span class="bar-label">Misc</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3D Card 2: Application Pulse -->
                <div class="premium-3d-card" style="background: linear-gradient(135deg, #ffffff, #f8fafc);">
                    <div class="card-3d-inner">
                        <div class="card-title">
                            <h3>Project Efficiency</h3>
                        </div>
                        <div class="progress-3d-wrapper">
                            <div class="progress-3d-label">
                                <span>Infrastructure (GPDP)</span>
                                <span>78%</span>
                            </div>
                            <div class="progress-3d-track">
                                <div class="progress-3d-fill" style="width: 78%;"></div>
                            </div>
                        </div>
                        <div class="progress-3d-wrapper" style="margin-top: 1.5rem;">
                            <div class="progress-3d-label">
                                <span>Service Delivery</span>
                                <span>92%</span>
                            </div>
                            <div class="progress-3d-track">
                                <div class="progress-3d-fill" style="width: 92%; background: linear-gradient(90deg, #6366f1, #a855f7);"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3D Card 3: Rapid Stats -->
                <div class="premium-3d-card">
                    <div class="card-3d-inner">
                        <div class="card-title">
                            <h3>System Health</h3>
                        </div>
                        <div style="display: flex; align-items: center; gap: 20px; margin-top: 1rem;">
                            <div style="width: 70px; height: 70px; border-radius: 50%; border: 8px solid #f1f5f9; border-top-color: #6366f1; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #6366f1; font-size: 1.1rem; transform: rotate(15deg);">
                                99%
                            </div>
                            <div>
                                <h4 style="font-size: 1rem; color: var(--dark); margin-bottom: 2px;">Extreme Speed</h4>
                                <p style="font-size: 0.75rem; color: #64748b;">Optimized Resource Engine</p>
                            </div>
                        </div>
                        <div style="margin-top: 1.5rem; display: flex; justify-content: space-between;">
                            <span style="font-size: 0.7rem; color: #94a3b8;"><i class="fas fa-microchip"></i> 0.2s Response</span>
                            <span style="font-size: 0.7rem; color: #94a3b8;"><i class="fas fa-shield-halved"></i> 128-bit Encrypted</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Visual Container: More 3D & Graphs -->
            <div class="visual-container" style="margin-top: 0;">
                <!-- Card 4: 3D Flip Card Insights -->
                <div class="flip-card-3d">
                    <div class="flip-card-inner">
                        <div class="flip-front">
                            <i class="fas fa-lightbulb" style="font-size: 2rem; color: var(--primary); margin-bottom: 15px;"></i>
                            <h3 style="font-size: 1.1rem; color: var(--dark);">Village Insight</h3>
                            <p style="font-size: 0.85rem; color: #64748b; margin-top: 10px;">Hover to reveal deep analytics of resident engagement and feedback pulses.</p>
                        </div>
                        <div class="flip-back">
                            <h3 style="font-size: 1.1rem; margin-bottom: 10px;">Deep Analytics</h3>
                            <div style="font-size: 0.85rem; opacity: 0.9;">
                                <div style="margin-bottom: 8px;"><i class="fas fa-check-circle"></i> 94% Support Rate</div>
                                <div style="margin-bottom: 8px;"><i class="fas fa-check-circle"></i> 12 New Ideas/Week</div>
                                <div><i class="fas fa-check-circle"></i> 5 Active Campaigns</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 5: SVG Linear Growth -->
                <div class="premium-3d-card">
                    <div class="card-3d-inner">
                        <div class="card-title">
                            <h3>Growth Vector</h3>
                            <span style="font-size: 0.7rem; background: var(--primary-light); color: var(--primary); padding: 4px 8px; border-radius: 6px;">Live SVG</span>
                        </div>
                        <div class="svg-chart-container">
                            <svg viewBox="0 0 400 100" preserveAspectRatio="none" style="width: 100%; height: 100%;">
                                <path class="svg-area" d="M0,100 L0,80 Q50,70 100,85 T200,60 T300,40 T400,20 L400,100 Z"></path>
                                <path class="svg-line" d="M0,80 Q50,70 100,85 T200,60 T300,40 T400,20"></path>
                            </svg>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-top: 10px; font-size: 0.7rem; color: #94a3b8; font-weight: 600;">
                            <span>Jan 2026</span>
                            <span>Dec 2026</span>
                        </div>
                    </div>
                </div>

                <!-- Card 6: Demographic Pulse -->
                <div class="premium-3d-card" style="background: linear-gradient(135deg, #ffffff, #f1f5f9);">
                    <div class="card-3d-inner">
                        <div class="card-title">
                            <h3>Citizen Pulse</h3>
                        </div>
                        <div class="demographic-grid">
                            <div class="demo-bar-box">
                                <span class="demo-label">Male</span>
                                <div class="demo-value">52%</div>
                                <div style="height: 4px; background: #e2e8f0; border-radius: 2px; margin-top: 5px;">
                                    <div style="width: 52%; height: 100%; background: #3b82f6; border-radius: 2px;"></div>
                                </div>
                            </div>
                            <div class="demo-bar-box">
                                <span class="demo-label">Female</span>
                                <div class="demo-value">48%</div>
                                <div style="height: 4px; background: #e2e8f0; border-radius: 2px; margin-top: 5px;">
                                    <div style="width: 48%; height: 100%; background: #ec4899; border-radius: 2px;"></div>
                                </div>
                            </div>
                            <div class="demo-bar-box">
                                <span class="demo-label">Youth</span>
                                <div class="demo-value">35%</div>
                                <div style="height: 4px; background: #e2e8f0; border-radius: 2px; margin-top: 5px;">
                                    <div style="width: 35%; height: 100%; background: #8b5cf6; border-radius: 2px;"></div>
                                </div>
                            </div>
                            <div class="demo-bar-box">
                                <span class="demo-label">Seniors</span>
                                <div class="demo-value">12%</div>
                                <div style="height: 4px; background: #e2e8f0; border-radius: 2px; margin-top: 5px;">
                                    <div style="width: 12%; height: 100%; background: #f59e0b; border-radius: 2px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Third Visual Container: Pie Charts & Stacked Graphs -->
            <div class="visual-container" style="margin-top: 0;">
                <!-- Card 7: CSS Pie Chart -->
                <div class="premium-3d-card">
                    <div class="card-3d-inner">
                        <div class="card-title">
                            <h3>Resource Allocation</h3>
                        </div>
                        <div class="pie-chart-3d"></div>
                        <div class="chart-legend">
                            <div class="legend-item"><div class="legend-dot" style="background: var(--primary);"></div> Infrastructure</div>
                            <div class="legend-item"><div class="legend-dot" style="background: var(--accent-green);"></div> Welfare</div>
                            <div class="legend-item"><div class="legend-dot" style="background: var(--accent-orange);"></div> Admin</div>
                            <div class="legend-item"><div class="legend-dot" style="background: #ef4444;"></div> Emergency</div>
                        </div>
                    </div>
                </div>

                <!-- Card 8: Stacked Bar Graph -->
                <div class="premium-3d-card">
                    <div class="card-3d-inner">
                        <div class="card-title">
                            <h3>Revenue Mix 2026</h3>
                        </div>
                        <div style="margin-top: 2rem;">
                            <div style="display: flex; justify-content: space-between; font-size: 0.8rem; margin-bottom: 8px;">
                                <span style="font-weight: 700;">Fiscal Performance</span>
                                <span style="color: var(--accent-green); font-weight: 700;">+₹1,240 Today</span>
                            </div>
                            <div class="stacked-graph">
                                <div class="stack-segment" style="width: 45%; background: var(--primary);" data-label="Property Tax: 45%"></div>
                                <div class="stack-segment" style="width: 30%; background: var(--accent-purple);" data-label="Trade Fees: 30%"></div>
                                <div class="stack-segment" style="width: 15%; background: var(--accent-orange);" data-label="Sanitation: 15%"></div>
                                <div class="stack-segment" style="width: 10%; background: #94a3b8;" data-label="Misc: 10%"></div>
                            </div>
                            <p style="font-size: 0.75rem; color: #64748b; margin-top: 15px;">Combined growth of all village revenue streams excluding central government grants.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 9: Workflow Pulse -->
                <div class="premium-3d-card" style="background: linear-gradient(135deg, var(--dark-sidebar), var(--dark)); color: white;">
                    <div class="card-3d-inner">
                        <div class="card-title">
                            <h3 style="color: white;">Fulfillment Rate</h3>
                        </div>
                        <div style="margin-top: 1.5rem; text-align: center;">
                            <div style="font-size: 3rem; font-weight: 800; background: linear-gradient(to bottom, #ffffff, rgba(255,255,255,0.4)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                98.4%
                            </div>
                            <p style="font-size: 0.85rem; color: #94a3b8; margin-top: 10px;">Average Service Completion Velocity</p>
                        </div>
                        <div style="margin-top: 25px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px; display: flex; justify-content: space-around;">
                            <div style="text-align: center;">
                                <div style="font-size: 0.9rem; font-weight: 700;">2.4d</div>
                                <div style="font-size: 0.65rem; color: #64748b;">Response</div>
                            </div>
                            <div style="text-align: center;">
                                <div style="font-size: 0.9rem; font-weight: 700;">6.1d</div>
                                <div style="font-size: 0.65rem; color: #64748b;">Closing</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fourth Visual Container: Vertical 3D Pillars -->
            <div class="visual-container" style="margin-top: 0;">
                <!-- Card 10: Seasonal Collection Bars -->
                <div class="premium-3d-card">
                    <div class="card-3d-inner">
                        <div class="card-title">
                            <h3>Collection Trends</h3>
                        </div>
                        <div class="pillar-chart">
                            <div class="pillar-wrapper">
                                <span class="pillar-val">12k</span>
                                <div class="pillar" style="height: 40%;"></div>
                                <span class="pillar-label">Mar</span>
                            </div>
                            <div class="pillar-wrapper">
                                <span class="pillar-val">18k</span>
                                <div class="pillar" style="height: 60%;"></div>
                                <span class="pillar-label">Apr</span>
                            </div>
                            <div class="pillar-wrapper">
                                <span class="pillar-val">25k</span>
                                <div class="pillar" style="height: 85%;"></div>
                                <span class="pillar-label">May</span>
                            </div>
                            <div class="pillar-wrapper">
                                <span class="pillar-val">15k</span>
                                <div class="pillar" style="height: 50%;"></div>
                                <span class="pillar-label">Jun</span>
                            </div>
                            <div class="pillar-wrapper">
                                <span class="pillar-val">28k</span>
                                <div class="pillar" style="height: 95%;"></div>
                                <span class="pillar-label">Jul</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 11: Task Momentum (3D Bars) -->
                <div class="premium-3d-card" style="background: linear-gradient(135deg, #ffffff, #f0fdf4);">
                    <div class="card-3d-inner">
                        <div class="card-title">
                            <h3>Project Momentum</h3>
                        </div>
                        <div style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 12px;">
                            <div>
                                <div style="display: flex; justify-content: space-between; font-size: 0.75rem; margin-bottom: 5px;">
                                    <span>Sanitation Drive</span>
                                    <span style="font-weight: 700;">94%</span>
                                </div>
                                <div style="height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                                    <div style="width: 94%; height: 100%; background: #10b981; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; font-size: 0.75rem; margin-bottom: 5px;">
                                    <span>Road Repair</span>
                                    <span style="font-weight: 700;">62%</span>
                                </div>
                                <div style="height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                                    <div style="width: 62%; height: 100%; background: #3b82f6; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; font-size: 0.75rem; margin-bottom: 5px;">
                                    <span>Digital Drive</span>
                                    <span style="font-weight: 700;">100%</span>
                                </div>
                                <div style="height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                                    <div style="width: 100%; height: 100%; background: #f59e0b; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 12: Actionable Summary -->
                <div class="premium-3d-card">
                    <div class="card-3d-inner">
                        <div class="card-title">
                            <h3>Resource Efficiency</h3>
                        </div>
                        <div style="margin-top: 1.5rem; display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div style="padding: 15px; background: #f1f5f9; border-radius: 16px; text-align: center;">
                                <div style="font-size: 1.2rem; font-weight: 800; color: var(--primary);">1.4x</div>
                                <div style="font-size: 0.65rem; color: #64748b; margin-top: 4px;">ROI Factor</div>
                            </div>
                            <div style="padding: 15px; background: #f1f5f9; border-radius: 16px; text-align: center;">
                                <div style="font-size: 1.2rem; font-weight: 800; color: var(--accent-green);">12ms</div>
                                <div style="font-size: 0.65rem; color: #64748b; margin-top: 4px;">Latency</div>
                            </div>
                        </div>
                        <p style="font-size: 0.7rem; color: #94a3b8; margin-top: 1.5rem; line-height: 1.5;">
                            Advanced computational models indicate a <strong style="color: var(--dark);">+15.2%</strong> efficiency boost in village resource orchestration compared to fiscal 2025.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Complete Bar Chart: Full Width Grand Analytics -->
            <div class="full-width-card">
                <div class="card-title">
                    <h3>Panchayat Development Analytics (2026)</h3>
                    <div style="display: flex; gap: 10px;">
                        <span style="font-size: 0.75rem; color: #64748b;"><i class="fas fa-circle" style="color: var(--primary)"></i> Approved Projects</span>
                        <span style="font-size: 0.75rem; color: #64748b;"><i class="fas fa-circle" style="color: var(--accent-purple)"></i> Completed Works</span>
                    </div>
                </div>
                
                <div class="grand-bar-container">
                    <!-- Y Axis Labels -->
                    <div class="y-axis-labels">
                        <span>100%</span>
                        <span>75%</span>
                        <span>50%</span>
                        <span>25%</span>
                        <span>0%</span>
                    </div>

                    <div class="x-axis-wrapper">
                        <!-- Bar Groups (Months) -->
                        <div class="grand-pillar-group">
                            <div class="grand-pillar" style="height: 45%;" data-value="45%"></div>
                            <span class="grand-label">Jan</span>
                        </div>
                        <div class="grand-pillar-group">
                            <div class="grand-pillar" style="height: 62%;" data-value="62%"></div>
                            <span class="grand-label">Feb</span>
                        </div>
                        <div class="grand-pillar-group">
                            <div class="grand-pillar" style="height: 38%;" data-value="38%"></div>
                            <span class="grand-label">Mar</span>
                        </div>
                        <div class="grand-pillar-group">
                            <div class="grand-pillar" style="height: 75%;" data-value="75%"></div>
                            <span class="grand-label">Apr</span>
                        </div>
                        <div class="grand-pillar-group">
                            <div class="grand-pillar" style="height: 90%;" data-value="90%"></div>
                            <span class="grand-label">May</span>
                        </div>
                        <div class="grand-pillar-group">
                            <div class="grand-pillar" style="height: 55%;" data-value="55%"></div>
                            <span class="grand-label">Jun</span>
                        </div>
                        <div class="grand-pillar-group">
                            <div class="grand-pillar" style="height: 82%;" data-value="82%"></div>
                            <span class="grand-label">Jul</span>
                        </div>
                        <div class="grand-pillar-group">
                            <div class="grand-pillar" style="height: 68%;" data-value="68%"></div>
                            <span class="grand-label">Aug</span>
                        </div>
                        <div class="grand-pillar-group">
                            <div class="grand-pillar" style="height: 40%;" data-value="40%"></div>
                            <span class="grand-label">Sep</span>
                        </div>
                        <div class="grand-pillar-group">
                            <div class="grand-pillar" style="height: 95%;" data-value="95%"></div>
                            <span class="grand-label">Oct</span>
                        </div>
                    </div>
                </div>
                <!-- Margin for the X-axis labels -->
                <div style="height: 40px;"></div>
            </div>

            <!-- Fifth Visual Container: Mathematical Insights (Based on User Reference) -->
            <div class="visual-container" style="margin-top: 0;">
                <!-- Pie Graph with Inline Labels -->
                <div class="premium-3d-card">
                    <div class="card-3d-inner">
                        <div class="card-title">
                            <h3>Service Utilization</h3>
                            <span style="font-size: 0.75rem; background: #fef3c7; color: #b45309; padding: 4px 8px; border-radius: 6px;">Pie Type</span>
                        </div>
                        <div class="pie-container">
                            <div class="pie-chart-3d" style="width: 100%; height: 100%; margin: 0;"></div>
                            <!-- Labels positioned to match segments -->
                            <span class="pie-label-text" style="top: 30%; right: 25%;">50%</span>
                            <span class="pie-label-text" style="bottom: 25%; left: 35%;">13%</span>
                            <span class="pie-label-text" style="bottom: 45%; left: 20%;">20%</span>
                            <span class="pie-label-text" style="top: 25%; left: 30%;">10%</span>
                        </div>
                        <p style="font-size: 0.75rem; color: #64748b; margin-top: 15px; text-align: center;">Distribution of citizen service requests by primary category.</p>
                    </div>
                </div>

                <!-- Bar Graph with Axes -->
                <div class="premium-3d-card">
                    <div class="card-3d-inner">
                        <div class="card-title">
                            <h3>Growth Metrics</h3>
                            <span style="font-size: 0.75rem; background: #dcfce7; color: #15803d; padding: 4px 8px; border-radius: 6px;">Axis-X/Y</span>
                        </div>
                        <div style="position: relative; margin-left: 20px;">
                            <div class="axis-y"></div>
                            <div class="axis-x"></div>
                            <!-- Ticks -->
                            <span class="axis-tick-y" style="top: 0;">12</span>
                            <span class="axis-tick-y" style="top: 25%;">9</span>
                            <span class="axis-tick-y" style="top: 50%;">6</span>
                            <span class="axis-tick-y" style="top: 75%;">3</span>
                            <span class="axis-tick-y" style="bottom: -10px;">0</span>
                            
                            <div class="pillar-chart" style="height: 120px; border-bottom: none; margin-top: 0;">
                                <div class="pillar-wrapper" style="width: 25px;">
                                    <div class="pillar" style="height: 80%; background: var(--primary);"></div>
                                    <span style="font-size: 0.6rem; margin-top: 5px;">A</span>
                                </div>
                                <div class="pillar-wrapper" style="width: 25px;">
                                    <div class="pillar" style="height: 55%; background: var(--accent-purple);"></div>
                                    <span style="font-size: 0.6rem; margin-top: 5px;">B</span>
                                </div>
                                <div class="pillar-wrapper" style="width: 25px;">
                                    <div class="pillar" style="height: 40%; background: var(--accent-orange);"></div>
                                    <span style="font-size: 0.6rem; margin-top: 5px;">C</span>
                                </div>
                                <div class="pillar-wrapper" style="width: 25px;">
                                    <div class="pillar" style="height: 88%; background: var(--primary);"></div>
                                    <span style="font-size: 0.6rem; margin-top: 5px;">D</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pictograph -->
                <div class="premium-3d-card">
                    <div class="card-3d-inner">
                        <div class="card-title">
                            <h3>Weekly Engagement</h3>
                            <span style="font-size: 0.75rem; background: #e0e7ff; color: #4338ca; padding: 4px 8px; border-radius: 6px;">Pictogram</span>
                        </div>
                        <div class="pictograph-row">
                            <div class="pictograph-item">
                                <span class="picto-label">Monday</span>
                                <div class="picto-icons">
                                    <i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i>
                                </div>
                            </div>
                            <div class="pictograph-item">
                                <span class="picto-label">Tuesday</span>
                                <div class="picto-icons">
                                    <i class="fas fa-circle"></i><i class="fas fa-circle"></i>
                                </div>
                            </div>
                            <div class="pictograph-item">
                                <span class="picto-label">Wednesday</span>
                                <div class="picto-icons">
                                    <i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i>
                                </div>
                            </div>
                            <div class="pictograph-item">
                                <span class="picto-label">Thursday</span>
                                <div class="picto-icons">
                                    <i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 15px; font-size: 0.7rem; color: #64748b; font-style: italic;">
                            <i class="fas fa-info-circle"></i> Each icon represents 5 active requests.
                        </div>
                    </div>
                </div>
            </div>
            <div class="visual-card">
                <div class="card-title">
                    <h3>Recent Service Requests</h3>
                    <a href="<?= base_url('admin/applications') ?>" class="view-all-btn">View Universe</a>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Citizen Details</th>
                                <th>Service Segment</th>
                                <th>Applied Date</th>
                                <th>Workflow Status</th>
                                <th>Executive Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($recent_apps)): ?>
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 3rem; color: #94a3b8;">
                                        <i class="fas fa-folder-open" style="font-size: 3rem; display: block; margin-bottom: 15px; opacity: 0.3;"></i>
                                        Queue is currently empty.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($recent_apps as $app): ?>
                                <tr>
                                    <td>
                                        <div class="name-cell">
                                            <div class="initial-circle"><?= strtoupper(substr($app['citizen_name'], 0, 1)) ?></div>
                                            <div>
                                                <div style="font-weight: 600;"><?= $app['citizen_name'] ?></div>
                                                <div style="font-size: 0.75rem; color: #64748b;">Resident ID: #<?= rand(1000, 9999) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 500;"><?= $app['service_type'] ?></div>
                                    </td>
                                    <td>
                                        <div style="color: #64748b;"><i class="fa-regular fa-calendar-alt" style="margin-right: 5px;"></i> <?= date('d M Y', strtotime($app['applied_at'])) ?></div>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?= strtolower($app['status']) ?>">
                                            <i class="fas fa-circle" style="font-size: 6px; vertical-align: middle; margin-right: 5px;"></i>
                                            <?= $app['status'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/applications') ?>" class="action-link">
                                            <span>Manage</span>
                                            <i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Entry Stagger Animation (Lightweight CSS-only feel)
            const cards = document.querySelectorAll('.stat-card, .visual-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(15px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 80 * index);
            });
        });

        // SweetAlert for Success
        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Operation Successful',
                text: '<?= session()->getFlashdata('success') ?>',
                background: '#fff',
                confirmButtonColor: '#6366f1',
                customClass: {
                    popup: 'premium-swal'
                }
            });
        <?php endif; ?>

        // SweetAlert for Errors
        <?php if(session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Action Required',
                text: '<?= session()->getFlashdata('error') ?>',
                background: '#fff',
                confirmButtonColor: '#ef4444'
            });
        <?php endif; ?>

        // Notification Toggle Logic
        const notifBtn = document.getElementById('notif-btn');
        const notifDropdown = document.getElementById('notif-dropdown');

        if (notifBtn) {
            notifBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                notifDropdown.classList.toggle('show');
            });
        }

        document.addEventListener('click', (e) => {
            if (notifDropdown && !notifDropdown.contains(e.target)) {
                notifDropdown.classList.remove('show');
            }
        });
    </script>
</body>
</html>

