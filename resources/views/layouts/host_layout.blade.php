<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Recepción — AquaWash ERP</title>
    <meta name="description" content="Panel de recepción del sistema de lavadero AquaWash ERP">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-sidebar: #111827;
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;

            --primary: #3b82f6;
            --primary-light: #dbeafe;
            --secondary: #6366f1;
            --success: #10b981;
            --success-light: #d1fae5;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --purple: #8b5cf6;
            --purple-light: #ede9fe;
            --rose: #f43f5e;

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
            background: linear-gradient(180deg, #111827 0%, #1f2937 100%);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            overflow-y: auto;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand .brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .sidebar-brand h6 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .sidebar-brand small {
            font-size: 0.7rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-section {
            padding: 20px 20px 8px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #64748b;
        }

        .sidebar-menu {
            list-style: none;
            padding: 4px 0;
            margin: 0;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 11px 20px;
            color: #94a3b8;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.25s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu li a i {
            font-size: 1.15rem;
            width: 22px;
            text-align: center;
        }

        .sidebar-menu li a:hover {
            color: white;
            background: rgba(255,255,255,0.04);
            border-left-color: rgba(59, 130, 246, 0.4);
        }

        .sidebar-menu li.active a {
            color: white;
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.15), transparent);
            border-left-color: var(--primary);
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-footer .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-footer .user-avatar {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            color: white;
        }

        .sidebar-footer .user-name { font-size: 0.85rem; font-weight: 600; }
        .sidebar-footer .user-role { font-size: 0.7rem; color: #94a3b8; }

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
            background: rgba(255, 255, 255, 0.85);
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
        }

        .topbar .search-container {
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 0 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            width: 320px;
            transition: all 0.3s;
        }

        .topbar .search-container:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .topbar .search-container input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            padding: 8px 0;
            font-size: 0.85rem;
            color: var(--text-main);
        }

        .topbar .search-container i { color: var(--text-muted); font-size: 0.9rem; }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-actions .notification-btn {
            position: relative;
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 1.2rem;
            padding: 6px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .topbar-actions .notification-btn:hover { color: var(--text-main); }

        .topbar-actions .user-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 5px 14px 5px 5px;
        }

        .topbar-actions .user-pill img {
            width: 32px; height: 32px;
            border-radius: 8px;
        }

        .topbar-actions .user-pill span {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .topbar-actions .btn-logout {
            background: rgba(244, 63, 94, 0.08);
            border: 1px solid rgba(244, 63, 94, 0.2);
            color: var(--rose);
            padding: 6px 16px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.25s;
            text-decoration: none;
        }

        .topbar-actions .btn-logout:hover {
            background: rgba(244, 63, 94, 0.15);
        }

        /* ======================== CARDS ======================== */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.06);
        }

        .stat-card .icon-box {
            width: 56px; height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .icon-blue { background: var(--primary-light); color: var(--primary); }
        .icon-lightblue { background: #e0e7ff; color: var(--secondary); }
        .icon-green { background: var(--success-light); color: var(--success); }
        .icon-purple { background: var(--purple-light); color: var(--purple); }

        .stat-info h6 {
            color: var(--text-muted);
            margin-bottom: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-info h3 {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 0;
            color: var(--text-main);
            letter-spacing: -0.5px;
        }

        /* ======================== PANELS ======================== */
        .panel {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .panel-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .panel-header h5 {
            font-size: 1rem;
            font-weight: 700;
            margin: 0;
        }

        .panel-body {
            padding: 24px;
        }

        /* ======================== MODAL ======================== */
        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.12);
        }

        .modal-header {
            border-bottom: 1px solid var(--border-color);
            padding: 20px 24px;
            background: linear-gradient(135deg, #f8fafc, #eef2ff);
            border-radius: 20px 20px 0 0;
        }

        .modal-body { padding: 24px; }

        .modal-footer {
            border-top: 1px solid var(--border-color);
            padding: 16px 24px;
            background: #f8fafc;
            border-radius: 0 0 20px 20px;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 10px 16px;
            border: 1px solid var(--border-color);
            font-size: 0.9rem;
            transition: all 0.25s;
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            border-color: var(--primary);
        }

        .btn-rounded {
            border-radius: 10px;
            padding: 8px 24px;
            font-weight: 600;
        }

        /* ======================== TABLE ======================== */
        .table { font-size: 0.88rem; }

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
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            padding: 14px 16px;
            color: var(--text-main);
        }

        .table tbody tr { transition: background 0.2s; }
        .table tbody tr:hover { background: #f8fafc; }

        .badge-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .badge-completed { background: var(--success-light); color: var(--success); }
        .badge-progress { background: var(--primary-light); color: var(--primary); }
        .badge-pending { background: var(--warning-light); color: var(--warning); }

        /* ======================== RESPONSIVE ======================== */
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .topbar .toggle-btn { display: block; }
            .topbar .search-container { width: 200px; }
        }

        @media (max-width: 576px) {
            .topbar .search-container { display: none; }
            .topbar-actions .user-pill span { display: none; }
        }

        /* Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.4);
            z-index: 99;
        }

        .sidebar-overlay.active { display: block; }

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
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon"><i class="bi bi-droplet-fill"></i></div>
                <div>
                    <h6 class="mb-0">AquaWash</h6>
                    <small>Recepción</small>
                </div>
            </div>

            <div class="sidebar-section">Principal</div>
            <ul class="sidebar-menu">
                <li class="active"><a href="/reception"><i class="bi bi-house-door-fill"></i> Panel</a></li>
                @if(Auth::user()->role === 'admin')
                <li><a href="/admin"><i class="bi bi-grid-1x2-fill"></i> Dashboard Admin</a></li>
                @endif
            </ul>

            <div class="sidebar-section">Módulos</div>
            <ul class="sidebar-menu">
                <li><a href="#"><i class="bi bi-car-front-fill"></i> Vehículos</a></li>
                <li><a href="#"><i class="bi bi-people-fill"></i> Lavadores</a></li>
            </ul>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div>
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">{{ Auth::user()->role === 'admin' ? 'Administrador' : 'Recepcionista' }}</div>
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
                    <div class="search-container">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Buscar placa, cliente...">
                    </div>
                </div>
                <div class="topbar-actions">
                    <div class="user-pill">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=32" alt="User">
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
            <main class="p-4 p-md-5">
                <!-- Toast para mensajes -->
                @if(session('success'))
                <div class="toast-container">
                    <div class="toast show align-items-center border-0" role="alert" style="background: #d1fae5; border: 1px solid #a7f3d0 !important; color: #065f46;">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            </div>
                            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
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
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(function(t) {
                setTimeout(() => t.classList.remove('show'), 3000);
            });
        }, 100);
    </script>

    @stack('scripts')
</body>
</html>
