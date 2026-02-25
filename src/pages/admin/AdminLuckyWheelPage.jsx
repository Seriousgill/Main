import Button from '../../components/Button';
import Card from '../../components/Card';
import FormInput from '../../components/FormInput';

export default function AdminLuckyWheelPage() {
  return (
    <Card title="Lucky Wheel Management">
      <div className="grid gap-4 md:grid-cols-2"><FormInput label="Reward Name" /><FormInput label="Probability %" /></div>
      <div className="mt-4 flex gap-3"><Button>Add Reward</Button><Button variant="outline">Enable/Disable</Button></div>
    </Card>
  );
}
