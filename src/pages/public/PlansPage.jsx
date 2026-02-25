import { publicPlans } from '../../data/mockData';
import PlanCard from '../../components/PlanCard';

export default function PlansPage() {
  return <div className="mx-auto grid max-w-7xl gap-6 px-6 py-12 md:grid-cols-3">{publicPlans.map((plan) => <PlanCard key={plan.name} plan={plan} />)}</div>;
}
