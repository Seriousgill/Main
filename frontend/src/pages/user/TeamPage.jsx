import { useEffect, useState } from 'react';
import api from '../../api/client';

export default function TeamPage() {
  const [directs, setDirects] = useState([]);
  const [link, setLink] = useState('');
  useEffect(() => {
    api.get('/referral/directs').then((res) => setDirects(res.data));
    api.get('/referral/link').then((res) => setLink(res.data.link));
  }, []);
  return <div className="space-y-4">
    <h2 className="text-xl font-semibold">My Team</h2>
    <p className="text-sm">Referral Link: <span className="text-blue-600">{link}</span></p>
    <div className="bg-white rounded p-4 shadow">{directs.map((u) => <p key={u._id}>{u.name} • {new Date(u.createdAt).toLocaleDateString()}</p>)}</div>
  </div>;
}
