import dotenv from 'dotenv';
dotenv.config();

export const env = {
  port: process.env.PORT || 5000,
  mongoUri: process.env.MONGO_URI || 'mongodb://127.0.0.1:27017/mlm_app',
  jwtSecret: process.env.JWT_SECRET || 'dev_jwt_secret',
  jwtRefreshSecret: process.env.JWT_REFRESH_SECRET || 'dev_refresh_secret',
  jwtExpiresIn: process.env.JWT_EXPIRES_IN || '1d',
  refreshExpiresIn: process.env.REFRESH_EXPIRES_IN || '7d',
  frontendUrl: process.env.FRONTEND_URL || 'http://localhost:5173'
};
