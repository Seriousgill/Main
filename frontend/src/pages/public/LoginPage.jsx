import { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import api from '../../api/client';
import { useAuth } from '../../context/AuthContext';

export default function LoginPage() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const nav = useNavigate();
  const { login } = useAuth();

  const onSubmit = async (e) => {
    e.preventDefault();
    try {
      const { data } = await api.post('/auth/login', { email, password });
      login(data);
      nav('/dashboard');
    } catch (err) {
      setError(err.response?.data?.message || 'Login failed');
    }
  };

  return <form onSubmit={onSubmit} className="max-w-md mx-auto mt-16 bg-white p-6 rounded shadow space-y-3">
    <h2 className="text-2xl font-semibold">Login</h2>
    <input className="border p-2 w-full" placeholder="Email" onChange={(e) => setEmail(e.target.value)} />
    <input className="border p-2 w-full" type="password" placeholder="Password" onChange={(e) => setPassword(e.target.value)} />
    {error && <p className="text-red-600 text-sm">{error}</p>}
    <button className="bg-slate-900 text-white p-2 w-full rounded">Login</button>
    <Link to="/forgot-password" className="text-blue-600 text-sm">Forgot password?</Link>
  </form>;
}
