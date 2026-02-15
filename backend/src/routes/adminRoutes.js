import { Router } from 'express';
import { protect, adminOnly } from '../middleware/auth.js';
import {
  adminDashboard,
  listUsers,
  updateUser,
  crudPackages,
  listWithdrawals,
  processWithdrawal,
  transactionLogs,
  kycList,
  updateKyc,
  dueRepurchases,
  setSettings,
  getSettings,
  tickets,
  replyTicketAdmin,
  salesMetrics,
  repurchaseHistory
} from '../controllers/adminController.js';
import { adminCredit } from '../controllers/miscController.js';

const router = Router();
router.use(protect, adminOnly);

router.get('/dashboard', adminDashboard);
router.get('/sales', salesMetrics);
router.get('/users', listUsers);
router.put('/users/:id', updateUser);
router.post('/users/wallet-credit', adminCredit);

router.get('/packages', crudPackages.list);
router.post('/packages', crudPackages.create);
router.put('/packages/:id', crudPackages.update);
router.delete('/packages/:id', crudPackages.remove);

router.get('/withdrawals', listWithdrawals);
router.put('/withdrawals/:id', processWithdrawal);
router.get('/transactions', transactionLogs);

router.get('/repurchases/due', dueRepurchases);
router.get('/repurchases/history', repurchaseHistory);

router.get('/kyc', kycList);
router.put('/kyc/:id', updateKyc);

router.get('/tickets', tickets);
router.post('/tickets/:id/reply', replyTicketAdmin);

router.get('/settings', getSettings);
router.put('/settings', setSettings);

export default router;
