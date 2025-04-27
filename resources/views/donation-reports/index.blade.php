@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Laporan Donasi</h1>
        <a href="{{ route('donation-reports.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition text-sm inline-flex items-center gap-2">
            <i data-feather="plus-circle" class="w-4 h-4"></i> Tambah Laporan
         </a>
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
                    <th class="p-3 text-left">Judul Kampanye</th>
                    <th class="p-3 text-left">Terkumpul dan tersalurkan</th>
                    <th class="p-3 text-left">Target</th>
                    <th class="p-3 text-left">Deskripsi</th>
                    <th class="p-3 text-left">Gambar</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                <tr class="border-t">
                    <td class="p-3">
                        {{ $report['campaigns']['title'] ?? '-' }}
                    </td>
                    <td class="p-3">
                        Rp{{ number_format($report['campaigns']['collected_amount'] ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="p-3">
                        Rp{{ number_format($report['campaigns']['goal_amount'] ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="p-3">
                        {{ $report['report_description'] }}
                    </td>
                    <td class="p-3">
                        @if (!empty($report['report_image']))
                            <div id="splide-{{ $report['id'] }}" class="splide" style="width: 80px;">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        @foreach ($report['report_image'] as $imgUrl)
                                            <li class="splide__slide">
                                                <img src="{{ $imgUrl }}" class="w-20 h-20 object-cover rounded cursor-pointer" alt="Report Image" onclick="openImageModal('{{ $imgUrl }}')">
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="custom-arrows mt-2 flex justify-center gap-2">
                                    <button class="custom-arrow custom-prev"><</button>
                                    <button class="custom-arrow custom-next">></button>
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    var splide = new Splide('#splide-{{ $report["id"] }}', {
                                        type: 'loop',
                                        perPage: 1,
                                        arrows: false,
                                        pagination: false,
                                        autoplay: true,
                                        interval: 3000,
                                    }).mount();

                                    document.querySelector('#splide-{{ $report["id"] }} .custom-prev').addEventListener('click', function () {
                                        splide.go('<');
                                    });

                                    document.querySelector('#splide-{{ $report["id"] }} .custom-next').addEventListener('click', function () {
                                        splide.go('>');
                                    });
                                });
                            </script>
                        @endif
                    </td>
                    <td class="p-3 text-center flex justify-center space-x-2">
                        <a href="{{ route('donation-reports.edit', $report['id']) }}" class="text-yellow-500 hover:text-yellow-600 inline-flex items-center gap-1">
                            <i data-feather="edit" class="w-4 h-4"></i> Edit
                        </a>

                        <form action="{{ route('donation-reports.destroy', $report['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline inline-flex items-center" onclick="return confirm('Hapus data ini?')">
                                <i data-feather="trash-2" class="w-4 h-4"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Modal Popup -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden justify-center items-center z-50">
    <span class="absolute top-4 right-4 text-white text-3xl cursor-pointer" onclick="closeImageModal()">&times;</span>
    <img id="modalImage" class="max-w-full max-h-full rounded shadow-lg">
</div>

<script>
    function openImageModal(imageUrl) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageUrl;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

    </div>
</div>
@endsection
