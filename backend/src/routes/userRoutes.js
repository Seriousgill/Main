import { Router } from 'express';
import { protect } from '../middleware/auth.js';
import { profile, updateProfile, dashboard, team, genealogy, binaryStats } from '../controllers/userController.js';

const router = Router();
router.use(protect);
router.get('/profile', profile);
router.put('/profile', updateProfile);
router.get('/dashboard', dashboard);
router.get('/team', team);
router.get('/genealogy', genealogy);
router.get('/binary-stats', binaryStats);

export default router;
