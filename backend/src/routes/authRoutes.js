import { Router } from 'express';
import { body } from 'express-validator';
import { register, login, forgotPassword, resetPassword, verifyEmail, refresh } from '../controllers/authController.js';

const router = Router();
router.post('/register', [body('name').notEmpty(), body('email').isEmail(), body('password').isLength({ min: 6 })], register);
router.post('/login', login);
router.post('/refresh', refresh);
router.post('/forgot-password', forgotPassword);
router.post('/reset-password', resetPassword);
router.get('/verify-email/:token', verifyEmail);

export default router;
