import Link from 'next/link';
import { apiGet } from '@/lib/api';

export default async function EventDetailPage({ params }: { params: { id: string } }) {
  const event = await apiGet<any>(`/events/${params.id}`);

  return (
    <div className="space-y-4">
      <h1 className="text-3xl font-bold">{event.title}</h1>
      <p className="text-slate-600">{event.city} • {event.event_date} • {event.event_time}</p>
      <p>{event.description}</p>

      <div className="bg-white border rounded p-4">
        <h2 className="font-semibold mb-2">Ticket Types</h2>
        <ul className="space-y-2">
          {event.ticket_types?.map((ticket: any) => (
            <li key={ticket.id} className="flex items-center justify-between">
              <span>{ticket.name}</span>
              <span>₹{ticket.price}</span>
            </li>
          ))}
        </ul>
        <Link href={`/checkout/new?eventId=${event.id}`} className="mt-4 inline-block bg-cyan-600 text-white px-4 py-2 rounded">
          Book Now
        </Link>
      </div>
    </div>
  );
}
