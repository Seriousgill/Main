import mongoose from 'mongoose';

const transactionSchema = new mongoose.Schema(
  {
    userId: { type: mongoose.Schema.Types.ObjectId, ref: 'User', required: true },
    amount: { type: Number, required: true },
    type: { type: String, enum: ['credit', 'debit'], required: true },
    source: {
      type: String,
      enum: ['daily', 'referral', 'binary', 'level', 'withdrawal', 'repurchase', 'manual', 'purchase'],
      required: true
    },
    description: String,
    status: { type: String, default: 'success' }
  },
  { timestamps: true }
);

export default mongoose.model('Transaction', transactionSchema);
