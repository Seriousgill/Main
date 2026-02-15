import Wallet from '../models/Wallet.js';
import Transaction from '../models/Transaction.js';
import Withdrawal from '../models/Withdrawal.js';
import Setting from '../models/Setting.js';
import { debitWallet } from '../services/walletService.js';

const getSetting = async (key, fallback) => (await Setting.findOne({ key }))?.value ?? fallback;

export const balance = async (req, res) => {
  const wallet = await Wallet.findOne({ userId: req.user._id });
  res.json(wallet);
};

export const transactions = async (req, res) => {
  const txs = await Transaction.find({ userId: req.user._id }).sort({ createdAt: -1 });
  res.json(txs);
};

export const withdrawalRequest = async (req, res) => {
  const amount = Number(req.body.amount);
  const min = await getSetting('minWithdrawal', 500);
  const feePercent = await getSetting('withdrawalFeePercent', 5);
  const reinvestPercent = await getSetting('reinvestPercent', 10);
  if (amount < min) return res.status(400).json({ message: `Minimum withdrawal is ${min}` });

  await debitWallet({ userId: req.user._id, field: 'earningWallet', amount, source: 'withdrawal', description: 'Withdrawal request' });

  const fee = Number((amount * feePercent / 100).toFixed(2));
  const reinvestAmount = Number((amount * reinvestPercent / 100).toFixed(2));
  const netAmount = Number((amount - fee - reinvestAmount).toFixed(2));

  const wr = await Withdrawal.create({ userId: req.user._id, amount, fee, reinvestAmount, netAmount });
  res.status(201).json(wr);
};

export const withdrawalHistory = async (req, res) => {
  const data = await Withdrawal.find({ userId: req.user._id }).sort({ createdAt: -1 });
  res.json(data);
};
