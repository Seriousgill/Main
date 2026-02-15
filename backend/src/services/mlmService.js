import User from '../models/User.js';
import BinaryPoint from '../models/BinaryPoint.js';
import LevelIncome from '../models/LevelIncome.js';
import Notification from '../models/Notification.js';
import { creditWallet } from './walletService.js';

export const levelPercentages = [8, 5, 3];

export const placeInBinary = async ({ userId, placementId, position }) => {
  if (!placementId || !position) return;
  await User.findByIdAndUpdate(userId, { placementId, position });
};

export const creditReferralBonus = async ({ sponsorId, amount, newUserName }) => {
  if (!sponsorId || amount <= 0) return;
  await creditWallet({
    userId: sponsorId,
    field: 'referralWallet',
    amount,
    source: 'referral',
    description: `Referral bonus from ${newUserName}`
  });
  await Notification.create({
    userId: sponsorId,
    title: 'Referral bonus credited',
    message: `You earned ₹${amount} as referral bonus.`,
    type: 'bonus'
  });
};

export const addBinaryPointsToUpline = async ({ placementId, position, pointValue }) => {
  if (!placementId || !position) return;
  const bp = await BinaryPoint.findOneAndUpdate(
    { userId: placementId },
    { $inc: position === 'left' ? { leftPoints: pointValue } : { rightPoints: pointValue } },
    { upsert: true, new: true }
  );
  return bp;
};

export const processPairBonus = async ({ userId, pairBonus = 150, dailyCap = 10 }) => {
  const bp = await BinaryPoint.findOne({ userId });
  if (!bp) return;
  const today = new Date().toDateString();
  if (!bp.lastPairDate || bp.lastPairDate.toDateString() !== today) bp.dailyPairs = 0;

  const potentialPairs = Math.min(Math.floor(bp.leftPoints / 3), Math.floor(bp.rightPoints / 3));
  const pairsToPay = Math.max(0, Math.min(potentialPairs, dailyCap - bp.dailyPairs));
  if (!pairsToPay) return;

  bp.leftPoints -= pairsToPay * 3;
  bp.rightPoints -= pairsToPay * 3;
  bp.totalPairs += pairsToPay;
  bp.dailyPairs += pairsToPay;
  bp.lastPairDate = new Date();
  await bp.save();

  await creditWallet({
    userId,
    field: 'matchingWallet',
    amount: pairsToPay * pairBonus,
    source: 'binary',
    description: `${pairsToPay} binary pair bonus credited`
  });
};

export const creditLevelIncome = async ({ earnerId, dailyAmount }) => {
  let current = await User.findById(earnerId).select('sponsorId');
  for (let i = 0; i < levelPercentages.length; i += 1) {
    if (!current?.sponsorId) break;
    const sponsor = await User.findById(current.sponsorId).select('sponsorId');
    const percent = levelPercentages[i];
    const amount = Number(((dailyAmount * percent) / 100).toFixed(2));
    if (amount > 0) {
      await creditWallet({
        userId: current.sponsorId,
        field: 'matchingWallet',
        amount,
        source: 'level',
        description: `Level ${i + 1} income`
      });
      await LevelIncome.create({ userId: current.sponsorId, level: i + 1, downlineId: earnerId, percentage: percent, amount });
    }
    current = sponsor;
  }
};
