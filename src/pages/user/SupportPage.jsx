import Button from '../../components/Button';
import Card from '../../components/Card';
import FormInput from '../../components/FormInput';
import Table from '../../components/Table';
import { supportTickets } from '../../data/mockData';

export default function SupportPage() {
  return (
    <div className="space-y-6">
      <Card title="Create Ticket">
        <div className="grid gap-4 md:grid-cols-2"><FormInput label="Subject" /><FormInput label="Category" /></div>
        <label className="mt-4 block"><span className="mb-1 block text-sm font-medium">Description</span><textarea className="w-full rounded-xl border border-gray-300 p-3" rows="4" /></label>
        <Button className="mt-4">Submit Ticket</Button>
      </Card>
      <Table columns={['ID', 'Subject', 'Status', 'Date']} rows={supportTickets} />
    </div>
  );
}
