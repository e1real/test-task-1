<?php

namespace App\Http\Controllers;

use App\CfChords;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CfChordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $chords = CfChords::query()->paginate(10);

        return response()->json($chords);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View|Factory
     */
    public function create()
    {
        return $this->renderVue('chords-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'chords' => 'required',
        ]);

        $chord = new CfChords();
        $chord->fill($request->all());
        $chord->save();

        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param CfChords $cfChords
     * @return Response
     */
    public function show(CfChords $cfChords)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CfChords $cfChord
     * @return View|Factory
     */
    public function edit(CfChords $cfChord)
    {
        return $this->renderVue('chords-edit', compact('cfChord'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param CfChords $cfChord
     * @return JsonResponse
     */
    public function update(Request $request, CfChords $cfChord): JsonResponse
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'chords' => 'required',
        ]);
        $cfChord->update($request->all());

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CfChords $cfChord
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(CfChords $cfChord): JsonResponse
    {
        $cfChord->delete();

        return response()->json();
    }
}
