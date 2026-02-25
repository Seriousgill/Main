import Button from '../../components/Button';
import Card from '../../components/Card';
import FormInput from '../../components/FormInput';
import Table from '../../components/Table';

const history = [
  { date: '2026-02-21', method: 'UPI', amount: '₹1,000', status: 'Pending' },
  { date: '2026-02-14', method: 'Bank', amount: '₹2,000', status: 'Approved' },
];

export default function WithdrawPage() {
  return (
    <div className="space-y-6">
      <Card title="Withdraw Funds"><div className="grid gap-3 md:grid-cols-3"><p>Available Balance: <b>₹12,480</b></p><p>Minimum Withdrawal: <b>₹500</b></p><p>Weekly Limit: <b>₹4,000</b></p></div></Card>
      <Card title="Withdrawal Form">
        <div className="grid gap-4 md:grid-cols-2">
          <FormInput label="Amount" />
          <label><span className="mb-1 block text-sm font-medium">Payment Method</span><select className="w-full rounded-xl border border-gray-300 px-3 py-2"><option>UPI</option><option>Bank</option></select></label>
          <FormInput label="UPI ID" />
          <FormInput label="Bank Account / IFSC" />
        </div>
        <Button className="mt-4" variant="danger">Submit</Button>
      </Card>
      <Table columns={['Date', 'Method', 'Amount', 'Status']} rows={history} />
    </div>
  );
}
