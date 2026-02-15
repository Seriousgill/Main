import { useEffect, useState } from 'react';
import api from '../../api/client';

export default function AdminUsersPage() {
  const [users, setUsers] = useState([]);
  useEffect(() => { api.get('/admin/users').then((res) => setUsers(res.data)); }, []);
  return <div className="bg-white p-4 rounded shadow"><h3 className="font-semibold">Users</h3>{users.map((u) => <p key={u._id}>{u.name} - {u.email} - {u.isActive ? 'Active' : 'Inactive'}</p>)}</div>;
}
