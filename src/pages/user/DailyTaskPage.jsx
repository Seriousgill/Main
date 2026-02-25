import { useState } from 'react';
import Button from '../../components/Button';
import Card from '../../components/Card';

export default function DailyTaskPage() {
  const [done, setDone] = useState(false);
  return (
    <Card title="Daily Task">
      <p className="font-semibold">Share your referral link with 5 contacts</p>
      <p className="mt-2 text-sm text-textSecondary">Complete this activity to unlock today's task income.</p>
      <p className="mt-4 text-warning">Timer Countdown: 02:15:44</p>
      <Button className="mt-4" onClick={() => setDone(true)}>Submit</Button>
      {done ? <p className="mt-4 rounded-xl bg-green-100 p-3 text-success">Task submitted successfully!</p> : null}
    </Card>
  );
}
