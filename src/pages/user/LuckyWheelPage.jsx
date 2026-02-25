import Button from '../../components/Button';
import Card from '../../components/Card';
import Table from '../../components/Table';
import { rewardsHistory } from '../../data/mockData';

export default function LuckyWheelPage() {
  return (
    <div className="space-y-6">
      <Card title="Lucky Wheel">
        <div className="grid items-center gap-6 md:grid-cols-2">
          <div className="mx-auto flex h-64 w-64 items-center justify-center rounded-full border-8 border-purpleEnd bg-gradient-to-br from-purpleStart to-primary text-center text-white shadow-soft">Spin & Win</div>
          <div><p className="text-lg font-semibold">Available Spins: 3</p><Button className="mt-4" variant="gradient">Spin</Button></div>
        </div>
      </Card>
      <Table columns={['Date', 'Reward', 'Status']} rows={rewardsHistory} />
    </div>
  );
}
