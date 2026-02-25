import PlanCard from '../../components/PlanCard';
import { publicPlans } from '../../data/mockData';

export default function BuyPlanPage() {
  return <div className="grid gap-6 md:grid-cols-3">{publicPlans.map((plan) => <PlanCard key={plan.name} plan={plan} mode="buy" />)}</div>;
}
