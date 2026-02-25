import { Area, AreaChart, CartesianGrid, ResponsiveContainer, Tooltip, XAxis, YAxis } from 'recharts';
import Card from './Card';

export default function LineChartCard({ title, data, xKey = 'name', yKey = 'earnings' }) {
  return (
    <Card title={title}>
      <div className="h-72">
        <ResponsiveContainer width="100%" height="100%">
          <AreaChart data={data}>
            <defs>
              <linearGradient id="colorEarnings" x1="0" y1="0" x2="0" y2="1">
                <stop offset="5%" stopColor="#6D28D9" stopOpacity={0.5} />
                <stop offset="95%" stopColor="#9333EA" stopOpacity={0.05} />
              </linearGradient>
            </defs>
            <XAxis dataKey={xKey} />
            <YAxis />
            <CartesianGrid strokeDasharray="3 3" />
            <Tooltip />
            <Area type="monotone" dataKey={yKey} stroke="#1E3A8A" fillOpacity={1} fill="url(#colorEarnings)" />
          </AreaChart>
        </ResponsiveContainer>
      </div>
    </Card>
  );
}
