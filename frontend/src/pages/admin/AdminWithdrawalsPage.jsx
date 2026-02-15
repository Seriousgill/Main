import { useEffect, useState } from 'react';
import api from '../../api/client';

export default function AdminWithdrawalsPage() {
  const [rows, setRows] = useState([]);
  const load = () => api.get('/admin/withdrawals').then((res) => setRows(res.data));
  useEffect(load, []);
  return <div className="space-y-2">{rows.map((r) => <div className="bg-white p-3 rounded shadow flex justify-between" key={r._id}><span>{r.userId?.name} ₹{r.amount}</span><button className="bg-green-600 text-white px-3 rounded" onClick={async () => { await api.put(`/admin/withdrawals/${r._id}`, { status: 'approved' }); load(); }}>Approve</button></div>)}</div>;
}
