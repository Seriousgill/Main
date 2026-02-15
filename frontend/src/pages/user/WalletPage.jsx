import { useEffect, useState } from 'react';
import api from '../../api/client';

export default function WalletPage() {
  const [balance, setBalance] = useState({});
  const [history, setHistory] = useState([]);
  const [amount, setAmount] = useState(500);

  const load = async () => {
    const [b, h] = await Promise.all([api.get('/wallet/balance'), api.get('/wallet/withdrawal-history')]);
    setBalance(b.data || {});
    setHistory(h.data || []);
  };
  useEffect(() => { load(); }, []);

  return <div className="space-y-4">
    <h2 className="text-xl font-semibold">Wallet & Withdrawals</h2>
    <p>Earning: ₹{balance.earningWallet || 0} | Referral: ₹{balance.referralWallet || 0} | Matching: ₹{balance.matchingWallet || 0}</p>
    <div className="flex gap-2">
      <input type="number" className="border p-2" value={amount} onChange={(e) => setAmount(e.target.value)} />
      <button className="bg-blue-600 text-white px-4 rounded" onClick={async () => { await api.post('/wallet/withdrawal-request', { amount }); await load(); }}>Request Withdrawal</button>
    </div>
    <ul className="bg-white rounded shadow p-3 space-y-2">{history.map((h) => <li key={h._id} className="text-sm">₹{h.amount} - {h.status}</li>)}</ul>
  </div>;
}
