import { Router } from 'express';
import { protect } from '../middleware/auth.js';
import { directs, levelIncome, referralLink } from '../controllers/referralController.js';

const router = Router();
router.use(protect);
router.get('/directs', directs);
router.get('/level-income', levelIncome);
router.get('/link', referralLink);

export default router;
