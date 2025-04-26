@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-4 sm:p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Kampanye</h1>
        <a href="{{ route('campaigns.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition text-sm inline-flex items-center gap-2">
           <i data-feather="plus-circle" class="w-4 h-4"></i> Tambah Kampanye
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($campaigns as $campaign)
            @php
                $goal = $campaign['goal_amount'] ?: 1;
                $progress = min(100, round(($campaign['collected_amount'] / $goal) * 100));
            @endphp

            <div class="bg-white p-5 shadow rounded-2xl flex flex-col justify-between transition hover:shadow-lg">
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">{{ $campaign['title'] }}</h2>
                    <p class="text-gray-600 text-sm mt-1 line-clamp-3">{{ $campaign['description'] }}</p>

                    <div class="mt-4">
                        <div class="h-2 rounded bg-gray-200">
                            <div class="h-full rounded bg-green-500" style="width: {{ $progress }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>Rp {{ number_format($campaign['collected_amount'], 0, ',', '.') }}</span>
                            <span>Rp {{ number_format($campaign['goal_amount'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between items-center text-sm mt-2">
                    <a href="{{ route('campaigns.edit', $campaign['id']) }}" class="text-yellow-500 hover:text-yellow-600 inline-flex items-center gap-1">
                        <i data-feather="edit" class="w-4 h-4"></i> Edit
                    </a>
                    <form action="{{ route('campaigns.destroy', $campaign['id']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus campaign ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-600 inline-flex items-center gap-1">
                            <i data-feather="trash-2" class="w-4 h-4"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
