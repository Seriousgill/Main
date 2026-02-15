import mongoose from 'mongoose';

const packageSchema = new mongoose.Schema(
  {
    name: { type: String, unique: true, required: true },
    price: Number,
    dailyReward: Number,
    referralBonus: Number,
    pointValue: Number,
    maxCap: Number,
    isActive: { type: Boolean, default: true }
  },
  { timestamps: true }
);

export default mongoose.model('Package', packageSchema);
