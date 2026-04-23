'use client';

import { useEffect, useState } from 'react';

export default function DashboardPage() {
  const [bookings, setBookings] = useState<any[]>([]);

  useEffect(() => {
    const token = localStorage.getItem('token');
    fetch(`${process.env.NEXT_PUBLIC_API_BASE || 'http://localhost:8000/api'}/bookings`, {
      headers: token ? { Authorization: `Bearer ${token}` } : {},
    })
      .then((response) => response.json())
      .then((data) => setBookings(data.data || []));
  }, []);

  return (
    <section>
      <h1 className="text-2xl font-bold mb-4">My Bookings</h1>
      <div className="space-y-3">
        {bookings.map((booking) => (
          <div key={booking.id} className="bg-white border rounded p-4">
            <p className="font-semibold">#{booking.id} - {booking.status}</p>
            <p className="text-sm">{booking.event?.title}</p>
            <p className="text-sm text-slate-600">₹{booking.total_amount}</p>
          </div>
        ))}
      </div>
    </section>
  );
}
