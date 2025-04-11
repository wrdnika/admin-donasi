@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Profil User</h1>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 border border-green-400">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-5 shadow-lg rounded-lg overflow-x-auto">
            <table class="w-full border-collapse rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-left">
                        <th class="p-3 font-semibold">Nama Lengkap</th>
                        <th class="p-3 font-semibold">Nomor HP</th>
                        <th class="p-3 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profiles as $profile)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="p-3">{{ $profile['full_name'] }}</td>
                            <td class="p-3">{{ $profile['phone'] }}</td>
                            <td class="p-3 flex justify-center space-x-3">
                                <a href="{{ route('profiles.edit', $profile['id']) }}" class="text-yellow-600 hover:text-yellow-700 transition">✏️ Edit</a>
                                <form action="{{ route('profiles.destroy', $profile['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus profil ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 transition">🗑 Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
