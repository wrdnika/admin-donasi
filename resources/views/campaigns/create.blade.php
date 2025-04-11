@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto">
        <h1 class="text-2xl font-bold text-gray-700 mb-6">Tambah Campaign</h1>

        <form action="{{ route('campaigns.store') }}" method="POST" class="bg-white p-6 shadow-md rounded-lg">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Judul</label>
                <input type="text" name="title" class="w-full p-2 border rounded mt-1 focus:ring focus:ring-green-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Deskripsi</label>
                <textarea name="description" class="w-full p-2 border rounded mt-1 focus:ring focus:ring-green-300"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Target Donasi</label>
                <input type="number" name="goal_amount" class="w-full p-2 border rounded mt-1 focus:ring focus:ring-green-300">
            </div>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
                Simpan
            </button>
        </form>
    </div>
@endsection
