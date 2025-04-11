@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Daftar Campaign</h1>
            <a href="{{ route('campaigns.create') }}" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
                + Tambah Campaign
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid md:grid-cols-2 gap-6">
            @foreach ($campaigns as $campaign)
                <div class="bg-white p-5 shadow-md rounded-lg">
                    <h2 class="text-lg font-semibold">{{ $campaign['title'] }}</h2>
                    <p class="text-gray-600 text-sm mt-1">{{ $campaign['description'] }}</p>
                    <div class="flex justify-between items-center mt-4 text-sm text-gray-500">
                        <span>🎯 Target: Rp {{ number_format($campaign['goal_amount'], 0, ',', '.') }}</span>
                        <span>✅ Terkumpul: Rp {{ number_format($campaign['collected_amount'], 0, ',', '.') }}</span>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('campaigns.edit', $campaign['id']) }}" class="text-yellow-600 hover:text-yellow-700 transition">✏️ Edit</a>
                        <form action="{{ route('campaigns.destroy', $campaign['id']) }}" method="POST">
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
