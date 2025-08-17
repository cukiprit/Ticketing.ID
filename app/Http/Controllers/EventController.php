<?php

namespace App\Http\Controllers;

use App\Models\LayoutLokasi;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $layouts = LayoutLokasi::with('event')->whereHas('event')->get();

        // dd($layouts);
        return view('event.index', compact('layouts'));
    }

    public function show($id)
    {
        $layout = LayoutLokasi::with('event')->findOrFail($id);

        return view('event.show', [
            'layout' => $layout,
            'layoutLokasi' => $layout->layout_tenant
        ]);
    }
}
