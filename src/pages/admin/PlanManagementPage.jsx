import Button from '../../components/Button';
import Card from '../../components/Card';
import FormInput from '../../components/FormInput';
import Table from '../../components/Table';

const rows = [
  { name: 'Silver', price: '₹1800', status: 'Active', actions: 'Edit/Delete' },
  { name: 'Gold', price: '₹4200', status: 'Active', actions: 'Edit/Delete' },
  { name: 'Diamond', price: '₹7400', status: 'Inactive', actions: 'Edit/Delete' },
];

export default function PlanManagementPage() {
  return (
    <div className="space-y-6">
      <Card title="Add / Edit Plan">
        <div className="grid gap-4 md:grid-cols-3">
          <FormInput label="Name" /><FormInput label="Price" /><FormInput label="Validity" />
          <FormInput label="Daily Income" /><FormInput label="Referral Daily" /><FormInput label="One-Time Bonus" />
          <FormInput label="Min Withdrawal" /><FormInput label="Weekly Limit" />
        </div>
        <div className="mt-4 flex gap-3"><Button>Add Plan</Button><Button variant="outline">Activate/Deactivate</Button></div>
      </Card>
      <Table columns={['Name', 'Price', 'Status', 'Actions']} rows={rows} />
    </div>
  );
}
