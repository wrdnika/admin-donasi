@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto p-4 sm:p-6">
        <h1 class="text-2xl font-bold text-gray-700 mb-6">Tambah Campaign</h1>

        <form action="{{ route('campaigns.store') }}" method="POST" class="bg-white p-6 shadow-md rounded-lg space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 font-semibold">Judul</label>
                <input type="text" name="title" class="w-full p-2 border rounded mt-1 focus:ring focus:ring-green-300" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold">Deskripsi</label>
                <textarea name="description" class="w-full p-2 border rounded mt-1 focus:ring focus:ring-green-300" rows="4" required></textarea>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold">Target Donasi</label>
                <input type="number" name="goal_amount" class="w-full p-2 border rounded mt-1 focus:ring focus:ring-green-300" required>
            </div>
            <div class="pt-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
