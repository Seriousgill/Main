import mongoose from 'mongoose';

const schema = new mongoose.Schema(
  {
    userId: { type: mongoose.Schema.Types.ObjectId, ref: 'User', unique: true },
    leftPoints: { type: Number, default: 0 },
    rightPoints: { type: Number, default: 0 },
    totalPairs: { type: Number, default: 0 },
    dailyPairs: { type: Number, default: 0 },
    lastPairDate: Date,
    flushDate: Date
  },
  { timestamps: true }
);

export default mongoose.model('BinaryPoint', schema);
