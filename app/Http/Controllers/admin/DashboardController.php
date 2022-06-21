<?php

namespace App\Http\Controllers\admin;

use App\Models\Travel;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request){
        return view('pages.admin.dashboard', [
            'travel' => Travel::count(),
            'transaction' => Transaction::count(),
            'transaction_pending' => Transaction::where('transaction_status', 'PENDING')->count(),
            'transaction_success' => Transaction::where('transaction_status', 'SUCCESS')->count()
        ]);
    }
}
