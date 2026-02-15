import { Router } from 'express';
import { protect } from '../middleware/auth.js';
import { listPackages, purchasePackage } from '../controllers/packageController.js';

const router = Router();
router.get('/', listPackages);
router.post('/purchase', protect, purchasePackage);

export default router;
