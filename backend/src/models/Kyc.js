import mongoose from 'mongoose';

const schema = new mongoose.Schema(
  {
    userId: { type: mongoose.Schema.Types.ObjectId, ref: 'User' },
    documentType: String,
    documentNumber: String,
    frontImage: String,
    backImage: String,
    status: { type: String, enum: ['pending', 'approved', 'rejected'], default: 'pending' },
    submittedAt: Date,
    verifiedAt: Date
  },
  { timestamps: true }
);

export default mongoose.model('Kyc', schema);
