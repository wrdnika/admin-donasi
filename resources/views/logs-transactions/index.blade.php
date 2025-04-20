@extends('layouts.app')

@section('content')
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .dataTables_wrapper {
        font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
        margin-bottom: 2rem;
    }

    .dataTables_filter input {
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        padding: 8px 12px !important;
        font-size: 14px !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
        transition: all 0.3s ease;
        width: 240px !important;
        background-color: #f9fafb !important;
    }

    .dataTables_filter input:focus {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
        outline: none !important;
    }

    .dataTables_filter label {
        font-weight: 500;
        color: #4b5563;
        font-size: 14px;
    }

    .dataTables_wrapper .dt-buttons {
        margin-bottom: 1.5rem;
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .dt-button {
        background: #fff !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 8px !important;
        padding: 8px 16px !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        color: #4b5563 !important;
        transition: all 0.2s ease !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
    }

    .dt-button:hover {
        background: #f9fafb !important;
        border-color: #d1d5db !important;
        color: #111827 !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05) !important;
    }

    .dt-button:focus {
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
    }

    .dt-button:active {
        background: #f3f4f6 !important;
        border-color: #d1d5db !important;
    }

    .dt-button.buttons-csv {
        color: #0369a1 !important;
    }

    .dt-button.buttons-excel {
        color: #166534 !important;
    }

    .dt-button.buttons-pdf {
        color: #b91c1c !important;
    }

    .dt-button.buttons-print {
        color: #4338ca !important;
    }

    .dataTable {
        border-collapse: separate !important;
        border-spacing: 0 !important;
        width: 100% !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 10px !important;
        overflow: hidden !important;
    }

    .dataTable thead th {
        border-bottom: 1px solid #e5e7eb !important;
        background-color: #f9fafb !important;
        padding: 12px 16px !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.025em !important;
        color: #6b7280 !important;
    }

    .dataTable tbody tr {
        transition: all 0.2s ease;
    }

    .dataTable tbody tr:hover {
        background-color: #f3f4f6 !important;
    }

    .dataTable tbody td {
        padding: 14px 16px !important;
        border-bottom: 1px solid #f3f4f6 !important;
        color: #1f2937 !important;
        font-size: 14px !important;
        vertical-align: middle !important;
    }

    .dataTable tbody tr:last-child td {
        border-bottom: none !important;
    }

    .dataTables_paginate {
        padding: 1rem 0 !important;
        display: flex !important;
        justify-content: flex-end !important;
    }

    .dataTables_paginate .paginate_button {
        margin: 0 2px !important;
        padding: 6px 12px !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 6px !important;
        color: #4b5563 !important;
        background-color: #fff !important;
        transition: all 0.2s ease !important;
        font-size: 14px !important;
        font-weight: 500 !important;
    }

    .dataTables_paginate .paginate_button:hover {
        background-color: #f9fafb !important;
        color: #111827 !important;
        border-color: #d1d5db !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
    }

    .dataTables_paginate .paginate_button.current {
        background-color: #6366f1 !important;
        border-color: #6366f1 !important;
        color: #fff !important;
        font-weight: 600 !important;
    }

    .dataTables_paginate .paginate_button.current:hover {
        background-color: #4f46e5 !important;
    }

    .dataTables_paginate .paginate_button.disabled {
        opacity: 0.5 !important;
        cursor: not-allowed !important;
    }

    .dataTables_info {
        font-size: 14px !important;
        color: #6b7280 !important;
        padding: 1rem 0 !important;
    }

    .table-responsive {
        border-radius: 10px !important;
        overflow: hidden !important;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge.bg-success {
        background-color: #d1fae5 !important;
        color: #047857 !important;
    }

    .badge.bg-warning {
        background-color: #fef3c7 !important;
        color: #b45309 !important;
    }

    .badge.bg-danger {
        background-color: #fee2e2 !important;
        color: #b91c1c !important;
    }

    .filter-container {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
        border: 1px solid #e5e7eb;
    }

    .filter-container h5 {
        font-size: 16px;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-container .input-group {
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        overflow: hidden;
    }

    .filter-container .input-group-text {
        background-color: #f9fafb;
        border-color: #e5e7eb;
        color: #6b7280;
        font-size: 14px;
        font-weight: 500;
        padding: 8px 16px;
    }

    .filter-container .form-control {
        border-color: #e5e7eb;
        padding: 8px 16px;
        height: auto;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .filter-container .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .filter-container .btn-primary {
        background-color: #6366f1;
        border-color: #6366f1;
        padding: 8px 16px;
        font-weight: 500;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }

    .filter-container .btn-primary:hover {
        background-color: #4f46e5;
        border-color: #4f46e5;
    }

    .filter-container .btn-outline-secondary {
        border-color: #e5e7eb;
        color: #6b7280;
        font-weight: 500;
        padding: 8px 16px;
        transition: all 0.2s ease;
    }

    .filter-container .btn-outline-secondary:hover {
        background-color: #f3f4f6;
        color: #4b5563;
    }

    @media (max-width: 768px) {
        .filter-inputs {
            flex-direction: column;
            gap: 12px;
        }

        .filter-inputs .input-group {
            width: 100%;
        }

        .filter-btn {
            width: 100%;
            margin-top: 12px;
        }

        .dataTables_wrapper .dt-buttons {
            justify-content: center;
        }

        .dataTables_filter {
            margin-top: 12px;
            display: flex;
            justify-content: center;
        }

        .dataTables_filter input {
            width: 100% !important;
        }
    }
</style>
@endpush

@push('scripts')
<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Buttons & Export plugins -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#logsTable').DataTable({
            dom: '<"datatable-header"<"row align-items-center"<"col-md-6"B><"col-md-6"f>>>rt<"datatable-footer"<"row align-items-center"<"col-md-6"i><"col-md-6"p>>>',
            buttons: [
                {
                    extend: 'csv',
                    className: 'btn-sm',
                    text: '<i class="fas fa-file-csv me-1"></i> Export CSV',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-sm',
                    text: '<i class="fas fa-file-excel me-1"></i> Export Excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn-sm',
                    text: '<i class="fas fa-file-pdf me-1"></i> Export PDF',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function(doc) {
                        doc.defaultStyle.fontSize = 10;
                        doc.styles.tableHeader.fontSize = 11;
                        doc.styles.tableHeader.alignment = 'left';
                        doc.styles.tableBodyEven.alignment = 'left';
                        doc.styles.tableBodyOdd.alignment = 'left';
                    }
                },
                {
                    extend: 'print',
                    className: 'btn-sm',
                    text: '<i class="fas fa-print me-1"></i> Print',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ],
            language: {
                search: "<span class='me-2'><i class='fas fa-search'></i></span> Cari:",
                lengthMenu: "<span class='me-2'><i class='fas fa-list'></i></span> Tampilkan _MENU_ entri",
                info: "<span class='text-muted'><i class='fas fa-info-circle me-1'></i> Menampilkan _START_ sampai _END_ dari _TOTAL_ data</span>",
                paginate: {
                    first: "<i class='fas fa-angle-double-left'></i>",
                    last: "<i class='fas fa-angle-double-right'></i>",
                    next: "<i class='fas fa-angle-right'></i>",
                    previous: "<i class='fas fa-angle-left'></i>"
                },
                emptyTable: "<div class='text-center p-4'><i class='fas fa-database text-muted fa-3x mb-3'></i><br>Tidak ada data tersedia</div>",
                zeroRecords: "<div class='text-center p-4'><i class='fas fa-search text-muted fa-3x mb-3'></i><br>Tidak ada data yang cocok dengan pencarian Anda</div>"
            },
            responsive: true,
            order: [[7, 'desc']],
            pageLength: 10,
            lengthChange: true,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
            stateSave: true,
            drawCallback: function() {
                $('#logsTable tbody tr td:nth-child(6)').each(function() {
                    let status = $(this).text().trim().toLowerCase();
                    if (status.includes('berhasil') || status.includes('success')) {
                        $(this).find('.badge').addClass('bg-success');
                    } else if (status.includes('menunggu') || status.includes('pending')) {
                        $(this).find('.badge').addClass('bg-warning');
                    } else if (status.includes('gagal') || status.includes('failed') || status.includes('cancel')) {
                        $(this).find('.badge').addClass('bg-danger');
                    }
                });

                $('#logsTable tbody tr td').each(function(){
                    if(this.offsetWidth < this.scrollWidth && !$(this).attr('title')) {
                        $(this).attr('title', $(this).text());
                    }
                });
            }
        });

function populateDropdowns() {
    let campaignSet = new Set();
    let nameSet = new Set();

    table.rows().every(function () {
        let data = this.data();

        let campaignText = $('<div>').html(data[3]).text().trim().replace(/\s+/g, ' ');
        let nameText = $('<div>').html(data[2]).text().trim().replace(/\s+/g, ' ');

        campaignSet.add(campaignText);
        nameSet.add(nameText);
    });

    $('#campaignFilter').append(
        Array.from(campaignSet).sort().map(c => `<option value="${c}">${c}</option>`)
    );

    $('#fullNameFilter').append(
        Array.from(nameSet).sort().map(n => `<option value="${n}">${n}</option>`)
    );
}

$('#campaignFilter').on('change', function () {
    let selected = $(this).val()?.trim().replace(/\s+/g, ' ') || '';
    console.log('Filter dipilih (clean):', selected);
    table.column(3).search(selected, false, false).draw();
});

$('#fullNameFilter').on('change', function () {
    let selected = $(this).val()?.trim().replace(/\s+/g, ' ') || '';
    table.column(2).search(selected, false, false).draw();
});
setTimeout(populateDropdowns, 500);

$('#filterBtn').on('click', function() {
    let startDate = $('#startDate').val();
    let endDate = $('#endDate').val();

    if (startDate && endDate) {
        setTimeout(() => {
            filterByDateRange(startDate, endDate);
            $(this).html('<i class="fas fa-search me-1"></i> Filter');
            $(this).prop('disabled', false);
        }, 500);
    } else {
        showNotification('Peringatan', 'Silakan masukkan kedua tanggal untuk melakukan filter', 'warning');
    }
});

$('#clearFilterBtn').on('click', function() {
    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
    $(this).prop('disabled', true);

    setTimeout(() => {
        $('#startDate').val('');
        $('#endDate').val('');
        $('#campaignFilter').val('');
        $('#fullNameFilter').val('');

        if ($.fn.dataTable.ext.search.length > 0) {
            $.fn.dataTable.ext.search.pop();
        }

        table.search('').columns().search('').draw();
        $(this).html('<i class="fas fa-times me-1"></i> Clear');
        $(this).prop('disabled', false);

        showNotification('Berhasil', 'Filter berhasil dihapus', 'success');
    }, 300);
});

function filterByDateRange(start, end) {
    const startTimestamp = new Date(start).getTime();
    const endTimestamp = new Date(end).getTime() + (24 * 60 * 60 * 1000 - 1);

    while ($.fn.dataTable.ext.search.length > 0) {
        $.fn.dataTable.ext.search.pop();
    }

    // Tambahkan filter baru
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        let dateText = data[7].trim();
        let datePattern = /(\d+)\s+([A-Za-z]+)\s+(\d+),\s+(\d+):(\d+)/;
        let match = dateText.match(datePattern);

        if (!match) return true;

        let monthNames = {
            "Jan": 0, "Feb": 1, "Mar": 2, "Apr": 3, "Mei": 3, "May": 4,
            "Jun": 5, "Jul": 6, "Agt": 7, "Aug": 7, "Sep": 8, "Okt": 9,
            "Oct": 9, "Nov": 10, "Des": 11, "Dec": 11
        };

        let day = parseInt(match[1]);
        let monthIdx = monthNames[match[2]] || 0;
        let year = parseInt(match[3]);
        let hour = parseInt(match[4]);
        let minute = parseInt(match[5]);

        let transactionDate = new Date(year, monthIdx, day, hour, minute).getTime();

        if (transactionDate >= startTimestamp && transactionDate <= endTimestamp) {
            return true;
        }
        return false;
    });

    table.draw();

    const startFormatted = new Date(start).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'});
    const endFormatted = new Date(end).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'});
    showNotification('Filter Aktif', `Menampilkan data dari ${startFormatted} hingga ${endFormatted}`, 'info');
    // Filter akan dihapus saat tombol Clear diklik atau filter baru diterapkan
}

function showNotification(title, message, type) {
    if ($('#toast-container').length === 0) {
        $('body').append('<div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>');
    }

    const toast = `
        <div class="toast align-items-center border-0 bg-${type === 'warning' ? 'warning' : type === 'success' ? 'success' : 'light'} text-${type === 'warning' || type === 'success' ? 'dark' : 'dark'}" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-${type === 'warning' ? 'exclamation-triangle' : type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                        <div>
                            <strong>${title}</strong>
                            <div>${message}</div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;

    const $toast = $(toast).appendTo('#toast-container');
    const bsToast = new bootstrap.Toast($toast[0], {
        autohide: true,
        delay: 3000
    });
    bsToast.show();

    $toast.on('hidden.bs.toast', function() {
        $(this).remove();
    });
}
    });
</script>
@endpush
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h2 class="page-title mb-3 mb-md-0">
                    <i class="fas fa-history me-2"></i>Logs Transactions
                </h2>
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary me-2">Total: {{ count($transactions) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="filter-container p-4 rounded-lg shadow-md bg-white mb-5 border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h5 class="text-lg font-bold text-indigo-600 flex items-center">
                        <i class="fas fa-sliders-h mr-2"></i>Filter Data
                    </h5>
                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Pilih rentang waktu</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div class="relative">
                        <label for="startDate" class="text-xs text-gray-500 mb-1 block">Dari Tanggal</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class=" text-gray-400"></i>
                            </div>
                            <input type="date" id="startDate" class="form-control pl-10 py-2.5 w-full border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all" />
                        </div>
                    </div>

                    <div class="relative">
                        <label for="endDate" class="text-xs text-gray-500 mb-1 block">Sampai Tanggal</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class=" text-gray-400"></i>
                            </div>
                            <input type="date" id="endDate" class="form-control pl-10 py-2.5 w-full border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all" />
                        </div>
                    </div>

                    <div class="flex items-end gap-2">
                        <button class="btn flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 px-4 rounded-lg transition-all flex items-center justify-center" id="filterBtn">
                            <i class="fas fa-search mr-2"></i>Terapkan Filter
                        </button>
                        <button class="btn bg-white border border-gray-200 hover:bg-gray-50 text-gray-500 py-2.5 px-3 rounded-lg transition-all" id="clearFilterBtn">
                            <i class="fas fa-redo-alt"></i>
                        </button>
                    </div>
                                        <!-- Filter Judul Campaign -->
<div class="relative">
    <label for="campaignFilter" class="text-xs text-gray-500 mb-1 block">Filter Judul Campaign</label>
    <select id="campaignFilter" class="form-control py-2.5 w-full border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all">
        <option value="">Semua Campaign</option>
        <!-- Isi akan di-generate oleh jQuery -->
    </select>
</div>

<!-- Filter Full Name -->
<div class="relative">
    <label for="fullNameFilter" class="text-xs text-gray-500 mb-1 block">Filter Nama Donatur</label>
    <select id="fullNameFilter" class="form-control py-2.5 w-full border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all">
        <option value="">Semua Nama</option>
        <!-- Isi akan di-generate oleh jQuery -->
    </select>
</div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card rounded-lg border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-white py-3 px-4 border-bottom border-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-indigo-600 fw-bold">Daftar Transaksi</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="logsTable" class="table align-middle mb-0">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-3 px-4 text-uppercase text-xs font-semibold text-gray-600">#</th>
                                    <th class="py-3 px-4 text-uppercase text-xs font-semibold text-gray-600">User Email</th>
                                    <th class="py-3 px-4 text-uppercase text-xs font-semibold text-gray-600">Full Name</th>
                                    <th class="py-3 px-4 text-uppercase text-xs font-semibold text-gray-600">Campaign Title</th>
                                    <th class="py-3 px-4 text-uppercase text-xs font-semibold text-gray-600">Amount</th>
                                    <th class="py-3 px-4 text-uppercase text-xs font-semibold text-gray-600">Status</th>
                                    <th class="py-3 px-4 text-uppercase text-xs font-semibold text-gray-600">Order ID</th>
                                    <th class="py-3 px-4 text-uppercase text-xs font-semibold text-gray-600">Transaction Time</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @forelse ($transactions as $trx)
                                    <tr class="border-bottom hover:bg-gray-50 transition-all">
                                        <td class="py-3 px-4">{{ $loop->iteration }}</td>
                                        <td class="py-3 px-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm  text-indigo-600 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    <i class="fas fa-user-circle"></i>
                                                    <span>{{ $trx['user_email'] ?? '-' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 fw-medium">{{ $trx['full_name'] ?? '-' }}</td>
                                        <td class="py-3 px-4">
                                            <div class="text-truncate" style="max-width: 200px;">
                                                {{ $trx['campaign_title'] ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 fw-semibold">Rp{{ number_format($trx['amount'], 0, ',', '.') }}</td>
                                        <td class="py-3 px-4">
                                            @if($trx['status'] === 'success')
                                                <span class="badge bg-success-soft text-success px-3 py-2 rounded-pill fw-normal text-green-500">
                                                    <i class="fas fa-check-circle me-1"></i> Berhasil
                                                </span>
                                            @elseif($trx['status'] === 'pending')
                                                <span class="badge bg-warning-soft text-warning px-3 py-2 rounded-pill fw-normal text-yellow-500">
                                                    <i class="fas fa-clock me-1"></i> Pending
                                                </span>
                                            @else
                                                <span class="badge bg-danger-soft text-danger px-3 py-2 rounded-pill fw-normal text-red-600">
                                                    <i class="fas fa-times-circle me-1"></i> Gagal
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            <span class="text-monospace text-sm bg-gray-100 py-1 px-2 rounded">{{ $trx['order_id'] }}</span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="d-flex align-items-center">
                                                <i class="far fa-calendar-alt text-gray-500 me-2"></i>
                                                <span>{{ \Carbon\Carbon::parse($trx['transaction_time'])->format('d M Y, H:i') }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="empty-state-icon mb-3">
                                                    <i class="fas fa-database text-gray-300 fa-3x"></i>
                                                </div>
                                                <h6 class="text-gray-500">Tidak ada data transaksi ditemukan</h6>
                                                <p class="text-gray-400 text-sm">Coba ubah filter pencarian Anda</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
