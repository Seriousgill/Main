# MLM Web Application (React + Node + MongoDB)

A complete multi-level marketing starter platform with:
- User/admin authentication (JWT + refresh token)
- Package purchase, referral, binary points/pairing, level income
- Daily reward and MLM cron jobs
- Wallets, withdrawals, repurchase, tickets, notifications, KYC structure
- Admin panel APIs for users, packages, withdrawals, settings, transactions, KYC, support

## Project Structure
- `backend/` Express + Mongoose API
- `frontend/` React + Tailwind dashboard UI

## Setup
```bash
npm i
npm run install:all
```

### Backend
```bash
cd backend
cp .env.example .env # create manually
npm run seed
npm run dev
```

### Frontend
```bash
cd frontend
npm run dev
```

## Key API Modules
- `/api/auth/*`
- `/api/user/*`
- `/api/packages/*`
- `/api/wallet/*`
- `/api/referral/*`
- `/api/binary/*`
- `/api/repurchase/*`
- `/api/notifications/*`
- `/api/tickets/*`
- `/api/admin/*`

## Environment (`backend/.env`)
- `PORT`
- `MONGO_URI`
- `JWT_SECRET`
- `JWT_REFRESH_SECRET`
- `JWT_EXPIRES_IN`
- `REFRESH_EXPIRES_IN`
- `FRONTEND_URL`

## Payment Integration Placeholder
`POST /api/packages/purchase` accepts `paymentGateway` and `paymentRef` fields to integrate Razorpay/Paytm/Stripe callbacks.

## Deploy
- Frontend: Vercel (set `VITE_API_URL`)
- Backend: Render/Heroku
