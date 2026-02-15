import User from '../models/User.js';
import Wallet from '../models/Wallet.js';
import Transaction from '../models/Transaction.js';
import BinaryPoint from '../models/BinaryPoint.js';

const getDownlineCount = async (userId, depth = 10) => {
  let currentLevel = [userId];
  let total = 0;
  for (let i = 0; i < depth; i += 1) {
    const users = await User.find({ sponsorId: { $in: currentLevel } }).select('_id');
    if (!users.length) break;
    total += users.length;
    currentLevel = users.map((u) => u._id);
  }
  return total;
};

export const profile = async (req, res) => {
  const user = await User.findById(req.user._id).select('-password -refreshTokens');
  res.json(user);
};

export const updateProfile = async (req, res) => {
  const allowed = ['name', 'phone', 'bankDetails'];
  const update = {};
  allowed.forEach((key) => {
    if (req.body[key] !== undefined) update[key] = req.body[key];
  });
  const user = await User.findByIdAndUpdate(req.user._id, update, { new: true }).select('-password');
  res.json(user);
};

export const dashboard = async (req, res) => {
  const user = await User.findById(req.user._id).populate('packageId');
  const wallet = await Wallet.findOne({ userId: req.user._id });
  const recentTransactions = await Transaction.find({ userId: req.user._id }).sort({ createdAt: -1 }).limit(5);
  const directCount = await User.countDocuments({ sponsorId: req.user._id });
  const totalTeam = await getDownlineCount(req.user._id, 5);
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  const todaysEarning = await Transaction.aggregate([
    { $match: { userId: req.user._id, type: 'credit', createdAt: { $gte: today } } },
    { $group: { _id: null, total: { $sum: '$amount' } } }
  ]);

  const bp = await BinaryPoint.findOne({ userId: req.user._id });
  res.json({
    welcome: `Welcome ${user.name}`,
    wallet,
    package: user.packageId,
    totalEarnings: user.totalReceived,
    todaysEarning: todaysEarning[0]?.total || 0,
    team: { directs: directCount, totalTeam },
    binary: bp,
    recentTransactions
  });
};

export const team = async (req, res) => {
  const level = Number(req.query.level || 1);
  let ids = [req.user._id];
  for (let l = 1; l <= level; l += 1) {
    const users = await User.find({ sponsorId: { $in: ids } }).select('name email packageId createdAt sponsorId');
    if (l === level) return res.json(users);
    ids = users.map((u) => u._id);
  }
  return res.json([]);
};

export const genealogy = async (req, res) => {
  const buildTree = async (parentId, depth) => {
    if (!depth) return [];
    const children = await User.find({ sponsorId: parentId }).select('name packageId createdAt');
    const result = [];
    for (const child of children) {
      result.push({ user: child, children: await buildTree(child._id, depth - 1) });
    }
    return result;
  };
  const tree = await buildTree(req.user._id, 5);
  res.json(tree);
};

export const binaryStats = async (req, res) => {
  const stats = await BinaryPoint.findOne({ userId: req.user._id });
  res.json(stats || { leftPoints: 0, rightPoints: 0, totalPairs: 0 });
};
