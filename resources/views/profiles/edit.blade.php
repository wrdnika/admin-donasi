@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto">
        <h1 class="text-2xl font-bold text-gray-700 mb-6">Edit Profil</h1>

        <form action="{{ route('profiles.update', $profile['id']) }}" method="POST" class="bg-white p-6 shadow-md rounded-lg">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Nama Lengkap</label>
                <input type="text" name="full_name" value="{{ $profile['full_name'] }}" class="w-full p-2 border rounded mt-1 focus:ring focus:ring-green-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Nomor HP</label>
                <input type="text" name="phone" value="{{ $profile['phone'] }}" class="w-full p-2 border rounded mt-1 focus:ring focus:ring-green-300">
            </div>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
                Update
            </button>
        </form>
    </div>
@endsection
