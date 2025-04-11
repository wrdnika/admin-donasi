<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AuthController extends Controller
{
    protected $supabaseUrl;
    protected $supabaseApiKey;

    public function __construct()
    {
        $this->supabaseUrl = config('supabase.url');
        $this->supabaseApiKey = config('supabase.api_key');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            $client = new Client();
            $response = $client->post("{$this->supabaseUrl}/auth/v1/token?grant_type=password", [
                'headers' => [
                    'apikey' => $this->supabaseApiKey,
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'email' => $request->email,
                    'password' => $request->password
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if (!isset($data['access_token'])) {
                return back()->withErrors(['login' => 'Login gagal: ' . json_encode($data)]);
            }

            // Simpan token yang benar
            Session::put('token', $data['access_token']);
            Session::put('user', $data['user']);

            return redirect()->route('campaigns.index');
        } catch (RequestException $e) {
            return back()->withErrors(['login' => 'Login gagal: ' . $e->getMessage()]);
        }
    }

    public function logout()
    {
        Session::forget('token');
        Session::forget('user');
        return redirect()->route('login');
    }
}
