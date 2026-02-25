import Card from '../../components/Card';
import FormInput from '../../components/FormInput';

function Toggle({ label }) {
  return <label className="flex items-center justify-between rounded-xl border border-gray-200 p-3"><span>{label}</span><input type="checkbox" defaultChecked className="h-4 w-4" /></label>;
}

export default function SystemSettingsPage() {
  return (
    <Card title="System Settings">
      <div className="grid gap-4 md:grid-cols-2">
        <Toggle label="Referral System" /><Toggle label="Task System" /><Toggle label="Lucky Wheel" /><Toggle label="Maintenance Mode" />
        <FormInput label="Withdrawal Fee %" />
        <FormInput label="Payment Gateway Key" />
      </div>
    </Card>
  );
}
