<?php

namespace App\Http\Controllers;

use App\Models\Boardgames;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoardgamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boardgames = Boardgames::latest()->orderBy('name')->paginate(500);
        session(['boardgames' => $boardgames]);

        return view('boardgames.index', compact('boardgames'))->with('i', (request()->input('page', 1) - 1) * 500);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('boardgames.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'negociation' => 'required',
            'owner' => 'required',
        ]);

        Boardgames::create($request->all());

        return redirect()->route('boardgames.index')
            ->with('success', 'Boardgame adicionado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Boardgames  $boardgames
     * @return \Illuminate\Http\Response
     */
    public function show(Boardgames $boardgame)
    {
        return view('boardgames.show', compact('boardgame'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Boardgames  $boardgames
     * @return \Illuminate\Http\Response
     */
    public function edit(Boardgames $boardgame)
    {
        return view('boardgames.edit', compact('boardgame'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Boardgames  $boardgames
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Boardgames $boardgame)
    {
        $request->validate([
            'name' => 'required',
            'negociation' => 'required',
            'owner' => 'required',
        ]);

        $boardgame->update($request->all());

        return redirect()->route('boardgames.index')
            ->with('success', 'Boardgame atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Boardgames  $boardgames
     * @return \Illuminate\Http\Response
     */
    public function destroy(Boardgames $boardgame)
    {
        $boardgame->delete();

        return redirect()->route('boardgames.index')
            ->with('success', 'Boardgame removido com sucesso.');
    }
}
