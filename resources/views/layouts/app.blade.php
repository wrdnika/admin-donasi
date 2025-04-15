<!DOCTYPE html>
<html lang="id">
<head>
    @stack('styles')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi IKBS Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile Sidebar Toggle Button -->
        <div class="md:hidden fixed top-0 left-0 z-50 bg-white w-full p-4 flex justify-between items-center shadow-md">
            <h2 class="text-lg font-bold text-green-700">Donasi IKBS</h2>
            <button id="sidebarToggle" class="text-gray-700 focus:outline-none">
                ☰
            </button>
        </div>

        <!-- Sidebar -->
        <div id="sidebar" class="fixed z-40 inset-y-0 left-0 w-64 bg-white shadow-md p-5 transform -translate-x-full transition-transform duration-200 ease-in-out md:relative md:translate-x-0 md:flex flex-col h-full">
            <div class="mt-12 md:mt-0">
                <h2 class="text-xl font-bold text-green-700 mb-6 hidden md:block">Donasi IKBS Dashboard</h2>
                <ul class="space-y-4">
                    <li>
                        <a href="{{ route('campaigns.index') }}" class="block p-2 rounded-lg text-gray-700 hover:bg-green-100 hover:text-green-700 transition">Campaigns</a>
                    </li>
                    <li>
                        <a href="{{ route('profiles.index') }}" class="block p-2 rounded-lg text-gray-700 hover:bg-green-100 hover:text-green-700 transition">Profile User</a>
                    </li>
                    <li>
                        <a href="{{ route('donation-reports.index') }}" class="block p-2 rounded-lg text-gray-700 hover:bg-green-100 hover:text-green-700 transition">Donation Report</a>
                    </li>
                    <li>
                        <a href="{{ route('logs-transactions.index') }}" class="block p-2 rounded-lg text-gray-700 hover:bg-green-100 hover:text-green-700 transition">Log Transaction</a>
                    </li>
                </ul>
            </div>

            <div class="mt-auto">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full block p-2 rounded-lg text-gray-700 hover:bg-red-100 hover:text-red-600 transition">Logout</button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto p-6 mt-16 md:mt-0">
            @yield('content')
        </div>
    </div>

    @stack('scripts')

    <script>
        // Toggle sidebar untuk mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>
