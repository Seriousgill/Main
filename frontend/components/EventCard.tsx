import Link from 'next/link';

type EventCardProps = {
  event: {
    id: number;
    title: string;
    city: string;
    event_date: string;
    banner_image?: string;
  };
};

export default function EventCard({ event }: EventCardProps) {
  return (
    <Link href={`/events/${event.id}`} className="bg-white border rounded-lg overflow-hidden hover:shadow-md transition">
      <div className="h-40 bg-slate-200" style={{ backgroundImage: `url(${event.banner_image || ''})`, backgroundSize: 'cover' }} />
      <div className="p-4">
        <h3 className="font-semibold">{event.title}</h3>
        <p className="text-sm text-slate-600">{event.city}</p>
        <p className="text-xs text-slate-500">{event.event_date}</p>
      </div>
    </Link>
  );
}
