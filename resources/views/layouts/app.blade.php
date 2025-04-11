<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi IKBS Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-md p-5 flex flex-col h-full">
            <div>
                <h2 class="text-xl font-bold text-green-700 mb-6">Donasi IKBS Dashboard</h2>
                <ul class="space-y-4">
                    <li>
                        <a href="{{ route('campaigns.index') }}" class="flex items-center space-x-3 p-2 rounded-lg text-gray-700 hover:bg-green-100 hover:text-green-700 transition">
                            <span>Campaigns</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profiles.index') }}" class="flex items-center space-x-3 p-2 rounded-lg text-gray-700 hover:bg-green-100 hover:text-green-700 transition">
                            <span>Profile User</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('donation-reports.index') }}" class="flex items-center space-x-3 p-2 rounded-lg text-gray-700 hover:bg-green-100 hover:text-green-700 transition">
                            <span>Donation report</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-3 p-2 rounded-lg text-gray-400 cursor-not-allowed">
                            <span>Fitur Lain (Coming Soon)</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Logout di Bawah -->
            <div class="mt-auto">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 p-2 rounded-lg text-gray-700 hover:bg-red-100 hover:text-red-600 transition">
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Content -->
        <div class="flex-1 p-6">
            @yield('content')
        </div>
    </div>
</body>
</html>
