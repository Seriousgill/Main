import { Router } from 'express';
import { protect } from '../middleware/auth.js';
import {
  repurchaseStatus,
  repurchasePay,
  notifications,
  markNotificationRead,
  getTickets,
  createTicket,
  replyTicket
} from '../controllers/miscController.js';

const router = Router();
router.use(protect);
router.get('/repurchase/status', repurchaseStatus);
router.post('/repurchase/pay', repurchasePay);
router.get('/notifications', notifications);
router.put('/notifications/:id/read', markNotificationRead);
router.get('/tickets', getTickets);
router.post('/tickets/create', createTicket);
router.post('/tickets/:id/reply', replyTicket);

export default router;
