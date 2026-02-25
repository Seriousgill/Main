import Button from '../../components/Button';
import Card from '../../components/Card';
import StatCard from '../../components/StatCard';
import Table from '../../components/Table';
import { referralRows } from '../../data/mockData';

export default function ReferralsPage() {
  return (
    <div className="space-y-6">
      <Card title="Referral Link">
        <div className="flex flex-wrap gap-3"><input className="flex-1 rounded-xl border border-gray-300 px-3 py-2" value="https://mlmpro.app/register?ref=ARYAN123" readOnly /><Button>Copy</Button><Button variant="outline">Share WhatsApp</Button><Button variant="outline">Share Telegram</Button></div>
      </Card>
      <div className="grid gap-4 md:grid-cols-3"><StatCard title="Total Referrals" value="48" /><StatCard title="Active Referrals" value="29" /><StatCard title="Referral Earnings" value="₹20,650" /></div>
      <Table columns={['Name', 'Plan', 'Earnings', 'Date', 'Status']} rows={referralRows} />
    </div>
  );
}
