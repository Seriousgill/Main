import Button from '../../components/Button';
import Card from '../../components/Card';
import Table from '../../components/Table';

const rows = [
  { user: 'Riya Sharma', plan: 'Gold', status: 'Active', actions: 'Block/Credit/Upgrade' },
  { user: 'Karan Patel', plan: 'Silver', status: 'Blocked', actions: 'Unblock/Debit' },
];

export default function UserManagementPage() {
  return (
    <div className="space-y-6">
      <Card title="Search User"><input className="w-full rounded-xl border border-gray-300 px-3 py-2" placeholder="Search by name, mobile, email" /><div className="mt-4 flex gap-2"><Button>Search User</Button><Button variant="outline">Manual Credit/Debit</Button></div></Card>
      <Table columns={['User', 'Plan', 'Status', 'Actions']} rows={rows} />
    </div>
  );
}
