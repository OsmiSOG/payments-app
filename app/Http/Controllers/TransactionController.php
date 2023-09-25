<?php

namespace App\Http\Controllers;

use App\Enums\TransactionCurrency;
use App\Enums\TransactionMethods;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index($filter = null) : \Inertia\Response {
        $transactions = Transaction::where('user_id', auth()->user()->id);
        if ($filter) {
            $transactions->where('id', 'like', "%$filter%")
                ->orWhere('status', 'like', "%$filter%")
                ->orWhere('amount', 'like', "%$filter%")
                ->orWhere('description', 'like', "%$filter%")
                ->orWhere('payment_method', 'like', "%$filter%")
                ->orWhere('reference_1', 'like', "%$filter%");
        }

        $transactions = $transactions->paginate();

        return Inertia::render('Transaction', [
            'transactions' => $transactions
        ]);
    }

    public function get(Transaction $transaction) : Transaction {
        abort_if($transaction->user_id !== auth()->user()->id, 404);
        return $transaction;
    }

    public function store(Request $request) : \Illuminate\Http\JsonResponse {
        $request->validate([
            'amount' => ['required', 'numeric'],
            'description' => ['required', 'string', 'max:150'],
            'currency' => ['required', Rule::in(array_column(TransactionCurrency::cases(), 'value'))],
            'payment_method' => ['required', Rule::in(array_column(TransactionMethods::cases(), 'value'))],
            'reference_1' => ['required', 'string', 'max:150'],
            'reference_2' => ['nullable', 'string', 'max:150'],
            'reference_3' => ['nullable', 'string', 'max:150'],
            'client_id' => ['required', Rule::exists('clients', 'id')]
        ]);

        $transaction = new Transaction($request->all());
        $transaction->status_at = Carbon::now();
        $transaction->installments = 0;
        $transaction->client()->associate($request->client_id);
        $transaction->user()->associate($request->user());
        $transaction->save();

        return response()->json([
            'saved' => true,
            'transaction' => $transaction
        ]);
    }

    public function update(Request $request, Transaction $transaction) : \Illuminate\Http\JsonResponse {
        abort_if($transaction->resolved, 402, 'You wont able to do this, this transaction has already been resolved');

        $request->validate([
            'amount' => ['required', 'numeric'],
            'description' => ['required', 'string', 'max:150'],
            'currency' => ['required', Rule::in(array_column(TransactionCurrency::cases(), 'value'))],
            'payment_method' => ['required', Rule::in(array_column(TransactionMethods::cases(), 'value'))],
            'reference_1' => ['required', 'string', 'max:150'],
            'reference_2' => ['nullable', 'string', 'max:150'],
            'reference_3' => ['nullable', 'string', 'max:150'],
            'client_id' => ['required', Rule::exists('clients', 'id')->whereNull('deleted_at')]
        ]);
        $transaction->client()->associate($request->client_id);
        $transaction->update($request->all());

        return response()->json([
            'updated' => true,
            'transaction' => $transaction
        ]);
    }
}
