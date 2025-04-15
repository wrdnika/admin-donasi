<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SupabaseService;

class LogsTransactionController extends Controller
{
    protected $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    public function index()
    {
        $data = $this->supabase->getData('logs_transactions_view');
        $transactions = is_array($data) ? $data : [];

        return view('logs-transactions.index', compact('transactions'));
    }
}
