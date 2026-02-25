import Card from './Card';

export default function StatCard({ title, value }) {
  return (
    <Card className="p-4">
      <p className="text-sm text-textSecondary">{title}</p>
      <p className="mt-2 text-2xl font-bold text-textPrimary">{value}</p>
    </Card>
  );
}
