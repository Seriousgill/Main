import { validationResult } from 'express-validator';
import crypto from 'crypto';
import jwt from 'jsonwebtoken';
import User from '../models/User.js';
import Wallet from '../models/Wallet.js';
import { createAccessToken, createRefreshToken } from '../utils/tokens.js';
import { env } from '../config/env.js';

export const register = async (req, res) => {
  const errors = validationResult(req);
  if (!errors.isEmpty()) return res.status(400).json({ errors: errors.array() });
  const { name, email, phone, password, sponsorCode } = req.body;
  const existing = await User.findOne({ email });
  if (existing) return res.status(409).json({ message: 'Email already in use' });

  let sponsorId;
  if (sponsorCode) {
    const sponsor = await User.findById(sponsorCode);
    if (sponsor) sponsorId = sponsor._id;
  }

  const emailVerificationToken = crypto.randomBytes(20).toString('hex');
  const user = await User.create({ name, email, phone, password, sponsorId, emailVerificationToken });
  await Wallet.create({ userId: user._id });

  return res.status(201).json({ message: 'Registered', userId: user._id, verifyToken: emailVerificationToken });
};

export const login = async (req, res) => {
  const { email, password } = req.body;
  const user = await User.findOne({ email });
  if (!user || !(await user.comparePassword(password))) return res.status(401).json({ message: 'Invalid credentials' });

  const accessToken = createAccessToken(user);
  const refreshToken = createRefreshToken(user);
  user.refreshTokens.push(refreshToken);
  await user.save();

  res.json({ accessToken, refreshToken, user: { id: user._id, name: user.name, role: user.role } });
};

export const refresh = async (req, res) => {
  const { refreshToken } = req.body;
  if (!refreshToken) return res.status(400).json({ message: 'Refresh token required' });
  try {
    const payload = jwt.verify(refreshToken, env.jwtRefreshSecret);
    const user = await User.findById(payload.id);
    if (!user?.refreshTokens.includes(refreshToken)) throw new Error('Invalid refresh token');
    return res.json({ accessToken: createAccessToken(user) });
  } catch {
    return res.status(401).json({ message: 'Invalid refresh token' });
  }
};

export const forgotPassword = async (req, res) => {
  const user = await User.findOne({ email: req.body.email });
  if (!user) return res.json({ message: 'If email exists, token sent.' });
  user.resetToken = crypto.randomBytes(20).toString('hex');
  user.resetTokenExpiry = Date.now() + 1000 * 60 * 20;
  await user.save();
  return res.json({ message: 'Reset token generated', resetToken: user.resetToken });
};

export const resetPassword = async (req, res) => {
  const { token, password } = req.body;
  const user = await User.findOne({ resetToken: token, resetTokenExpiry: { $gt: Date.now() } });
  if (!user) return res.status(400).json({ message: 'Invalid or expired token' });
  user.password = password;
  user.resetToken = undefined;
  user.resetTokenExpiry = undefined;
  await user.save();
  res.json({ message: 'Password reset successful' });
};

export const verifyEmail = async (req, res) => {
  const user = await User.findOne({ emailVerificationToken: req.params.token });
  if (!user) return res.status(400).json({ message: 'Invalid token' });
  user.emailVerified = true;
  user.emailVerificationToken = undefined;
  await user.save();
  return res.json({ message: 'Email verified' });
};
