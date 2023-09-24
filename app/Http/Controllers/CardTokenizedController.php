<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use App\Models\CardTokenized;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardExpirationDate;
use LVR\CreditCard\CardNumber;
use Illuminate\Support\Str;

class CardTokenizedController extends Controller
{
    public function get(CardTokenized $cardTokenized) : array {
        return $cardTokenized->only(['id', 'number_label', 'franchise']);
    }

    public function store(Request $request) : \Illuminate\Http\JsonResponse {
        $request->validate([
            'holder' => ['required', 'string', 'max:80'],
            'number' => ['required', new CardNumber],
            'datetime' => ['required', new CardExpirationDate('my')],
            'cvv' => ['required', new CardCvc($request->get('card_number'))],
        ]);

        $card = config('cards')->where('number_2', $request->number)->where('cvv', $request->cvv)->first();
        if ($card && $card['status'] === TransactionStatus::Approved->value) {
            $key = Encrypter::generateKey('aes-128-cbc');
            $crypt = new Encrypter($key);

            $cardTokenized = new CardTokenized([
                'holder' => $crypt->encryptString($request->holder),
                'number' => $crypt->encryptString($request->number),
                'datetime' => $crypt->encryptString($request->datetime),
                'cvv' => $crypt->encryptString($request->cvv)
            ]);

            $cardTokenized->franchise = $card['card_network'];
            $cardTokenized->number_label = Str::mask($request->number, '*', 0, 12);

            $cardTokenized->save();
        } else {
            throw new \Exception("Error Processing Card. Network response a error with the card", 1);
        }

        return response()->json([
            'saved' => true,
            'token' => $key,
            'card' => $cardTokenized->only(['id', 'number_label', 'franchise'])
        ]);

    }

    public function destroy(CardTokenized $cardTokenized) : \Illuminate\Http\JsonResponse {
        $cardTokenized->delete();

        return response()->json([
            'deleted' => true
        ]);
    }
}
