import { Link, Outlet } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

export default function AppLayout() {
  const { user, logout } = useAuth();
  return (
    <div className="min-h-screen">
      <header className="bg-slate-900 text-white p-4 flex justify-between">
        <div>MLM Platform</div>
        <nav className="flex gap-4 items-center text-sm">
          <Link to="/dashboard">Dashboard</Link>
          <Link to="/wallet">Wallet</Link>
          <Link to="/team">Team</Link>
          {user?.role === 'admin' && <Link to="/admin">Admin</Link>}
          <button onClick={logout} className="bg-red-500 px-3 py-1 rounded">Logout</button>
        </nav>
      </header>
      <main className="p-4"><Outlet /></main>
    </div>
  );
}
