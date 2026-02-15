import { useEffect, useState } from 'react';
import api from '../../api/client';

export default function AdminDashboardPage() {
  const [stats, setStats] = useState(null);
  useEffect(() => { api.get('/admin/dashboard').then((res) => setStats(res.data)); }, []);
  if (!stats) return <p>Loading...</p>;
  return <div className="space-y-3">
    <h2 className="text-2xl font-semibold">Admin Dashboard</h2>
    <div className="grid md:grid-cols-3 gap-3">
      <Box title="Total Users" value={stats.users.totalUsers} />
      <Box title="Active Users" value={stats.users.activeUsers} />
      <Box title="Pending Withdrawals" value={stats.withdrawals.pendingWithdrawals} />
    </div>
  </div>;
}

const Box = ({ title, value }) => <div className="p-4 bg-white rounded shadow"><p>{title}</p><p className="text-2xl font-bold">{value}</p></div>;
