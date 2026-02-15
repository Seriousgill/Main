import { Router } from 'express';
import { protect } from '../middleware/auth.js';
import { balance, transactions, withdrawalRequest, withdrawalHistory } from '../controllers/walletController.js';

const router = Router();
router.use(protect);
router.get('/balance', balance);
router.get('/transactions', transactions);
router.post('/withdrawal-request', withdrawalRequest);
router.get('/withdrawal-history', withdrawalHistory);

export default router;
