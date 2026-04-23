<?php

namespace App\Repositories;

use App\Models\Booking;

class BookingRepository
{
    public function create(array $data): Booking
    {
        return Booking::query()->create($data);
    }

    public function findForUser(int $bookingId, int $userId): ?Booking
    {
        return Booking::query()->where('id', $bookingId)->where('user_id', $userId)->first();
    }
}
