import { Bell, ChevronLeft, ChevronRight, Search } from 'lucide-react';
import { NavLink, Outlet } from 'react-router-dom';
import { useState } from 'react';

export default function AppLayout({ menu }) {
  const [collapsed, setCollapsed] = useState(false);
  return (
    <div className="flex min-h-screen bg-appbg">
      <aside className={`bg-sidebar p-4 text-white transition-all ${collapsed ? 'w-20' : 'w-64'}`}>
        <button className="mb-6 rounded-xl bg-gray-700 p-2" onClick={() => setCollapsed((s) => !s)}>
          {collapsed ? <ChevronRight size={18} /> : <ChevronLeft size={18} />}
        </button>
        <div className="space-y-2">
          {menu.map((item) => (
            <NavLink
              key={item.to}
              to={item.to}
              className={({ isActive }) => `flex items-center gap-3 rounded-xl px-3 py-2 text-sm ${isActive ? 'bg-primary' : 'hover:bg-gray-700'}`}
            >
              <item.icon size={18} /> {!collapsed && item.label}
            </NavLink>
          ))}
        </div>
      </aside>
      <div className="flex-1">
        <header className="flex flex-wrap items-center justify-between gap-4 bg-card p-4 shadow-soft">
          <div className="relative max-w-sm flex-1">
            <Search className="absolute left-3 top-2.5 text-textSecondary" size={18} />
            <input className="w-full rounded-xl border border-gray-300 py-2 pl-10 pr-3" placeholder="Search..." />
          </div>
          <div className="flex items-center gap-4">
            <Bell className="text-textSecondary" />
            <span className="rounded-xl bg-green-100 px-3 py-1 text-sm font-semibold text-success">₹12,480</span>
            <button className="h-9 w-9 rounded-full bg-primary text-sm font-semibold text-white">AS</button>
          </div>
        </header>
        <main className="p-6">
          <Outlet />
        </main>
      </div>
    </div>
  );
}
