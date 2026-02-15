import mongoose from 'mongoose';
import bcrypt from 'bcryptjs';

const userSchema = new mongoose.Schema(
  {
    name: { type: String, required: true, trim: true },
    email: { type: String, required: true, unique: true, lowercase: true },
    phone: { type: String, required: true },
    password: { type: String, required: true, minlength: 6 },
    role: { type: String, enum: ['user', 'admin'], default: 'user' },
    sponsorId: { type: mongoose.Schema.Types.ObjectId, ref: 'User' },
    placementId: { type: mongoose.Schema.Types.ObjectId, ref: 'User' },
    position: { type: String, enum: ['left', 'right'] },
    packageId: { type: mongoose.Schema.Types.ObjectId, ref: 'Package' },
    packagePrice: { type: Number, default: 0 },
    dailyReward: { type: Number, default: 0 },
    totalReceived: { type: Number, default: 0 },
    maxCap: { type: Number, default: 0 },
    isActive: { type: Boolean, default: false },
    isKycVerified: { type: Boolean, default: false },
    bankDetails: {
      accountName: String,
      accountNumber: String,
      ifsc: String,
      bankName: String,
      upi: String
    },
    refreshTokens: [{ type: String }],
    emailVerificationToken: String,
    emailVerified: { type: Boolean, default: false },
    resetToken: String,
    resetTokenExpiry: Date,
    lastRepurchaseDate: Date
  },
  { timestamps: true }
);

userSchema.pre('save', async function save(next) {
  if (!this.isModified('password')) return next();
  this.password = await bcrypt.hash(this.password, 10);
  next();
});

userSchema.methods.comparePassword = function comparePassword(password) {
  return bcrypt.compare(password, this.password);
};

export default mongoose.model('User', userSchema);
