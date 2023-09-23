<?php

namespace App\Http\Controllers;

use App\Enums\TransactionCurrency;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function get(Transaction $transaction) : Transaction {
        return $transaction;
    }

    public function store(Request $request) : \Illuminate\Http\JsonResponse {
        $request->validate([
            'amount' => ['required', 'numeric'],
            'description' => ['required', 'string', 'max:150'],
            'currency' => ['required', Rule::in(array_column(TransactionCurrency::cases(), 'value'))],
            'payment_method' => ['required', Rule::in(array_column(TransactionCurrency::cases(), 'value'))],
            'reference_1' => ['required', 'string', 'max:150'],
            'reference_2' => ['nullable', 'string', 'max:150'],
            'reference_3' => ['nullable', 'string', 'max:150'],
            'client_id' => ['required', Rule::exists('clients', 'id')]
        ]);

        $transaction = new Transaction($request->all());
        $transaction->client($request->client_id);
        $transaction->user($request->user());
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
            'payment_method' => ['required', Rule::in(array_column(TransactionCurrency::cases(), 'value'))],
            'reference_1' => ['required', 'string', 'max:150'],
            'reference_2' => ['nullable', 'string', 'max:150'],
            'reference_3' => ['nullable', 'string', 'max:150'],
            'client_id' => ['required', Rule::exists('clients', 'id')]
        ]);

        $transaction->client($request->client_id);
        $transaction->update($request->all());

        return response()->json([
            'updated' => true,
            'transaction' => $transaction
        ]);
    }
}
