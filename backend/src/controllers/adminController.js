import User from '../models/User.js';
import Package from '../models/Package.js';
import Withdrawal from '../models/Withdrawal.js';
import Transaction from '../models/Transaction.js';
import Ticket from '../models/Ticket.js';
import Kyc from '../models/Kyc.js';
import Setting from '../models/Setting.js';
import Repurchase from '../models/Repurchase.js';

export const adminDashboard = async (_req, res) => {
  const [totalUsers, activeUsers, pendingWithdrawals, pendingAmount, recentRegistrations, totalPayout] = await Promise.all([
    User.countDocuments(),
    User.countDocuments({ isActive: true }),
    Withdrawal.countDocuments({ status: 'pending' }),
    Withdrawal.aggregate([{ $match: { status: 'pending' } }, { $group: { _id: null, total: { $sum: '$amount' } } }]),
    User.find().sort({ createdAt: -1 }).limit(5).select('name email createdAt'),
    Withdrawal.aggregate([{ $match: { status: { $in: ['approved', 'paid'] } } }, { $group: { _id: null, total: { $sum: '$netAmount' } } }])
  ]);

  return res.json({
    users: { totalUsers, activeUsers, inactiveUsers: totalUsers - activeUsers },
    withdrawals: { pendingWithdrawals, pendingAmount: pendingAmount[0]?.total || 0, totalPayout: totalPayout[0]?.total || 0 },
    recentRegistrations
  });
};

export const listUsers = async (req, res) => {
  const q = req.query.q || '';
  const filter = q
    ? { $or: [{ name: new RegExp(q, 'i') }, { email: new RegExp(q, 'i') }, { phone: new RegExp(q, 'i') }] }
    : {};
  const users = await User.find(filter).populate('packageId').sort({ createdAt: -1 });
  res.json(users);
};

export const updateUser = async (req, res) => {
  const user = await User.findByIdAndUpdate(req.params.id, req.body, { new: true });
  res.json(user);
};

export const crudPackages = {
  create: async (req, res) => res.status(201).json(await Package.create(req.body)),
  list: async (_req, res) => res.json(await Package.find().sort({ price: 1 })),
  update: async (req, res) => res.json(await Package.findByIdAndUpdate(req.params.id, req.body, { new: true })),
  remove: async (req, res) => res.json(await Package.findByIdAndDelete(req.params.id))
};

export const listWithdrawals = async (req, res) => {
  const filter = req.query.status ? { status: req.query.status } : {};
  res.json(await Withdrawal.find(filter).populate('userId', 'name email').sort({ createdAt: -1 }));
};

export const processWithdrawal = async (req, res) => {
  const row = await Withdrawal.findById(req.params.id);
  if (!row) return res.status(404).json({ message: 'Not found' });
  row.status = req.body.status;
  row.transactionId = req.body.transactionId || row.transactionId;
  row.processedAt = new Date();
  await row.save();
  return res.json(row);
};

export const transactionLogs = async (req, res) => {
  const filter = {};
  if (req.query.type) filter.source = req.query.type;
  if (req.query.userId) filter.userId = req.query.userId;
  const rows = await Transaction.find(filter).populate('userId', 'name email').sort({ createdAt: -1 });
  res.json(rows);
};

export const kycList = async (req, res) => {
  const filter = req.query.status ? { status: req.query.status } : {};
  res.json(await Kyc.find(filter).populate('userId', 'name email'));
};

export const updateKyc = async (req, res) => {
  res.json(await Kyc.findByIdAndUpdate(req.params.id, { status: req.body.status, verifiedAt: new Date() }, { new: true }));
};

export const dueRepurchases = async (_req, res) => {
  const dueDate = new Date(Date.now() - 1000 * 60 * 60 * 24 * 30);
  res.json(await User.find({ $or: [{ lastRepurchaseDate: { $lt: dueDate } }, { lastRepurchaseDate: { $exists: false } }] }).select('name email'));
};

export const setSettings = async (req, res) => {
  const updates = req.body;
  const entries = Object.entries(updates);
  for (const [key, value] of entries) {
    await Setting.findOneAndUpdate({ key }, { value }, { upsert: true });
  }
  res.json({ message: 'Settings updated' });
};

export const getSettings = async (_req, res) => {
  const settings = await Setting.find();
  res.json(settings);
};

export const tickets = async (_req, res) => {
  res.json(await Ticket.find().populate('userId', 'name email').sort({ createdAt: -1 }));
};

export const replyTicketAdmin = async (req, res) => {
  const ticket = await Ticket.findById(req.params.id);
  ticket.replies.push({ by: req.user._id, message: req.body.message });
  ticket.status = req.body.close ? 'closed' : 'replied';
  await ticket.save();
  res.json(ticket);
};

export const salesMetrics = async (_req, res) => {
  const allTime = await Transaction.aggregate([{ $match: { source: 'purchase' } }, { $group: { _id: null, total: { $sum: '$amount' } } }]);
  const now = new Date();
  const day = new Date(now); day.setHours(0, 0, 0, 0);
  const week = new Date(now); week.setDate(now.getDate() - 7);
  const month = new Date(now); month.setMonth(now.getMonth() - 1);
  const sumSince = async (date) => (await Transaction.aggregate([{ $match: { source: 'purchase', createdAt: { $gte: date } } }, { $group: { _id: null, total: { $sum: '$amount' } } }]))[0]?.total || 0;
  res.json({ today: await sumSince(day), week: await sumSince(week), month: await sumSince(month), allTime: allTime[0]?.total || 0 });
};

export const repurchaseHistory = async (_req, res) => res.json(await Repurchase.find().populate('userId', 'name email').sort({ createdAt: -1 }));
