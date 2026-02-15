import { useState } from 'react';
import { useNavigate, useSearchParams } from 'react-router-dom';
import api from '../../api/client';

export default function RegisterPage() {
  const [params] = useSearchParams();
  const [form, setForm] = useState({ name: '', email: '', phone: '', password: '', sponsorCode: params.get('ref') || '' });
  const [message, setMessage] = useState('');
  const nav = useNavigate();

  const submit = async (e) => {
    e.preventDefault();
    await api.post('/auth/register', form);
    setMessage('Registration successful. Please login.');
    setTimeout(() => nav('/login'), 1000);
  };

  return <form onSubmit={submit} className="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow space-y-3">
    <h2 className="text-xl font-semibold">Register</h2>
    {['name', 'email', 'phone', 'password', 'sponsorCode'].map((f) => (
      <input key={f} type={f === 'password' ? 'password' : 'text'} className="border p-2 w-full" placeholder={f} value={form[f]} onChange={(e) => setForm({ ...form, [f]: e.target.value })} />
    ))}
    <button className="bg-blue-600 text-white w-full p-2 rounded">Create Account</button>
    <p className="text-green-600 text-sm">{message}</p>
  </form>;
}
