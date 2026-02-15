import cron from 'node-cron';
import User from '../models/User.js';
import Repurchase from '../models/Repurchase.js';
import BinaryPoint from '../models/BinaryPoint.js';
import Notification from '../models/Notification.js';
import { creditWallet } from '../services/walletService.js';
import { creditLevelIncome, processPairBonus } from '../services/mlmService.js';

const logs = [];
const pushLog = (message) => logs.push({ message, at: new Date() });

export const runDailyReward = async () => {
  const users = await User.find({ isActive: true, packageId: { $exists: true } });
  for (const user of users) {
    const lastRepurchase = await Repurchase.findOne({ userId: user._id, status: 'completed' }).sort({ date: -1 });
    const activeByRepurchase = !lastRepurchase || (Date.now() - new Date(lastRepurchase.date).getTime() <= 1000 * 60 * 60 * 24 * 30);
    if (!activeByRepurchase || user.totalReceived >= user.maxCap) continue;

    const remaining = user.maxCap - user.totalReceived;
    const amount = Math.min(user.dailyReward, remaining);
    await creditWallet({ userId: user._id, field: 'earningWallet', amount, source: 'daily', description: 'Daily reward credited' });
    user.totalReceived += amount;
    await user.save();
    await Notification.create({ userId: user._id, title: 'Daily reward', message: `₹${amount} credited`, type: 'daily' });
    await creditLevelIncome({ earnerId: user._id, dailyAmount: amount });
  }
  pushLog('Daily reward cron executed');
};

export const runBinaryPair = async () => {
  const records = await BinaryPoint.find();
  for (const record of records) {
    await processPairBonus({ userId: record.userId });
  }
  pushLog('Binary pair cron executed');
};

export const runFlushPoints = async () => {
  const date = new Date(Date.now() - 1000 * 60 * 60 * 24 * 30);
  await BinaryPoint.updateMany({ updatedAt: { $lt: date } }, { leftPoints: 0, rightPoints: 0, flushDate: new Date() });
  pushLog('Flush points cron executed');
};

export const runRepurchaseReminder = async () => {
  const dueDate = new Date(Date.now() - 1000 * 60 * 60 * 24 * 23);
  const dueUsers = await User.find({ isActive: true, lastRepurchaseDate: { $lte: dueDate } });
  for (const user of dueUsers) {
    await Notification.create({ userId: user._id, title: 'Repurchase reminder', message: 'You are due for monthly repurchase.', type: 'repurchase' });
  }
  pushLog('Repurchase reminder cron executed');
};

export const scheduleJobs = () => {
  cron.schedule('0 0 * * *', runDailyReward);
  cron.schedule('0 * * * *', runBinaryPair);
  cron.schedule('30 0 * * *', runFlushPoints);
  cron.schedule('0 9 * * 1', runRepurchaseReminder);
};

export const getCronLogs = () => logs.slice(-100);
