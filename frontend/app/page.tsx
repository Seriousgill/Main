import EventCard from '@/components/EventCard';
import { apiGet } from '@/lib/api';

export default async function HomePage() {
  const data = await apiGet<{ data: any[] }>('/events');

  return (
    <section>
      <h1 className="text-2xl font-bold mb-4">Upcoming Events</h1>
      <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        {data.data.map((event) => (
          <EventCard key={event.id} event={event} />
        ))}
      </div>
    </section>
  );
}
