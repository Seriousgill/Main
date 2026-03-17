import express from 'express';

import { requireAuth, requireRole } from '../middleware/auth.js';
import { db } from '../server.js';

const router = express.Router();

router.get('/', requireAuth, requireRole('admin', 'manager', 'receptionist', 'security_guard'), async (_req, res, next) => {
  try {
    const { rows } = await db.query('SELECT id, full_name, phone, email, company, created_at FROM visitors ORDER BY created_at DESC LIMIT 100');
    res.json(rows);
  } catch (error) {
    next(error);
  }
});

router.post('/', requireAuth, requireRole('admin', 'manager', 'receptionist'), async (req, res, next) => {
  const { fullName, phone, email, company } = req.body;
  if (!fullName || !phone) {
    return res.status(400).json({ message: 'fullName and phone are required' });
  }

  try {
    const { rows } = await db.query(
      `INSERT INTO visitors (full_name, phone, email, company)
       VALUES ($1, $2, $3, $4)
       RETURNING id, full_name, phone, email, company, created_at`,
      [fullName, phone, email ?? null, company ?? null],
    );
    return res.status(201).json(rows[0]);
  } catch (error) {
    return next(error);
  }
});

export default router;
