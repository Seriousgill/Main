import Repurchase from '../models/Repurchase.js';
import Notification from '../models/Notification.js';
import Ticket from '../models/Ticket.js';
import { creditWallet, debitWallet } from '../services/walletService.js';

export const repurchaseStatus = async (req, res) => {
  const row = await Repurchase.findOne({ userId: req.user._id }).sort({ createdAt: -1 });
  res.json(row || { status: 'pending', dueDate: null });
};

export const repurchasePay = async (req, res) => {
  const amount = Number(req.body.amount || 500);
  const mode = req.body.mode || 'wallet';
  if (mode === 'wallet') {
    await debitWallet({ userId: req.user._id, field: 'repurchaseWallet', amount, source: 'repurchase', description: 'Repurchase deduction' });
  }
  const record = await Repurchase.create({ userId: req.user._id, amount, date: new Date(), dueDate: new Date(Date.now() + 1000 * 60 * 60 * 24 * 30), status: 'completed' });
  res.status(201).json(record);
};

export const notifications = async (req, res) => {
  res.json(await Notification.find({ userId: req.user._id }).sort({ createdAt: -1 }));
};

export const markNotificationRead = async (req, res) => {
  const row = await Notification.findOneAndUpdate({ _id: req.params.id, userId: req.user._id }, { isRead: true }, { new: true });
  res.json(row);
};

export const getTickets = async (req, res) => {
  res.json(await Ticket.find({ userId: req.user._id }).sort({ createdAt: -1 }));
};

export const createTicket = async (req, res) => {
  const row = await Ticket.create({ userId: req.user._id, subject: req.body.subject, message: req.body.message });
  res.status(201).json(row);
};

export const replyTicket = async (req, res) => {
  const row = await Ticket.findOne({ _id: req.params.id, userId: req.user._id });
  if (!row) return res.status(404).json({ message: 'Ticket not found' });
  row.replies.push({ by: req.user._id, message: req.body.message });
  row.status = 'replied';
  await row.save();
  return res.json(row);
};

export const adminCredit = async (req, res) => {
  const { userId, field, amount } = req.body;
  const wallet = await creditWallet({ userId, field, amount: Number(amount), source: 'manual', description: 'Admin manual credit' });
  res.json(wallet);
};
