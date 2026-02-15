import { useEffect, useState } from 'react';
import { LineChart, Line, ResponsiveContainer, XAxis, YAxis, Tooltip } from 'recharts';
import api from '../../api/client';

export default function DashboardPage() {
  const [data, setData] = useState(null);
  useEffect(() => { api.get('/user/dashboard').then((res) => setData(res.data)); }, []);
  if (!data) return <p>Loading...</p>;

  const chartData = [
    { day: 'D-6', amount: 100 }, { day: 'D-5', amount: 140 }, { day: 'D-4', amount: 120 },
    { day: 'D-3', amount: 180 }, { day: 'D-2', amount: 220 }, { day: 'D-1', amount: 200 }, { day: 'Today', amount: data.todaysEarning }
  ];

  return <div className="space-y-4">
    <h1 className="text-2xl font-semibold">{data.welcome}</h1>
    <div className="grid md:grid-cols-4 gap-3">
      <Card title="Earning Wallet" value={`₹${data.wallet?.earningWallet || 0}`} />
      <Card title="Referral Wallet" value={`₹${data.wallet?.referralWallet || 0}`} />
      <Card title="Matching Wallet" value={`₹${data.wallet?.matchingWallet || 0}`} />
      <Card title="Today's Earning" value={`₹${data.todaysEarning || 0}`} />
    </div>
    <div className="bg-white p-4 rounded shadow h-64">
      <ResponsiveContainer width="100%" height="100%"><LineChart data={chartData}><XAxis dataKey="day" /><YAxis /><Tooltip /><Line dataKey="amount" stroke="#0f172a" /></LineChart></ResponsiveContainer>
    </div>
  </div>;
}

const Card = ({ title, value }) => <div className="bg-white p-4 rounded shadow"><p className="text-sm text-slate-500">{title}</p><p className="font-bold text-lg">{value}</p></div>;
