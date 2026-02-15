import { Router } from 'express';
import { protect } from '../middleware/auth.js';
import { tree, pairsHistory } from '../controllers/binaryController.js';

const router = Router();
router.use(protect);
router.get('/tree', tree);
router.get('/pairs-history', pairsHistory);

export default router;
