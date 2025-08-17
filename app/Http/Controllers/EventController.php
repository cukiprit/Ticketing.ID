<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('layoutLokasi')->has('layoutLokasi')->get();

        // dd($layouts);
        return view('event.index', compact('events'));
    }

    public function show($id)
    {
        $event = Event::with('layoutLokasi')->findOrFail($id);

        return view('event.show', compact('event'));
    }
}
