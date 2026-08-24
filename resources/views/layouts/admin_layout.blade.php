<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard — AquaWash ERP</title>
    <meta name="description" content="Panel de administración del sistema de lavadero AquaWash ERP">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --bg-body: #0f172a;
            --bg-sidebar: #1e293b;
            --bg-card: #1e293b;
            --bg-card-hover: #253348;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border-color: #334155;

            --accent-blue: #3b82f6;
            --accent-indigo: #6366f1;
            --accent-green: #10b981;
            --accent-emerald: #34d399;
            --accent-yellow: #f59e0b;
            --accent-amber: #fbbf24;
            --accent-red: #ef4444;
            --accent-rose: #f43f5e;

            --sidebar-width: 260px;
            --topbar-height: 64px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* ======================== LAYOUT ======================== */
        .wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* ======================== SIDEBAR ======================== */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            overflow-y: auto;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-header .logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-indigo));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .sidebar-header .brand-text h6 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0;
            color: var(--text-main);
            letter-spacing: -0.3px;
        }

        .sidebar-header .brand-text small {
            font-size: 0.7rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-section-title {
            padding: 20px 20px 8px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
        }

        .sidebar-menu {
            list-style: none;
            padding: 8px 0;
            margin: 0;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 11px 20px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.25s ease;
            border-left: 3px solid transparent;
            margin: 2px 0;
        }

        .sidebar-menu li a i {
            font-size: 1.15rem;
            width: 22px;
            text-align: center;
        }

        .sidebar-menu li a:hover {
            color: var(--text-main);
            background: rgba(255,255,255,0.04);
            border-left-color: rgba(99, 102, 241, 0.4);
        }

        .sidebar-menu li.active a {
            color: var(--text-main);
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.15), transparent);
            border-left-color: var(--accent-indigo);
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px 20px;
            border-top: 1px solid var(--border-color);
        }

        .sidebar-footer .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-footer .user-avatar {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent-green), var(--accent-emerald));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            color: white;
        }

        .sidebar-footer .user-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .sidebar-footer .user-role {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        /* ======================== MAIN ======================== */
        .main-content {
            flex-grow: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ======================== TOPBAR ======================== */
        .topbar {
            height: var(--topbar-height);
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar .toggle-btn {
            display: none;
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 1.4rem;
            cursor: pointer;
            padding: 4px;
        }

        .topbar .search-box {
            background: var(--bg-sidebar);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            border-radius: 10px;
            padding: 8px 16px 8px 40px;
            width: 320px;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .topbar .search-box:focus {
            outline: none;
            border-color: var(--accent-indigo);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        .topbar .search-wrapper {
            position: relative;
        }

        .topbar .search-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-actions .btn-logout {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: var(--accent-red);
            padding: 6px 16px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.25s;
            text-decoration: none;
        }

        .topbar-actions .btn-logout:hover {
            background: rgba(239, 68, 68, 0.2);
            transform: translateY(-1px);
        }

        .topbar-actions .user-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--bg-sidebar);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 6px 14px;
        }

        .topbar-actions .user-pill .avatar-sm {
            width: 28px; height: 28px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-indigo));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
            color: white;
        }

        .topbar-actions .user-pill span {
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* ======================== CARDS ======================== */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: rgba(99, 102, 241, 0.3);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .stat-card .card-gradient {
            position: absolute;
            top: 0;
            right: 0;
            width: 120px;
            height: 120px;
            border-radius: 0 0 0 100%;
            opacity: 0.08;
        }

        .stat-card .icon-box {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 16px;
        }

        .stat-card.card-blue .icon-box { background: rgba(59, 130, 246, 0.15); color: var(--accent-blue); }
        .stat-card.card-blue .card-gradient { background: var(--accent-blue); }
        .stat-card.card-green .icon-box { background: rgba(16, 185, 129, 0.15); color: var(--accent-green); }
        .stat-card.card-green .card-gradient { background: var(--accent-green); }
        .stat-card.card-yellow .icon-box { background: rgba(245, 158, 11, 0.15); color: var(--accent-yellow); }
        .stat-card.card-yellow .card-gradient { background: var(--accent-yellow); }
        .stat-card.card-red .icon-box { background: rgba(244, 63, 94, 0.15); color: var(--accent-rose); }
        .stat-card.card-red .card-gradient { background: var(--accent-rose); }

        .stat-card .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .stat-card .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 4px;
            letter-spacing: -0.5px;
        }

        .stat-card .stat-sub {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .stat-card .stat-sub .badge-up {
            color: var(--accent-green);
            font-weight: 600;
        }

        /* ======================== PANELS ======================== */
        .panel {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            height: 100%;
        }

        .panel-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-main);
        }

        .panel-title i {
            color: var(--accent-indigo);
        }

        /* Timeline */
        .ranking-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .ranking-item:last-child { border-bottom: none; }

        .ranking-item .rank-number {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .ranking-item:nth-child(1) .rank-number { background: linear-gradient(135deg, #f59e0b, #fbbf24); color: #1e293b; }
        .ranking-item:nth-child(2) .rank-number { background: linear-gradient(135deg, #94a3b8, #cbd5e1); color: #1e293b; }
        .ranking-item:nth-child(3) .rank-number { background: linear-gradient(135deg, #b45309, #d97706); color: white; }
        .ranking-item:nth-child(n+4) .rank-number { background: var(--bg-body); color: var(--text-muted); }

        .ranking-item .rank-info h6 {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .ranking-item .rank-info small {
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        .ranking-item .rank-count {
            margin-left: auto;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--accent-indigo);
        }

        /* ======================== TABLE ======================== */
        .table {
            color: var(--text-main);
            font-size: 0.88rem;
        }

        .table th {
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 16px;
        }

        .table td {
            border-bottom: 1px solid rgba(51, 65, 85, 0.5);
            vertical-align: middle;
            padding: 14px 16px;
        }

        .table tbody tr {
            transition: background 0.2s;
        }

        .table tbody tr:hover {
            background: rgba(255,255,255,0.02);
        }

        .badge-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-completed { background: rgba(16,185,129,0.15); color: var(--accent-green); }
        .badge-progress { background: rgba(59,130,246,0.15); color: var(--accent-blue); }
        .badge-pending { background: rgba(245,158,11,0.15); color: var(--accent-yellow); }

        /* ======================== RESPONSIVE ======================== */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .topbar .toggle-btn {
                display: block;
            }

            .topbar .search-box {
                width: 200px;
            }
        }

        @media (max-width: 576px) {
            .topbar .search-wrapper { display: none; }
            .topbar-actions .user-pill span { display: none; }
        }

        /* Overlay for mobile sidebar */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 99;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }

        /* Toast */
        .toast-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
        }
    </style>
</head>
<body>
    <!-- Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo-icon"><i class="bi bi-droplet-fill"></i></div>
                <div class="brand-text">
                    <h6>AquaWash</h6>
                    <small>Panel Admin</small>
                </div>
            </div>

            <div class="sidebar-section-title">Principal</div>
            <ul class="sidebar-menu">
                <li class="active"><a href="/admin"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a></li>
                <li><a href="/reception"><i class="bi bi-car-front-fill"></i> Recepción</a></li>
            </ul>

            <div class="sidebar-section-title">Gestión</div>
            <ul class="sidebar-menu">
                <li><a href="#"><i class="bi bi-people-fill"></i> Usuarios</a></li>
                <li><a href="#"><i class="bi bi-bar-chart-fill"></i> Reportes</a></li>
                <li><a href="#"><i class="bi bi-gear-fill"></i> Configuración</a></li>
            </ul>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div>
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">Administrador</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Topbar -->
            <header class="topbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="toggle-btn" onclick="toggleSidebar()">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="search-wrapper">
                        <i class="bi bi-search"></i>
                        <input type="text" class="search-box" placeholder="Buscar lavados, placas...">
                    </div>
                </div>
                <div class="topbar-actions">
                    <div class="user-pill">
                        <div class="avatar-sm">{{ substr(Auth::user()->name, 0, 1) }}</div>
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="bi bi-box-arrow-right me-1"></i> Salir
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4">
                <!-- Toast para mensajes -->
                @if(session('success'))
                <div class="toast-container">
                    <div class="toast show align-items-center border-0" role="alert" style="background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3) !important; color: var(--accent-green);">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- jQuery & Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }

        // Auto-hide toast
        setTimeout(function() {
            document.querySelectorAll('.toast').forEach(t => {
                new bootstrap.Toast(t, { delay: 3000 }).show();
            });
        }, 100);
    </script>

    @stack('scripts')
</body>
</html>
