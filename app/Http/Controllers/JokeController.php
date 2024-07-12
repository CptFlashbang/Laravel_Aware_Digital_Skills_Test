<?php

namespace App\Http\Controllers;

use App\Models\Joke;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

class JokeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('jokes.index', [
            'jokes' => Joke::with('user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $request->user()->jokes()->create($validated);
 
        return redirect(route('jokes.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Joke $joke)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Joke $joke): View
    {
        Gate::authorize('update', $joke);
        return view('jokes.edit', [
            'joke' => $joke,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Joke $joke): RedirectResponse
    {
        Gate::authorize('update', $joke);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $joke->update($validated);
 
        return redirect(route('jokes.index'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Joke $joke)
    {
        Gate::authorize('delete', $joke);
 
        $joke->delete();
 
        return redirect(route('jokes.index'));
    }
    /**
     * Retrieve a joke from the API.
     */
     public function fetchJoke()
    {
        $response = Http::get('https://icanhazdadjoke.com/', [
            'Accept' => 'application/json'
        ]);

        return response()->json($response->json());
    }
}
