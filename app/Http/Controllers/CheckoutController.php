<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Travel;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Request $request, $id)
    {
        $item = Transaction::with(['details', 'travel', 'user'])->findOrFail($id);
        return view('pages.checkout', [
            'item' => $item
        ]);
    }

    public function process(Request $request, $id)
    {
        $travel = Travel::findOrFail($id);
        $transaction = Transaction::create([
            'travel_id' => $id,
            'user_id' => Auth::user()->id,
            'additional_visa' => 0,
            'transaction_total' => $travel->price,
            'transaction_status' => 'IN_CART'
        ]);

        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'username' => Auth::user()->username,
            'nationality' => 'ID',
            'is_visa' => false,
            'doe_passport' => Carbon::now()->addYears(5),
        ]);

        return redirect()->route('checkout', $transaction->id);
    }

    public function remove(Request $request, $detail_id)
    {
        $item = TransactionDetail::findOrFail($detail_id);

        $transaction = Transaction::with(['details', 'travel'])->findOrFail($item->transaction_id);

        if($item->is_visa){
            $transaction->transaction_total -= 190;
            // $transaction->transaction_total = $transaction->transaction_total + 190;
            $transaction->additional_visa -= 190;
        }
        $transaction->transaction_total -= $transaction->travel->price;

        $transaction->save();
        $item->delete();

        return redirect()->route('checkout', $item->transaction_id);

    }

    public function create(Request $request, $id)
    { 
        $request->validate([
            'username' => 'required|string|exists:users,username',
            'is_visa' => 'required|boolean',
            'doe_passport' => 'required'
        ]);

        $data = $request->all();
        $data['transaction_id'] = $id;

        TransactionDetail::create($data);

        $transaction = Transaction::with(['travel'])->find($id);

        if($request->is_visa){
            $transaction->transaction_total += 190;
            // $transaction->transaction_total = $transaction->transaction_total + 190;
            $transaction->additional_visa += 190;
        }
        $transaction->transaction_total += $transaction->travel->price;

        $transaction->save();

        return redirect()->route('checkout', $item->transactions_id);


    }

    public function success(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->transaction_status = 'PENDING';

        $transaction->save();
        return view('pages.success');
    }
}
