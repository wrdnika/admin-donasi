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
            'campaign_id'       => 'required|uuid',
            'report_description'=> 'required|string',
            'report_image.*'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'report_pdf'        => 'nullable|file|mimes:pdf|max:5120',
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

        $pdfUrl = null;
        if ($request->hasFile('report_pdf')) {
            $pdf      = $request->file('report_pdf');
            $fileName = Str::uuid() . '.pdf';
            $resource = fopen($pdf->getRealPath(), 'r');
            $upload   = Http::withHeaders([
                'apikey'        => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Content-Type'  => 'application/octet-stream',
            ])->withBody($resource, 'application/octet-stream')
            ->put("{$this->storageUrl}/object/donation-reports-pdfs/{$fileName}");
            fclose($resource);

            if ($upload->successful()) {
                $pdfUrl = "{$this->supabaseUrl}/storage/v1/object/public/donation-reports-pdfs/{$fileName}";
            }
        }

        $data = [
            'campaign_id'       => $request->campaign_id,
            'report_description'=> $request->report_description,
            'report_image'      => $imageUrls,
            'report_pdf'        => $pdfUrl,
            'created_at'        => now()->toIso8601String(),
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
            'report_pdf'        => 'nullable|file|mimes:pdf|max:5120',
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

        if ($request->hasFile('report_pdf')) {
            // (opsi: Anda bisa menghapus PDF lama di bucket dulu jika ada)
            $pdf      = $request->file('report_pdf');
            $fileName = Str::uuid() . '.pdf';
            $resource = fopen($pdf->getRealPath(), 'r');
            Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Content-Type' => 'application/json'
                ])->withBody($resource, 'application/octet-stream')
                ->put("{$this->storageUrl}/object/donation-reports-pdfs/{$fileName}");
            fclose($resource);

            $data['report_pdf'] = "{$this->supabaseUrl}/storage/v1/object/public/donation-reports-pdfs/{$fileName}";
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
        // Ambil laporan
        $res = Http::withHeaders([
            'apikey'        => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Accept'        => 'application/json',
        ])->get("{$this->supabaseUrl}/rest/v1/donation_reports?id=eq.$id");

        if (! $res->successful()) {
            Log::error("Gagal fetch report: {$res->status()} – {$res->body()}");
            return back()->with('error', 'Gagal mengambil data laporan.');
        }

        $report = $res->json()[0] ?? null;
        if (! $report) {
            return back()->with('error', 'Laporan tidak ditemukan.');
        }

        // Hapus setiap gambar satu per satu
        if (! empty($report['report_image'])) {
            $images = is_array($report['report_image'])
                ? $report['report_image']
                : [ $report['report_image'] ];

            foreach ($images as $imgUrl) {
                $path     = parse_url($imgUrl, PHP_URL_PATH);
                $fileName = str_replace('/storage/v1/object/public/donation-reports/', '', $path);

                $delImg = Http::withHeaders([
                    'apikey'        => $this->supabaseKey,
                    'Authorization' => 'Bearer ' . $this->supabaseKey,
                    'Accept'        => 'application/json',
                ])->delete("{$this->storageUrl}/object/donation-reports/{$fileName}");

                if (! $delImg->successful()) {
                    Log::error("Gagal hapus gambar {$fileName}: {$delImg->status()} – {$delImg->body()}");
                    // kita lanjutkan, karena mungkin file sudah terhapus
                }
            }
        }

        // Hapus PDF jika ada
        if (! empty($report['report_pdf'])) {
            $path     = parse_url($report['report_pdf'], PHP_URL_PATH);
            $fileName = str_replace('/storage/v1/object/public/donation-reports-pdfs/', '', $path);

            $delPdf = Http::withHeaders([
                'apikey'        => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Accept'        => 'application/json',
            ])->delete("{$this->storageUrl}/object/donation-reports-pdfs/{$fileName}");

            if (! $delPdf->successful()) {
                Log::error("Gagal hapus PDF {$fileName}: {$delPdf->status()} – {$delPdf->body()}");
            }
        }

        // Hapus record di Supabase
        $delRep = Http::withHeaders([
            'apikey'        => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Accept'        => 'application/json',
        ])->delete("{$this->supabaseUrl}/rest/v1/donation_reports?id=eq.$id");

        if (! $delRep->successful()) {
            Log::error("Gagal hapus report: {$delRep->status()} – {$delRep->body()}");
            return back()->with('error', 'Gagal menghapus laporan donasi.');
        }

        return redirect()
            ->route('donation-reports.index')
            ->with('success', 'Laporan donasi berhasil dihapus.');
    }
}
