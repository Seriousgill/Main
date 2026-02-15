import jwt from 'jsonwebtoken';
import { env } from '../config/env.js';
import User from '../models/User.js';

export const protect = async (req, res, next) => {
  const header = req.headers.authorization;
  if (!header?.startsWith('Bearer ')) return res.status(401).json({ message: 'Unauthorized' });
  try {
    const token = header.split(' ')[1];
    const payload = jwt.verify(token, env.jwtSecret);
    req.user = await User.findById(payload.id);
    if (!req.user) return res.status(401).json({ message: 'Invalid token user' });
    next();
  } catch {
    return res.status(401).json({ message: 'Invalid token' });
  }
};

export const adminOnly = (req, res, next) => {
  if (req.user?.role !== 'admin') return res.status(403).json({ message: 'Forbidden' });
  next();
};
