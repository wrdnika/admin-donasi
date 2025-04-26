<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
            'report_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload gambar ke Supabase Storage
        $image = $request->file('report_image');
        $fileName = Str::uuid() . '.' . $image->getClientOriginalExtension();

        // Baca file sebagai resource stream daripada string
        $fileResource = fopen($image->getRealPath(), 'r');

        // Upload file ke Supabase Storage menggunakan stream
        $upload = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/octet-stream'
        ])->withBody($fileResource, 'application/octet-stream')
          ->put("{$this->storageUrl}/object/donation-reports/$fileName");

        // Tutup resource
        fclose($fileResource);

        if (!$upload->successful()) {
            return back()->with('error', 'Gagal upload gambar ke Supabase Storage!');
        }

        // Perbaiki URL public gambarnya
        $publicUrl = "{$this->supabaseUrl}/storage/v1/object/public/donation-reports/$fileName";

        // Buat array data
        $data = [
            'campaign_id' => $request->campaign_id,
            'report_description' => $request->report_description,
            'report_image' => $publicUrl,
            'created_at' => now()->toIso8601String()
        ];

        // Gunakan opsi JSON_UNESCAPED_UNICODE dan JSON_UNESCAPED_SLASHES
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
            'report_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = [
            'report_description' => $request->report_description
        ];

        if ($request->hasFile('report_image')) {
            $image = $request->file('report_image');
            $fileName = Str::uuid() . '.' . $image->getClientOriginalExtension();

            $fileResource = fopen($image->getRealPath(), 'r');

            $upload = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Content-Type' => 'application/octet-stream'
            ])->withBody($fileResource, 'application/octet-stream')
              ->put("{$this->storageUrl}/object/donation-reports/$fileName");

            fclose($fileResource);

            if (!$upload->successful()) {
                return back()->with('error', 'Gagal upload gambar ke Supabase Storage!');
            }

            // Perbaiki URL public gambar
            $publicUrl = "{$this->supabaseUrl}/storage/v1/object/public/donation-reports/$fileName";
            $data['report_image'] = $publicUrl;
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
        // Get laporan dulu buat dapetin file gambar (optional)
        $report = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey
        ])->get("{$this->supabaseUrl}/rest/v1/donation_reports?id=eq.$id")->json();

        $report = $report[0] ?? null;

        if ($report) {
            // Ambil nama file dari URL gambar
            $filePath = parse_url($report['report_image'], PHP_URL_PATH);
            $fileName = basename($filePath);

            // Delete file di storage Supabase
            Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Content-Type' => 'application/json'
            ])->post("{$this->storageUrl}/object/donation-reports/$fileName");
        }

        // Delete data dari table
        Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey
        ])->delete("{$this->supabaseUrl}/rest/v1/donation_reports?id=eq.$id");

        return redirect()->route('donation-reports.index')->with('success', 'Laporan donasi berhasil dihapus.');
    }
}
