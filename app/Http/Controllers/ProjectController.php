<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index() : \Inertia\Response {
        return Inertia::render('Project', [
            'tokens' => auth()->user()->tokens
        ]);
    }

    public function store(Request $request) : \Inertia\Response {
        $request->validate([
            'name' => ['required', 'string', 'between:5,190']
        ]);

        $token = $request->user()->createToken($request->name);

        return Inertia::render('Project', [
            'generatedToken' => $token->plainTextToken,
            'tokens' => auth()->user()->tokens
        ]);
    }

    public function destroy(Request $request, $tokenId) : \Illuminate\Http\RedirectResponse {
        $request->user()->tokens()->where('id', $tokenId)->delete();

        return redirect()->back();
    }
}
