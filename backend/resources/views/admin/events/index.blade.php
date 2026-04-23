@extends('admin.layouts.app')

@section('content')
<h2 class="text-xl font-semibold mb-4">Event Management</h2>
@foreach($events as $event)
<div class="bg-slate-900 p-4 rounded mb-3">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="font-semibold">{{ $event->title }}</h3>
            <p class="text-sm text-slate-400">{{ $event->city }} • {{ $event->event_date }}</p>
            <p class="text-xs">Organizer: {{ $event->organizer->name }}</p>
        </div>
        <div class="flex gap-2">
            <form method="POST" action="{{ route('admin.events.status', $event) }}">@csrf @method('PATCH')
                <input type="hidden" name="status" value="approved" />
                <button class="px-3 py-1 bg-emerald-700 rounded">Approve</button>
            </form>
            <form method="POST" action="{{ route('admin.events.status', $event) }}">@csrf @method('PATCH')
                <input type="hidden" name="status" value="rejected" />
                <button class="px-3 py-1 bg-yellow-700 rounded">Reject</button>
            </form>
            <form method="POST" action="{{ route('admin.events.destroy', $event) }}">@csrf @method('DELETE')
                <button class="px-3 py-1 bg-rose-700 rounded">Delete</button>
            </form>
        </div>
    </div>
</div>
@endforeach
{{ $events->links() }}
@endsection
