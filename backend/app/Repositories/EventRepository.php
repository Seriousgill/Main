<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EventRepository
{
    public function approvedPaginated(int $perPage = 12): LengthAwarePaginator
    {
        return Event::query()
            ->where('status', 'approved')
            ->with('ticketTypes')
            ->orderBy('event_date')
            ->paginate($perPage);
    }

    public function create(array $data): Event
    {
        return Event::query()->create($data);
    }
}
