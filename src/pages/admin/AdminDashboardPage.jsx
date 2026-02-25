import LineChartCard from '../../components/LineChartCard';
import StatCard from '../../components/StatCard';
import { adminRevenue, adminStats } from '../../data/mockData';

export default function AdminDashboardPage() {
  return (
    <div className="space-y-6">
      <div className="grid gap-4 md:grid-cols-3">{adminStats.map((stat) => <StatCard key={stat.title} {...stat} />)}</div>
      <LineChartCard title="Revenue Chart" data={adminRevenue} xKey="month" yKey="revenue" />
    </div>
  );
}
