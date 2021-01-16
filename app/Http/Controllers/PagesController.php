<?php

namespace App\Http\Controllers;

use App\CfChords;

class PagesController extends Controller
{
    /**
     * Chords list crud
     */
    public function chords()
    {
        $chords = CfChords::all();

        return $this->renderVue('chords-index', compact('chords'));
    }
}
