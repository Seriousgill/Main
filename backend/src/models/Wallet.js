import mongoose from 'mongoose';

const walletSchema = new mongoose.Schema(
  {
    userId: { type: mongoose.Schema.Types.ObjectId, ref: 'User', unique: true, required: true },
    earningWallet: { type: Number, default: 0 },
    referralWallet: { type: Number, default: 0 },
    matchingWallet: { type: Number, default: 0 },
    repurchaseWallet: { type: Number, default: 0 },
    totalWithdrawn: { type: Number, default: 0 }
  },
  { timestamps: true }
);

export default mongoose.model('Wallet', walletSchema);
