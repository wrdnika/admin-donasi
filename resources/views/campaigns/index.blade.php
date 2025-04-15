@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Daftar Campaign</h1>
            <a href="{{ route('campaigns.create') }}" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition text-sm">
                + Tambah Campaign
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($campaigns as $campaign)
                <div class="bg-white p-5 shadow-md rounded-lg flex flex-col justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">{{ $campaign['title'] }}</h2>
                        <p class="text-gray-600 text-sm mt-1">{{ $campaign['description'] }}</p>
                        <div class="flex flex-col mt-4 text-sm text-gray-500 gap-1">
                            <span>🎯 Target: Rp {{ number_format($campaign['goal_amount'], 0, ',', '.') }}</span>
                            <span>✅ Terkumpul: Rp {{ number_format($campaign['collected_amount'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-4 text-sm">
                        <a href="{{ route('campaigns.edit', $campaign['id']) }}" class="text-yellow-600 hover:text-yellow-700 transition">✏️ Edit</a>
                        <form action="{{ route('campaigns.destroy', $campaign['id']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus campaign ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700 transition">🗑 Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
