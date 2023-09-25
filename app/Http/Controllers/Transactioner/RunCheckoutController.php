<?php

namespace App\Http\Controllers\Transactioner;

use App\Enums\TransactionStatus;
use App\Http\Controllers\Controller;
use App\Models\CardTokenized;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardExpirationDate;
use LVR\CreditCard\CardNumber;
use Illuminate\Support\Str;

class RunCheckoutController extends Controller
{
    public function normalPayment(Request $request) : \Illuminate\Http\JsonResponse {
        $request->validate([
            'transaction_id' => ['required', Rule::exists('transactions', 'id')->where('resolved', false)],
            'holder' => ['required', 'string', 'max:80'],
            'number' => ['required', new CardNumber],
            'datetime' => ['required', new CardExpirationDate('my')],
            'cvv' => ['required', new CardCvc($request->get('number'))],
            'installments' => ['required', 'integer'],
        ]);

        $transaction = Transaction::find($request->transaction_id);
        if ($card = collect(config('cards'))->where('number_2', $request->number)->where('cvv', $request->cvv)->first()) {
            $transaction->network = $card['card_network'];
            $transaction->status = $card['status'];
        } else {
            $transaction->network = '';
            $transaction->status = TransactionStatus::Failed->value;
        }

        $transaction->card_label = Str::mask($request->number, '*', 0, 12);
        $transaction->installments = $request->installments;
        $transaction->status_at = Carbon::now();
        $transaction->resolved = true;
        $transaction->update();

        return response()->json([
            'request_status' => true,
            'transaction' => $transaction
        ]);
    }

    public function tokenizedPayment(Request $request) : \Illuminate\Http\JsonResponse {
        $request->validate([
            'transaction_id' => ['required', Rule::exists('transactions', 'id')->where('resolved', false)],
            'card_tokenized_id' => ['required', Rule::exists('card_tokenizeds', 'id')],
            'card_token' => ['required', 'string'],
            'installments' => ['required', 'integer'],
        ]);

        $tokenized = CardTokenized::find($request->card_tokenized_id);

        $transaction = Transaction::find($request->transaction_id);
        $transaction->network = $tokenized->franchise;
        $transaction->status = TransactionStatus::Approved->value;
        $transaction->card_label = $tokenized->number_label;
        $transaction->installments = $request->installments;
        $transaction->status_at = Carbon::now();
        $transaction->resolved = true;
        $transaction->update();

        return response()->json([
            'request_status' => true,
            'transaction' => $transaction
        ]);
    }
}
