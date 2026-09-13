<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard') - Si Hadir SMKN 1 Kota Bekasi</title>

    <!-- Google Font & Bootstrap 5.3 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-blue: #1e3a8a;
            --primary-accent: #2563eb;
            --sidebar-bg: #111827;
            --sidebar-hover: #1f2937;
            --body-bg: #f3f4f6;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--body-bg);
            color: #1f2937;
            min-height: 100vh;
        }

        /* Top Navbar */
        .main-navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }

        .brand-logo {
            height: 42px;
            width: auto;
            object-fit: contain;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            min-height: calc(100vh - 65px);
            padding: 1.25rem 0.75rem;
        }

        .sidebar .nav-link {
            color: #9ca3af;
            font-size: 0.925rem;
            font-weight: 500;
            padding: 0.65rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link:hover {
            color: #ffffff;
            background-color: var(--sidebar-hover);
        }

        .sidebar .nav-link.active {
            color: #ffffff;
            background-color: var(--primary-accent);
        }

        .sidebar-section-title {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            padding: 0.75rem 1rem 0.25rem;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 1.75rem;
            overflow-x: hidden;
        }

        /* Card Enhancements */
        .card-custom {
            border: none;
            border-radius: 0.85rem;
            background: #ffffff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.02);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .stat-card {
            border-radius: 0.85rem;
            border: none;
            color: white;
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .stat-card .stat-icon {
            position: absolute;
            right: 15px;
            bottom: 10px;
            font-size: 3.5rem;
            opacity: 0.2;
        }

        /* Status Badges */
        .badge-masuk { background-color: #10b981; color: white; }
        .badge-izin { background-color: #f59e0b; color: white; }
        .badge-sakit { background-color: #3b82f6; color: white; }
        .badge-alfa { background-color: #ef4444; color: white; }

        @media (max-width: 991.98px) {
            .sidebar {
                display: none;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar main-navbar d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <i class="bi bi-list fs-5"></i>
            </button>
            <a href="/" class="d-flex align-items-center text-decoration-none gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SMKN 1 Kota Bekasi" class="brand-logo">
                <div class="lh-sm">
                    <span class="fs-5 fw-bold text-dark d-block">Si Hadir</span>
                    <small class="text-muted" style="font-size: 0.72rem;">SMK Negeri 1 Kota Bekasi</small>
                </div>
            </a>
        </div>

        <!-- User Profile & Action -->
        @auth
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 border py-1 px-3 rounded-pill" type="button" data-bs-toggle="dropdown">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="text-start d-none d-md-block">
                    <div class="fw-semibold lh-1" style="font-size: 0.875rem;">{{ auth()->user()->name }}</div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle mt-1" style="font-size: 0.7rem;">
                        {{ str_replace('_', ' ', strtoupper(auth()->user()->role)) }}
                    </span>
                </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                <li class="px-3 py-2 border-bottom">
                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                    <small class="text-muted">{{ auth()->user()->email }}</small>
                </li>
                <li>
                    <a class="dropdown-item text-danger py-2" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
        @else
        <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-3 rounded-pill">
            <i class="bi bi-box-arrow-in-right me-1"></i> Login
        </a>
        @endauth
    </nav>

    <!-- WRAPPER -->
    <div class="d-flex">
        <!-- DESKTOP SIDEBAR -->
        @auth
        <aside class="sidebar d-none d-lg-block">
            @php $role = auth()->user()->role; @endphp
            <div class="sidebar-section-title">Menu Utama</div>

            @if($role === 'guru_mapel')
                <a href="{{ route('dashboard.guru') }}" class="nav-link {{ request()->routeIs('dashboard.guru', 'dashboardd.guru') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard Guru
                </a>
                <a href="{{ route('guru.absen.form') }}" class="nav-link {{ request()->routeIs('guru.absen.form', 'dashboardd.absen') ? 'active' : '' }}">
                    <i class="bi bi-pencil-square"></i> Input Absensi
                </a>
                <a href="{{ route('dashboard.absen') }}" class="nav-link {{ request()->routeIs('dashboard.absen*') ? 'active' : '' }}">
                    <i class="bi bi-table"></i> Rekap Absensi
                </a>
            @elseif($role === 'siswa')
                <a href="{{ route('dashboard.siswa') }}" class="nav-link {{ request()->routeIs('dashboard.siswa') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Kehadiran Saya
                </a>
                <a href="{{ route('dashboard.absen') }}" class="nav-link {{ request()->routeIs('dashboard.absen*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i> Cek Data Absensi
                </a>
            @elseif($role === 'sekretaris')
                <a href="{{ route('dashboard.sekretaris') }}" class="nav-link {{ request()->routeIs('dashboard.sekretaris') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard Kelas
                </a>
                <a href="{{ route('guru.absen.form') }}" class="nav-link {{ request()->routeIs('guru.absen.form', 'dashboardd.absen') ? 'active' : '' }}">
                    <i class="bi bi-clipboard2-check"></i> Input Absensi Kelas
                </a>
                <a href="{{ route('dashboard.absen') }}" class="nav-link {{ request()->routeIs('dashboard.absen*') ? 'active' : '' }}">
                    <i class="bi bi-table"></i> Rekap Absensi
                </a>
            @elseif($role === 'guru_bk')
                <a href="{{ route('dashboard.guru_bk') }}" class="nav-link {{ request()->routeIs('dashboard.guru_bk') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard BK
                </a>
                <a href="{{ route('pelanggaran.index') }}" class="nav-link {{ request()->routeIs('pelanggaran.index') ? 'active' : '' }}">
                    <i class="bi bi-exclamation-triangle"></i> Catatan Pelanggaran
                </a>
                <a href="{{ route('pelanggaran.create') }}" class="nav-link {{ request()->routeIs('pelanggaran.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i> Tambah Pelanggaran
                </a>
                <a href="{{ route('dashboard.absen') }}" class="nav-link {{ request()->routeIs('dashboard.absen*') ? 'active' : '' }}">
                    <i class="bi bi-table"></i> Rekap Kehadiran
                </a>
            @elseif($role === 'guru_piket')
                <a href="{{ route('dashboard.guru_piket') }}" class="nav-link {{ request()->routeIs('dashboard.guru_piket') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard Piket
                </a>
                <a href="{{ route('pelanggaran.create') }}" class="nav-link {{ request()->routeIs('pelanggaran.create') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i> Catat Terlambat
                </a>
                <a href="{{ route('pelanggaran.index') }}" class="nav-link {{ request()->routeIs('pelanggaran.index') ? 'active' : '' }}">
                    <i class="bi bi-shield-exclamation"></i> Daftar Pelanggaran
                </a>
                <a href="{{ route('dashboard.absen') }}" class="nav-link {{ request()->routeIs('dashboard.absen*') ? 'active' : '' }}">
                    <i class="bi bi-table"></i> Pantau Absensi Hari Ini
                </a>
            @endif

            <div class="sidebar-section-title mt-4">Akun</div>
            <a href="{{ route('logout') }}" class="nav-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form-side').submit();">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </a>
            <form id="logout-form-side" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </aside>

        <!-- OFFCANVAS FOR MOBILE -->
        <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar">
            <div class="offcanvas-header border-bottom border-secondary">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 32px; width: auto;">
                    <h5 class="offcanvas-title fw-bold">Si Hadir</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body p-3">
                <div class="mb-3 px-2 py-2 bg-secondary bg-opacity-25 rounded">
                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                    <small class="text-white-50">{{ str_replace('_', ' ', strtoupper(auth()->user()->role)) }}</small>
                </div>

                @if($role === 'guru_mapel')
                    <a href="{{ route('dashboard.guru') }}" class="nav-link text-white py-2"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
                    <a href="{{ route('guru.absen.form') }}" class="nav-link text-white py-2"><i class="bi bi-pencil-square me-2"></i> Input Absen</a>
                    <a href="{{ route('dashboard.absen') }}" class="nav-link text-white py-2"><i class="bi bi-table me-2"></i> Rekap Absensi</a>
                @elseif($role === 'siswa')
                    <a href="{{ route('dashboard.siswa') }}" class="nav-link text-white py-2"><i class="bi bi-speedometer2 me-2"></i> Kehadiran</a>
                    <a href="{{ route('dashboard.absen') }}" class="nav-link text-white py-2"><i class="bi bi-calendar-check me-2"></i> Cek Data Absensi</a>
                @elseif($role === 'sekretaris')
                    <a href="{{ route('dashboard.sekretaris') }}" class="nav-link text-white py-2"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
                    <a href="{{ route('guru.absen.form') }}" class="nav-link text-white py-2"><i class="bi bi-pencil-square me-2"></i> Input Absen</a>
                    <a href="{{ route('dashboard.absen') }}" class="nav-link text-white py-2"><i class="bi bi-table me-2"></i> Rekap Absensi</a>
                @elseif($role === 'guru_bk')
                    <a href="{{ route('dashboard.guru_bk') }}" class="nav-link text-white py-2"><i class="bi bi-speedometer2 me-2"></i> Dashboard BK</a>
                    <a href="{{ route('pelanggaran.index') }}" class="nav-link text-white py-2"><i class="bi bi-exclamation-triangle me-2"></i> Pelanggaran</a>
                    <a href="{{ route('pelanggaran.create') }}" class="nav-link text-white py-2"><i class="bi bi-plus-circle me-2"></i> Tambah</a>
                    <a href="{{ route('dashboard.absen') }}" class="nav-link text-white py-2"><i class="bi bi-table me-2"></i> Rekap Absen</a>
                @elseif($role === 'guru_piket')
                    <a href="{{ route('dashboard.guru_piket') }}" class="nav-link text-white py-2"><i class="bi bi-speedometer2 me-2"></i> Dashboard Piket</a>
                    <a href="{{ route('pelanggaran.create') }}" class="nav-link text-white py-2"><i class="bi bi-clock-history me-2"></i> Catat Terlambat</a>
                    <a href="{{ route('pelanggaran.index') }}" class="nav-link text-white py-2"><i class="bi bi-shield-exclamation me-2"></i> Pelanggaran</a>
                    <a href="{{ route('dashboard.absen') }}" class="nav-link text-white py-2"><i class="bi bi-table me-2"></i> Pantau Absensi</a>
                @endif
                <hr class="border-secondary">
                <a href="{{ route('logout') }}" class="nav-link text-danger py-2" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
                <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
        @endauth

        <!-- CONTENT -->
        <main class="main-content">
            <!-- Flash Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show card-custom border-0 border-start border-4 border-success mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show card-custom border-0 border-start border-4 border-danger mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-octagon-fill text-danger fs-4 me-3"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show card-custom border-0 mb-4" role="alert">
                    <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Perhatian:</div>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

