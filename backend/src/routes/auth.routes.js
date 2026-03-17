import express from 'express';
import jwt from 'jsonwebtoken';

const router = express.Router();

router.post('/login', (req, res) => {
  const { email, role = 'employee' } = req.body;

  if (!email) {
    return res.status(400).json({ message: 'Email is required' });
  }

  const token = jwt.sign({ sub: email, role }, process.env.JWT_SECRET, { expiresIn: '8h' });
  return res.json({ accessToken: token, tokenType: 'Bearer', expiresIn: '8h' });
});

export default router;
