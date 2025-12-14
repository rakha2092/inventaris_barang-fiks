<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Reset default margin/padding */
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        
        /* SIDEBAR STYLES */
        .sidebar {
            min-height: 100vh;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            background-color: #f8f9fa;
            
            /* Mobile: fixed sidebar yang bisa di-toggle */
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            z-index: 1050;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            overflow-y: auto;
        }
        
        /* Tablet (768px ke atas) */
        @media (min-width: 768px) {
            .sidebar {
                transform: translateX(0);
                position: fixed; /* Tetap fixed untuk konsistensi */
            }
            
            /* Konten untuk tablet/desktop */
            .main-content {
                margin-left: 250px; /* Kasih margin untuk sidebar */
                width: calc(100% - 250px);
            }
        }
        
        /* Desktop (992px ke atas) */
        @media (min-width: 992px) {
            .sidebar {
                /* Lebar lebih besar untuk desktop */
                width: 280px;
            }
            
            .main-content {
                margin-left: 280px;
                width: calc(100% - 280px);
            }
        }
        
        /* Sidebar dalam keadaan terbuka */
        .sidebar.show {
            transform: translateX(0);
            box-shadow: 5px 0 15px rgba(0,0,0,0.1);
        }
        
        /* Link styles */
        .sidebar .nav-link {
            color: #333;
            padding: 12px 20px;
            margin: 3px 10px;
            border-radius: 8px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: white;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: #2c3e50;
        }
        
        /* MAIN CONTENT */
        .main-content {
            min-height: 100vh;
            background-color: #fff;
            transition: margin-left 0.3s ease-in-out;
        }
        
        /* Overlay untuk mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1040;
            backdrop-filter: blur(2px);
        }
        
        .sidebar-overlay.show {
            display: block;
            animation: fadeIn 0.3s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* MOBILE NAVBAR */
        .mobile-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 15px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        @media (min-width: 768px) {
            .mobile-navbar {
                display: none;
            }
        }
        
        /* Tombol toggle sidebar */
        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #495057;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.3s;
        }
        
        .sidebar-toggle:hover {
            background-color: rgba(0,0,0,0.05);
            transform: scale(1.05);
        }
        
        .mobile-user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        /* Top Navigation Desktop */
        .desktop-topnav {
            background: white;
            padding: 15px 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1020;
            border-bottom: 1px solid #dee2e6;
        }
        
        @media (max-width: 767px) {
            .desktop-topnav {
                display: none;
            }
        }
        
        /* Content wrapper untuk padding */
        .content-wrapper {
            padding: 20px;
        }
        
        @media (max-width: 767px) {
            .content-wrapper {
                padding: 15px;
            }
        }
        
        /* Header content */
        .content-header {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        
        .content-header h1 {
            color: #2c3e50;
            font-weight: 600;
        }
        
        /* Responsive table */
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }
        
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }
        
        /* Cards */
        .card {
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-radius: 12px;
            margin-bottom: 25px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }
        
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
            padding: 15px 20px;
            border-radius: 12px 12px 0 0 !important;
        }
        
        /* Alert styles */
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 3px 8px rgba(0,0,0,0.05);
            padding: 15px 20px;
        }
        
        /* Badge styles */
        .badge {
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 20px;
        }
        
        /* Scrollbar untuk sidebar */
        .sidebar::-webkit-scrollbar {
            width: 8px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Stats cards */
        .stat-card {
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            color: white;
            margin-bottom: 15px;
        }
        
        .stat-card h4 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        /* Print styles */
        @media print {
            .sidebar, .mobile-navbar, .desktop-topnav {
                display: none !important;
            }
            
            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Navbar -->
    <div class="mobile-navbar d-md-none">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="mobile-user-info">
            <span>
                <i class="fas fa-user me-1"></i> {{ auth()->user()->name }}
            </span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>
    
    <!-- Overlay for mobile sidebar -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="position-sticky pt-3">
            <div class="d-flex justify-content-between align-items-center px-3 mb-4">
                <div class="text-center w-100">
                    <h5 class="navbar-brand mb-2">
                        <i class="fas fa-warehouse me-2"></i>SISTEM INVENTARIS
                    </h5>
                    <small class="text-muted">
                        <i class="fas fa-user-tag me-1"></i>Role: {{ auth()->user()->role }}
                    </small>
                </div>
                <button class="sidebar-toggle d-md-none" id="closeSidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <ul class="nav flex-column">
                @yield('sidebar')
            </ul>
        </div>
    </nav>

    <!-- Main content -->
    <main class="main-content" id="mainContent">
        <!-- Top Navigation (Desktop) -->
        <nav class="desktop-topnav">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <h1 class="h4 mb-0 fw-bold">
                            <i class="fas fa-chart-line me-2"></i>@yield('header')
                        </h1>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted">
                            <i class="fas fa-user me-1"></i> {{ auth()->user()->name }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="d-flex">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-sign-out-alt me-1"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header Mobile -->
            <div class="d-md-none content-header">
                <h1 class="h3 mb-0 fw-bold">
                    <i class="fas fa-chart-line me-2"></i>@yield('header')
                </h1>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Main Content -->
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle Functionality
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const closeSidebar = document.getElementById('closeSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mainContent = document.getElementById('mainContent');
        
        function openSidebar() {
            sidebar.classList.add('show');
            sidebarOverlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        
        function closeSidebarMobile() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
        
        // Event Listeners
        sidebarToggle.addEventListener('click', openSidebar);
        closeSidebar.addEventListener('click', closeSidebarMobile);
        sidebarOverlay.addEventListener('click', closeSidebarMobile);
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth < 768 && 
                !sidebar.contains(event.target) && 
                !sidebarToggle.contains(event.target) &&
                sidebar.classList.contains('show')) {
                closeSidebarMobile();
            }
        });
        
        // Handle Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && sidebar.classList.contains('show')) {
                closeSidebarMobile();
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                // Pada tablet/desktop, pastikan sidebar terbuka
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });
        
        // Initialize on load
        window.addEventListener('load', function() {
            // Pastikan tinggi sidebar sesuai
            sidebar.style.height = '100vh';
            
            // Update layout berdasarkan ukuran layar
            if (window.innerWidth >= 768) {
                sidebar.classList.add('show');
            }
        });
    </script>
    @yield('scripts')
</body>
</html>