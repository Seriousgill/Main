import BinaryPoint from '../models/BinaryPoint.js';
import Transaction from '../models/Transaction.js';
import User from '../models/User.js';

export const tree = async (req, res) => {
  const me = await User.findById(req.user._id).select('name');
  const left = await User.findOne({ placementId: req.user._id, position: 'left' }).select('name');
  const right = await User.findOne({ placementId: req.user._id, position: 'right' }).select('name');
  const points = await BinaryPoint.findOne({ userId: req.user._id });
  res.json({ me, left, right, points });
};

export const pairsHistory = async (req, res) => {
  const rows = await Transaction.find({ userId: req.user._id, source: 'binary' }).sort({ createdAt: -1 });
  res.json(rows);
};
