import { useState } from 'react';
import api from '../../api/client';

export default function ForgotPasswordPage() {
  const [email, setEmail] = useState('');
  const [msg, setMsg] = useState('');
  return <form className="max-w-md mx-auto mt-16 bg-white p-6 rounded shadow" onSubmit={async (e) => {
    e.preventDefault();
    const { data } = await api.post('/auth/forgot-password', { email });
    setMsg(data.message);
  }}>
    <h2 className="text-xl mb-3">Forgot password</h2>
    <input className="border p-2 w-full" placeholder="Email" onChange={(e) => setEmail(e.target.value)} />
    <button className="bg-slate-800 text-white p-2 rounded mt-2 w-full">Submit</button>
    <p className="text-sm mt-2">{msg}</p>
  </form>;
}
