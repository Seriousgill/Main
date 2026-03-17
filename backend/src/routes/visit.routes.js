import express from 'express';

import { requireAuth, requireRole } from '../middleware/auth.js';
import { db } from '../server.js';

const router = express.Router();

router.get('/today', requireAuth, requireRole('admin', 'manager', 'security_guard', 'receptionist'), async (_req, res, next) => {
  try {
    const { rows } = await db.query(
      `SELECT v.id, v.status, v.check_in_at, v.check_out_at,
              vs.full_name AS visitor_name,
              u.full_name AS host_name
       FROM visits v
       JOIN visitors vs ON vs.id = v.visitor_id
       JOIN users u ON u.id = v.host_user_id
       WHERE DATE(v.created_at) = CURRENT_DATE
       ORDER BY v.created_at DESC`,
    );
    res.json(rows);
  } catch (error) {
    next(error);
  }
});

router.patch('/:id/check-out', requireAuth, requireRole('security_guard', 'admin', 'manager'), async (req, res, next) => {
  try {
    const { rows } = await db.query(
      `UPDATE visits
       SET check_out_at = NOW(), status = 'checked_out'
       WHERE id = $1
       RETURNING id, status, check_out_at`,
      [req.params.id],
    );

    if (!rows.length) {
      return res.status(404).json({ message: 'Visit not found' });
    }

    return res.json(rows[0]);
  } catch (error) {
    return next(error);
  }
});

export default router;
