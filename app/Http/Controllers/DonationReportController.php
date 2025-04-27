<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class DonationReportController extends Controller
{
    protected $supabaseUrl;
    protected $supabaseKey;
    protected $storageUrl;

    public function __construct()
    {
        $this->supabaseUrl = env('SUPABASE_URL');
        $this->supabaseKey = env('SUPABASE_API_KEY');
        $this->storageUrl  = $this->supabaseUrl . '/storage/v1';
    }

    public function index()
    {
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey
        ])->get("{$this->supabaseUrl}/rest/v1/donation_reports?select=*,campaigns(title,collected_amount,goal_amount)");

        $reports = $response->json();

        return view('donation-reports.index', compact('reports'));
    }

    public function create()
    {
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey
        ])->get("{$this->supabaseUrl}/rest/v1/campaigns?select=id,title");

        $campaigns = $response->json();

        return view('donation-reports.create', compact('campaigns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'campaign_id' => 'required|uuid',
            'report_description' => 'required|string',
            'report_image.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imageUrls = [];

        if ($request->hasFile('report_image')) {
            foreach ($request->file('report_image') as $image) {
                $fileName = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $fileResource = fopen($image->getRealPath(), 'r');

                $upload = Http::withHeaders([
                    'apikey' => $this->supabaseKey,
                    'Authorization' => 'Bearer ' . $this->supabaseKey,
                    'Content-Type' => 'application/octet-stream'
                ])->withBody($fileResource, 'application/octet-stream')
                  ->put("{$this->storageUrl}/object/donation-reports/$fileName");

                fclose($fileResource);

                if ($upload->successful()) {
                    $publicUrl = "{$this->supabaseUrl}/storage/v1/object/public/donation-reports/$fileName";
                    $imageUrls[] = $publicUrl;
                }
            }
        }

        $data = [
            'campaign_id' => $request->campaign_id,
            'report_description' => $request->report_description,
            'report_image' => $imageUrls,
            'created_at' => now()->toIso8601String()
        ];

        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/json'
        ])->post("{$this->supabaseUrl}/rest/v1/donation_reports", $data);

        if (!$response->successful()) {
            return back()->with('error', 'Gagal menyimpan data report! ' . $response->body());
        }

        return redirect()->route('donation-reports.index')->with('success', 'Laporan donasi berhasil ditambahkan.');

    }


    public function edit($id)
    {
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey
        ])->get("{$this->supabaseUrl}/rest/v1/donation_reports?id=eq.$id");

        $report = $response->json()[0] ?? null;

        return view('donation-reports.edit', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'report_description' => 'required|string',
            'report_image.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'report_description' => $request->report_description
        ];

        if ($request->hasFile('report_image')) {
            $imageUrls = [];

            foreach ($request->file('report_image') as $image) {
                $fileName = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $fileResource = fopen($image->getRealPath(), 'r');

                $upload = Http::withHeaders([
                    'apikey' => $this->supabaseKey,
                    'Authorization' => 'Bearer ' . $this->supabaseKey,
                    'Content-Type' => 'application/octet-stream'
                ])->withBody($fileResource, 'application/octet-stream')
                  ->put("{$this->storageUrl}/object/donation-reports/$fileName");

                fclose($fileResource);

                if ($upload->successful()) {
                    $publicUrl = "{$this->supabaseUrl}/storage/v1/object/public/donation-reports/$fileName";
                    $imageUrls[] = $publicUrl;
                }
            }

            $data['report_image'] = $imageUrls;
        }

        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/json'
        ])->patch("{$this->supabaseUrl}/rest/v1/donation_reports?id=eq.$id", $data);

        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengupdate data report! ' . $response->body());
        }

        return redirect()->route('donation-reports.index')->with('success', 'Laporan donasi berhasil diupdate.');
    }

    public function destroy($id)
    {
        // Ambil laporan dari Supabase
        $report = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey
        ])->get("{$this->supabaseUrl}/rest/v1/donation_reports?id=eq.$id")->json();

        $report = $report[0] ?? null;

        if ($report) {
            // Cek apakah ada gambar
            if (!empty($report['report_image'])) {
                $filePaths = [];

                if (is_array($report['report_image'])) {
                    foreach ($report['report_image'] as $imgUrl) {
                        $filePath = parse_url($imgUrl, PHP_URL_PATH);
                        $fileName = str_replace('/storage/v1/object/public/donation-reports/', '', $filePath);
                        $filePaths[] = 'donation-reports/' . $fileName;
                    }
                } else {
                    $filePath = parse_url($report['report_image'], PHP_URL_PATH);
                    $fileName = str_replace('/storage/v1/object/public/donation-reports/', '', $filePath);
                    $filePaths[] = 'donation-reports/' . $fileName;
                }

                // Hapus gambar lewat Supabase Storage API
                $deleteImageResponse = Http::withHeaders([
                    'apikey' => $this->supabaseKey,
                    'Authorization' => 'Bearer ' . $this->supabaseKey,
                    'Content-Type' => 'application/json'
                ])->post("{$this->storageUrl}/object/donation-reports/delete", [
                    'prefixes' => $filePaths
                ]);

                if (!$deleteImageResponse->successful()) {
                    Log::error('Gagal menghapus gambar dari Supabase Storage: ' . $deleteImageResponse->body());
                    return back()->with('error', 'Gagal menghapus gambar laporan.');
                }
            }

            // Setelah hapus gambar, baru hapus data laporan
            $deleteReportResponse = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey
            ])->delete("{$this->supabaseUrl}/rest/v1/donation_reports?id=eq.$id");

            if (!$deleteReportResponse->successful()) {
                Log::error('Gagal menghapus laporan dari Supabase: ' . $deleteReportResponse->body());
                return back()->with('error', 'Gagal menghapus laporan donasi.');
            }

            return redirect()->route('donation-reports.index')->with('success', 'Laporan donasi berhasil dihapus.');
        }

        return back()->with('error', 'Laporan tidak ditemukan.');
    }
}
