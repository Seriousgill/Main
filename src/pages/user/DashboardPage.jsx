import Button from '../../components/Button';
import Card from '../../components/Card';
import LineChartCard from '../../components/LineChartCard';
import StatCard from '../../components/StatCard';
import Table from '../../components/Table';
import { earningsData, referralRows, statsCards } from '../../data/mockData';

export default function DashboardPage() {
  return (
    <div className="space-y-6">
      <Card className="bg-gradient-to-r from-primary to-purpleEnd text-white">
        <h1 className="text-2xl font-bold">Welcome Back, Aryan 👋</h1>
        <p className="mt-2 text-white/90">Your network is growing faster this week. Keep momentum with tasks and referrals.</p>
      </Card>

      <Card title="Active Plan">
        <div className="grid gap-4 md:grid-cols-3"><p><b>Plan Name:</b> Gold</p><p><b>Daily Income:</b> ₹320</p><p><b>Expiry Countdown:</b> 37 days</p></div>
      </Card>

      <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">{statsCards.map((item) => <StatCard key={item.title} {...item} />)}</div>
      <div className="flex flex-wrap gap-3">
        <Button>Complete Task</Button><Button variant="success">Refer & Earn</Button><Button variant="gradient">Spin Lucky Wheel</Button><Button variant="danger">Withdraw</Button>
      </div>
      <LineChartCard title="Earnings Trend" data={earningsData} />
      <div><h2 className="mb-3 text-xl font-bold">Referral Table</h2><Table columns={['Name', 'Plan', 'Earnings', 'Date', 'Status']} rows={referralRows} /></div>
    </div>
  );
}
