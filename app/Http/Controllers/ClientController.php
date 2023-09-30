<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function get(Request $request, Client $client = null) {
        if (!$client) {
            return Client::where('user_id', $request->user()->id)->paginate();
        } else {
            return $client;
        }
    }

    public function store(Request $request) : \Illuminate\Http\JsonResponse {
        $request->validate([
            'name' => ['required', 'string', 'between:2,100'],
            'email' => ['required', 'email'],
            'identification_type' => ['required', 'string', 'between:2,25'],
            'identification_number' => ['required', 'numeric'],
            'number_phone' => ['required', 'numeric'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
        ]);

        $client = new Client($request->all());
        $client->user()->associate($request->user());
        $client->save();

        return response()->json([
            'saved' => true,
            'client' => $client
        ]);
    }

    function update(Request $request, Client $client) : \Illuminate\Http\JsonResponse {
        abort_if(!is_null($client->transaction), 402, 'This client has already been associated with a transaction, you wont update clients with transaction associated, please create other');

        $request->validate([
            'name' => ['required', 'string', 'between:2,100'],
            'email' => ['required', 'email'],
            'identification_type' => ['required', 'string', 'between:2,25'],
            'identification_number' => ['required', 'numeric'],
            'number_phone' => ['required', 'numeric'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
        ]);

        $client->update($request->all());

        return response()->json([
            'updated' => true,
            'client' => $client
        ]);
    }

    function destroy(Client $client) : \Illuminate\Http\JsonResponse {
        abort_if(!is_null($client->transaction), 402, 'This client has already been associated with a transaction, you wont delete clients with transaction associated');

        $client->delete();
        return response()->json([
            'deleted' => true,
        ]);
    }
}
