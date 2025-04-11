<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CampaignController extends Controller
{
    protected $client;
    protected $supabaseUrl;
    protected $supabaseApiKey;

    public function __construct()
    {
        $this->supabaseUrl = config('supabase.url');
        $this->supabaseApiKey = config('supabase.api_key');
        $this->client = new Client([
            'headers' => [
                'apikey' => $this->supabaseApiKey,
                'Authorization' => "Bearer {$this->supabaseApiKey}",
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    public function index()
    {
        try {
            $response = $this->client->get("{$this->supabaseUrl}/rest/v1/campaigns", [
                'query' => ['select' => '*']
            ]);

            $campaigns = json_decode($response->getBody(), true);
            return view('campaigns.index', compact('campaigns'));
        } catch (RequestException $e) {
            return back()->withErrors(['error' => 'Gagal mengambil data campaign.']);
        }
    }

    public function create()
    {
        return view('campaigns.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric',
        ]);

        try {
            $response = $this->client->post("{$this->supabaseUrl}/rest/v1/campaigns", [
                'json' => [
                    'id' => (string) \Illuminate\Support\Str::uuid(),
                    'title' => $request->title,
                    'description' => $request->description,
                    'goal_amount' => $request->goal_amount,
                    'collected_amount' => 0,
                    'created_at' => now()->toIso8601String(),
                ]
            ]);

            return redirect()->route('campaigns.index')->with('success', 'Campaign berhasil ditambahkan.');
        } catch (RequestException $e) {
            return back()->withErrors(['error' => 'Gagal menambahkan campaign.']);
        }
    }

    public function edit($id)
    {
        try {
            $response = $this->client->get("{$this->supabaseUrl}/rest/v1/campaigns", [
                'query' => ['id' => 'eq.' . $id]
            ]);

            $campaigns = json_decode($response->getBody(), true);
            $campaign = $campaigns[0] ?? null;

            if (!$campaign) {
                return back()->withErrors(['error' => 'Campaign tidak ditemukan.']);
            }

            return view('campaigns.edit', compact('campaign'));
        } catch (RequestException $e) {
            return back()->withErrors(['error' => 'Gagal mengambil data campaign.']);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric',
        ]);

        try {
            $this->client->patch("{$this->supabaseUrl}/rest/v1/campaigns?id=eq.{$id}", [
                'json' => [
                    'title' => $request->title,
                    'description' => $request->description,
                    'goal_amount' => $request->goal_amount,
                ]
            ]);

            return redirect()->route('campaigns.index')->with('success', 'Campaign berhasil diperbarui.');
        } catch (RequestException $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui campaign.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->client->delete("{$this->supabaseUrl}/rest/v1/campaigns?id=eq.{$id}");

            return redirect()->route('campaigns.index')->with('success', 'Campaign berhasil dihapus.');
        } catch (RequestException $e) {
            return back()->withErrors(['error' => 'Gagal menghapus campaign.']);
        }
    }
}
