@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Laporan Donasi</h1>
        <a href="{{ route('donation-reports.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg">+ Tambah Laporan</a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Deskripsi</th>
                    <th class="p-3 text-left">Gambar</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                <tr class="border-t">
                    <td class="p-3">{{ $report['report_description'] }}</td>
                    <td class="p-3">
                        <img src="{{ $report['report_image'] }}" class="w-20 h-20 object-cover rounded" alt="Report Image">
                    </td>
                    <td class="p-3 text-center flex justify-center space-x-2">
                        <a href="{{ route('donation-reports.edit', $report['id']) }}" class="text-yellow-600 hover:underline">Edit</a>
                        <form action="{{ route('donation-reports.destroy', $report['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Hapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
