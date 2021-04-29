<?php

namespace App\Http\Controllers;

use App\Panel;
use Illuminate\Http\Request;

class PtiController extends Controller
{
    public function painel(Request $request)
    {
        $panel = Panel::where('hash', $request->hash)->first();
        //$screens =$panel->screen()->get()->pluck('url');
        return view('panel', compact('panel'));
    }

    public function show(Request $request){
        $screens = Panel::where('hash', $request->hash)->first()
        ->screen()
        ->orderBy('number','ASC')
        ->get()->pluck('url');

        return response()->json([
            'screens' => $screens
        ]);
    }
}
