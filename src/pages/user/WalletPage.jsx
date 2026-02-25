import StatCard from '../../components/StatCard';
import Table from '../../components/Table';
import { transactions } from '../../data/mockData';

export default function WalletPage() {
  return (
    <div className="space-y-6">
      <div className="grid gap-4 md:grid-cols-4"><StatCard title="Task Income" value="₹31,540" /><StatCard title="Referral Income" value="₹20,650" /><StatCard title="Lucky Income" value="₹8,240" /><StatCard title="Total Balance" value="₹12,480" /></div>
      <Table columns={['Date', 'Type', 'Amount', 'Status']} rows={transactions} />
    </div>
  );
}
