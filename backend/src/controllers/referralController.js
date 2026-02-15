import User from '../models/User.js';
import LevelIncome from '../models/LevelIncome.js';
import { env } from '../config/env.js';

export const directs = async (req, res) => {
  const rows = await User.find({ sponsorId: req.user._id }).select('name createdAt packageId');
  res.json(rows);
};

export const levelIncome = async (req, res) => {
  const rows = await LevelIncome.find({ userId: req.user._id }).sort({ createdAt: -1 });
  res.json(rows);
};

export const referralLink = async (req, res) => {
  res.json({ link: `${env.frontendUrl}/register?ref=${req.user._id}` });
};
