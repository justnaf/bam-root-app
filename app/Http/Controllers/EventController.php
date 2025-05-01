<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ModelRequestEvent;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with(['modelRequestEvent' => function ($query) {
            $query->where('status', 'pending');
        }])->orderBy('created_at', 'desc')->get();

        return view('events.index', compact('events'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModelRequestEvent $event)
    {
        $submission = $event;
        $event = Event::find($submission->event_id);
        if ($request->status == 'approved') {
            $submission->status = 'approved';
            if ($submission->save()) {
                $event->status = 'preparation';
                $event->save();
                return redirect()->route('events.index')->with('success', 'Pengajuan Disetujui.');
            } else {
                return redirect()->route('events.index')->with('warning', 'Ada Sesuatu Yang Salah.');
            }
        } elseif ($request->status == 'declined') {
            $submission->status = 'declined';
            if ($submission->save()) {
                $event->status = 'draft';
                $event->save();
                return redirect()->route('events.index')->with('success', 'Pengajuan DiTolak.');
            } else {
                return redirect()->route('events.index')->with('warning', 'Ada Sesuatu Yang Salah.');
            }
        }
        return redirect()->route('events.index')->with('error', 'Ada Sesuatu Yang Salah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event Deleted successfully.');
    }

    public function submissionEvent()
    {
        $events = Event::whereHas('modelRequestEvent', function ($query) {
            $query->where('status', 'pending');
        })->with(['modelRequestEvent' => function ($query) {
            $query->where('status', 'pending');
        }])->where('status', 'submission')->get();

        return view('events.submission.index', compact('events'));
    }
}
