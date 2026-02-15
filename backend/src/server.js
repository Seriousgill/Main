import app from './app.js';
import { connectDB } from './config/db.js';
import { env } from './config/env.js';
import { scheduleJobs, getCronLogs, runDailyReward } from './cron/jobs.js';
import { protect, adminOnly } from './middleware/auth.js';

await connectDB();
scheduleJobs();

app.get('/api/admin/cron/logs', protect, adminOnly, (_req, res) => res.json(getCronLogs()));
app.post('/api/admin/cron/daily-run', protect, adminOnly, async (_req, res) => {
  await runDailyReward();
  res.json({ message: 'Daily reward triggered manually' });
});

app.listen(env.port, () => console.log(`Server running on port ${env.port}`));
