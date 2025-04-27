<!DOCTYPE html>
<html lang="id">
<head>
    @stack('styles')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi IKBS Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: "#16a34a",
            }
          }
        }
      }
    </script>
    <!-- Heroicons CDN -->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Splide CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/css/splide.min.css">
    <style>
        .custom-arrows {
            margin-top: 8px;
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .custom-arrow {
            background-color: #10B981;
            color: white;
            border: none;
            border-radius: 9999px;
            padding: 4px 8px;
            font-size: 12px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .custom-arrow:hover {
            background-color: #059669;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="flex h-screen overflow-hidden">

        <!-- Mobile Navbar -->
        <div class="md:hidden fixed top-0 left-0 z-50 w-full bg-white p-4 shadow flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img src="/logo.png" alt="Logo Admin" class="h-8" />
                <h2 class="text-xl font-bold text-primary">Donasi IKBS</h2>
            </div>
            <button id="sidebarToggle" class="text-gray-700 focus:outline-none">
                <i data-feather="menu" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed z-40 inset-y-0 left-0 w-64 bg-white shadow-lg p-5 transform -translate-x-full transition-transform duration-300 ease-in-out md:relative md:translate-x-0 md:flex flex-col h-full">
            <!-- Logo & Title -->
            <div class="mt-12 md:mt-0">
                <div class="flex items-center gap-4 mb-6 hidden md:block">
                    <img src="/logo.png" alt="Logo Admin hidden md:block" class="h-12" />
                    <h2 class="text-xl font-bold text-primary hidden md:block">Donasi IKBS</h2>
                </div>

                <!-- Navigation -->
                <ul class="space-y-2 text-sm font-medium">
                    <li>
                        <a href="{{ route('campaigns.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary/10 hover:text-primary transition duration-200 {{ request()->routeIs('campaigns.index') ? 'bg-primary/10 text-primary' : 'text-gray-700' }}">
                            <i data-feather="flag"></i> Kampanye
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profiles.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary/10 hover:text-primary transition duration-200 {{ request()->routeIs('profiles.index') ? 'bg-primary/10 text-primary' : 'text-gray-700' }}">
                            <i data-feather="user"></i> Profil pengguna
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('donation-reports.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary/10 hover:text-primary transition duration-200 {{ request()->routeIs('donation-reports.index') ? 'bg-primary/10 text-primary' : 'text-gray-700' }}">
                            <i data-feather="file-text"></i> Donasi tersalurkan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logs-transactions.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary/10 hover:text-primary transition duration-200 {{ request()->routeIs('logs-transactions.index') ? 'bg-primary/10 text-primary' : 'text-gray-700' }}">
                            <i data-feather="activity"></i> Histori transaksi
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Logout Button -->
            <div class="mt-auto py-1 border-t">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 p-1 rounded-lg text-gray-700 hover:bg-red-100 hover:text-red-600 transition">
                        <i data-feather="log-out"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6 mt-16 md:mt-0">
            @yield('content')
        </main>
    </div>

    @stack('scripts')

    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });

        feather.replace();
    </script>
    <!-- Splide JS -->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/js/splide.min.js"></script>
</body>
</html>
