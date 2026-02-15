import Package from '../models/Package.js';
import User from '../models/User.js';
import Transaction from '../models/Transaction.js';
import { placeInBinary, creditReferralBonus, addBinaryPointsToUpline } from '../services/mlmService.js';

export const listPackages = async (_req, res) => {
  const packages = await Package.find({ isActive: true }).sort({ price: 1 });
  res.json(packages);
};

export const purchasePackage = async (req, res) => {
  const { packageId, paymentGateway = 'placeholder', paymentRef = 'demo_ref', placementId, position } = req.body;
  const pkg = await Package.findById(packageId);
  if (!pkg || !pkg.isActive) return res.status(404).json({ message: 'Package unavailable' });

  const user = await User.findById(req.user._id);
  user.packageId = pkg._id;
  user.packagePrice = pkg.price;
  user.dailyReward = pkg.dailyReward;
  user.maxCap = pkg.maxCap;
  user.isActive = true;
  await user.save();

  await Transaction.create({
    userId: user._id,
    amount: pkg.price,
    type: 'debit',
    source: 'purchase',
    description: `Package ${pkg.name} purchased via ${paymentGateway} (${paymentRef})`
  });

  await placeInBinary({ userId: user._id, placementId, position });
  await creditReferralBonus({ sponsorId: user.sponsorId, amount: pkg.referralBonus, newUserName: user.name });
  await addBinaryPointsToUpline({ placementId, position, pointValue: pkg.pointValue });

  res.json({ message: 'Package purchased and account activated', package: pkg.name });
};
