<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminEventController extends Controller
{
    public function index(): View
    {
        return view('admin.events.index', ['events' => Event::query()->with('organizer')->latest()->paginate(20)]);
    }

    public function updateStatus(Request $request, Event $event): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', 'in:pending,approved,rejected']]);
        $event->update(['status' => $data['status']]);
        return back()->with('status', 'Event status updated.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();
        return back()->with('status', 'Event deleted.');
    }
}
