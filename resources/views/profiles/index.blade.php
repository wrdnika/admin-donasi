@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-4 sm:p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Profil Pengguna</h1>
    </div>
    <form method="GET" action="{{ route('profiles.index') }}" class="mb-4 flex flex-col sm:flex-row gap-2 sm:items-center">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama atau nomor HP..."
            class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
        >
        <div class="flex gap-2">
            <button
                type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition text-sm flex items-center gap-1"
            >
                <i data-feather="search" class="w-4 h-4"></i> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('profiles.index') }}"
                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-sm flex items-center gap-1"
                >
                    <i data-feather="x-circle" class="w-4 h-4"></i> Reset
                </a>
            @endif
        </div>
    </form>



    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 border border-green-400 shadow-sm text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-xl overflow-hidden">
        <table class="w-full text-sm text-gray-700">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4 text-left font-semibold">Nama Lengkap</th>
                    <th class="p-4 text-left font-semibold">Nomor HP</th>
                    <th class="p-4 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($profiles as $profile)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="p-4">{{ $profile['full_name'] }}</td>
                        <td class="p-4">{{ $profile['phone'] }}</td>
                        <td class="p-4">
                            <div class="flex justify-center gap-4">
                                <a href="{{ route('profiles.edit', $profile['id']) }}" class="text-yellow-500 hover:text-yellow-600 flex items-center gap-1">
                                    <i data-feather="edit" class="w-4 h-4"></i> Edit
                                </a>
                                <form action="{{ route('profiles.destroy', $profile['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus profil ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 flex items-center gap-1">
                                        <i data-feather="trash-2" class="w-4 h-4"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">Belum ada data profil.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
