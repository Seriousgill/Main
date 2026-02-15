import mongoose from 'mongoose';

const withdrawalSchema = new mongoose.Schema(
  {
    userId: { type: mongoose.Schema.Types.ObjectId, ref: 'User', required: true },
    amount: Number,
    fee: Number,
    netAmount: Number,
    reinvestAmount: Number,
    status: { type: String, enum: ['pending', 'approved', 'rejected', 'paid'], default: 'pending' },
    transactionId: String,
    paymentProof: String,
    processedAt: Date
  },
  { timestamps: true }
);

export default mongoose.model('Withdrawal', withdrawalSchema);
