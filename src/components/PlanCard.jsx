import Card from './Card';
import Button from './Button';

export default function PlanCard({ plan, onClick, mode = 'public' }) {
  return (
    <Card className="flex h-full flex-col justify-between">
      <div>
        <h3 className="text-xl font-bold text-primary">{plan.name}</h3>
        <p className="mt-2 text-3xl font-extrabold">{plan.price}</p>
        <div className="mt-4 space-y-2 text-sm text-textSecondary">
          <p>Validity: {plan.validity}</p>
          <p>Daily Income: {plan.dailyIncome}</p>
          <p>Referral Daily Income: {plan.referral}</p>
          <p>One-Time Bonus: {plan.bonus}</p>
          <p>Minimum Withdrawal: {plan.minWithdraw}</p>
          <p>Weekly Limit: {plan.weeklyLimit}</p>
        </div>
      </div>
      <Button className="mt-5 w-full" onClick={onClick}>{mode === 'public' ? 'View Plan' : 'Buy Now'}</Button>
    </Card>
  );
}
