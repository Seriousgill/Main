import mongoose from 'mongoose';

const schema = new mongoose.Schema(
  {
    userId: { type: mongoose.Schema.Types.ObjectId, ref: 'User' },
    amount: Number,
    date: Date,
    dueDate: Date,
    status: { type: String, enum: ['pending', 'completed'], default: 'pending' }
  },
  { timestamps: true }
);

export default mongoose.model('Repurchase', schema);
