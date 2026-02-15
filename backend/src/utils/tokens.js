import jwt from 'jsonwebtoken';
import { env } from '../config/env.js';

export const createAccessToken = (user) =>
  jwt.sign({ id: user._id, role: user.role }, env.jwtSecret, { expiresIn: env.jwtExpiresIn });

export const createRefreshToken = (user) =>
  jwt.sign({ id: user._id }, env.jwtRefreshSecret, { expiresIn: env.refreshExpiresIn });
