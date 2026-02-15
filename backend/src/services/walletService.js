import Wallet from '../models/Wallet.js';
import Transaction from '../models/Transaction.js';

export const getOrCreateWallet = async (userId) => {
  let wallet = await Wallet.findOne({ userId });
  if (!wallet) wallet = await Wallet.create({ userId });
  return wallet;
};

export const creditWallet = async ({ userId, field, amount, source, description }) => {
  const wallet = await getOrCreateWallet(userId);
  wallet[field] += amount;
  await wallet.save();
  await Transaction.create({ userId, amount, type: 'credit', source, description });
  return wallet;
};

export const debitWallet = async ({ userId, field, amount, source, description }) => {
  const wallet = await getOrCreateWallet(userId);
  if (wallet[field] < amount) throw new Error('Insufficient wallet balance');
  wallet[field] -= amount;
  await wallet.save();
  await Transaction.create({ userId, amount, type: 'debit', source, description });
  return wallet;
};
