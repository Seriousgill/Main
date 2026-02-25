import { Link } from 'react-router-dom';
import { publicPlans } from '../../data/mockData';
import PlanCard from '../../components/PlanCard';
import Button from '../../components/Button';

export default function LandingPage() {
  return (
    <div>
      <section className="bg-gradient-to-r from-primary to-purpleEnd py-20 text-white">
        <div className="mx-auto max-w-7xl px-6 text-center">
          <h1 className="text-4xl font-extrabold md:text-5xl">Build Wealth with a Smart MLM Fintech Platform</h1>
          <p className="mx-auto mt-4 max-w-2xl text-white/90">Automated plans, daily tasks, referrals, rewards, and instant wallet insights in one secure dashboard.</p>
          <div className="mt-8 flex flex-wrap justify-center gap-3">
            <Button className="bg-white text-primary">Get Started</Button>
            <Button variant="outline" className="border-white text-white hover:bg-white/10">View Plans</Button>
            <Link to="/register"><Button variant="success">Register</Button></Link>
            <Link to="/login"><Button variant="outline" className="border-white text-white">Login</Button></Link>
          </div>
        </div>
      </section>

      <section className="mx-auto grid max-w-7xl gap-6 px-6 py-14 md:grid-cols-3">
        {publicPlans.map((plan) => <PlanCard key={plan.name} plan={plan} />)}
      </section>

      <section className="mx-auto max-w-7xl px-6 pb-12">
        <h2 className="mb-6 text-2xl font-bold">How It Works</h2>
        <div className="grid gap-4 md:grid-cols-4">
          {['Register Account', 'Buy a Plan', 'Complete Daily Tasks', 'Withdraw Earnings'].map((step, i) => (
            <div key={step} className="rounded-xl bg-card p-6 shadow-soft"><p className="text-sm text-purpleEnd">Step {i + 1}</p><p className="mt-2 font-semibold">{step}</p></div>
          ))}
        </div>
      </section>
    </div>
  );
}
