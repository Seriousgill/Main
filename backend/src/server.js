import cors from 'cors';
import dotenv from 'dotenv';
import express from 'express';
import helmet from 'helmet';
import { Pool } from 'pg';

import authRoutes from './routes/auth.routes.js';
import visitorRoutes from './routes/visitor.routes.js';
import visitRoutes from './routes/visit.routes.js';

dotenv.config();

const app = express();
const port = process.env.PORT || 4000;

export const db = new Pool({
  connectionString: process.env.DATABASE_URL,
});

app.use(helmet());
app.use(cors());
app.use(express.json({ limit: '10mb' }));

app.get('/health', async (_req, res) => {
  try {
    await db.query('SELECT 1');
    res.status(200).json({ status: 'ok', db: 'connected' });
  } catch (error) {
    res.status(500).json({ status: 'error', db: 'disconnected', message: error.message });
  }
});

app.use('/api/auth', authRoutes);
app.use('/api/visitors', visitorRoutes);
app.use('/api/visits', visitRoutes);

app.use((err, _req, res, _next) => {
  res.status(err.status || 500).json({
    message: err.message || 'Unexpected error',
  });
});

app.listen(port, () => {
  console.log(`API running on port ${port}`);
});
