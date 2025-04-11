@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-2xl shadow-md space-y-6">

    <h1 class="text-2xl font-semibold text-gray-800">Edit Laporan Donasi</h1>

    {{-- Error Handling --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            <ul class="list-disc space-y-1 pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Start --}}
    <form action="{{ route('donation-reports.update', $report['id']) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PATCH')

        {{-- Campaign ID --}}
        <div>
            <label for="campaign_id" class="block text-sm font-medium text-gray-700 mb-1">ID Campaign</label>
            <input type="text" name="campaign_id" id="campaign_id" value="{{ $report['campaign_id'] }}" class="block w-full border border-gray-300 rounded-lg shadow-sm bg-gray-100 text-sm p-2.5" readonly>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label for="report_description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Laporan</label>
            <textarea name="report_description" id="report_description" rows="4" class="block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 text-sm p-2.5" required>{{ $report['report_description'] }}</textarea>
        </div>

        {{-- Preview Gambar --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Saat Ini</label>
            <img src="{{ $report['report_image'] }}" alt="Current Image" class="w-48 h-48 object-cover rounded-lg border border-gray-200 shadow-sm mb-2">
        </div>

        {{-- Upload Gambar Baru --}}
        <div>
            <label for="report_image" class="block text-sm font-medium text-gray-700 mb-1">Ganti Gambar (Opsional)</label>
            <input type="file" name="report_image" id="report_image" accept="image/*" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-green-500 focus:border-green-500 p-2.5">
            <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah gambar</p>
        </div>

        {{-- Buttons --}}
        <div class="flex justify-between">
            <a href="{{ route('donation-reports.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                Kembali
            </a>
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 transition duration-200">
                Update
            </button>
        </div>

    </form>
</div>
@endsection
