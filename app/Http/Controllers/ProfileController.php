<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ProfileController extends Controller
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
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    public function index()
    {
        try {
            $response = $this->client->get("{$this->supabaseUrl}/rest/v1/profiles", [
                'query' => ['select' => 'id,full_name,phone,created_at']
            ]);

            $profiles = json_decode($response->getBody(), true);
            return view('profiles.index', compact('profiles'));
        } catch (RequestException $e) {
            return back()->withErrors(['error' => 'Gagal mengambil data profil: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        return view('profiles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        try {
            $response = $this->client->post("{$this->supabaseUrl}/rest/v1/profiles", [
                'json' => [
                    'full_name' => $request->full_name,
                    'phone' => $request->phone
                ]
            ]);

            return redirect()->route('profiles.index')->with('success', 'Profil berhasil ditambahkan!');
        } catch (RequestException $e) {
            return back()->withErrors(['error' => 'Gagal menambah profil: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $response = $this->client->get("{$this->supabaseUrl}/rest/v1/profiles", [
                'query' => ['id' => 'eq.' . $id, 'select' => 'id,full_name,phone']
            ]);

            $profiles = json_decode($response->getBody(), true);
            if (empty($profiles)) {
                return redirect()->route('profiles.index')->withErrors(['error' => 'Profil tidak ditemukan']);
            }

            return view('profiles.edit', ['profile' => $profiles[0]]);
        } catch (RequestException $e) {
            return back()->withErrors(['error' => 'Gagal mengambil data profil: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        try {
            $this->client->patch("{$this->supabaseUrl}/rest/v1/profiles", [
                'query' => ['id' => 'eq.' . $id],
                'json' => [
                    'full_name' => $request->full_name,
                    'phone' => $request->phone
                ]
            ]);

            return redirect()->route('profiles.index')->with('success', 'Profil berhasil diperbarui!');
        } catch (RequestException $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui profil: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->client->delete("{$this->supabaseUrl}/rest/v1/profiles", [
                'query' => ['id' => 'eq.' . $id]
            ]);

            return redirect()->route('profiles.index')->with('success', 'Profil berhasil dihapus!');
        } catch (RequestException $e) {
            return back()->withErrors(['error' => 'Gagal menghapus profil: ' . $e->getMessage()]);
        }
    }
}
