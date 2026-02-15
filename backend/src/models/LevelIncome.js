import mongoose from 'mongoose';

const schema = new mongoose.Schema(
  {
    userId: { type: mongoose.Schema.Types.ObjectId, ref: 'User' },
    level: Number,
    downlineId: { type: mongoose.Schema.Types.ObjectId, ref: 'User' },
    percentage: Number,
    amount: Number
  },
  { timestamps: true }
);

export default mongoose.model('LevelIncome', schema);
