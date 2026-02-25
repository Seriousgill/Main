import { Link, NavLink, Outlet } from 'react-router-dom';

const navItems = [
  { to: '/', label: 'Home' },
  { to: '/plans', label: 'Plans' },
  { to: '/about', label: 'About' },
  { to: '/contact', label: 'Contact' },
];

export default function PublicLayout() {
  return (
    <div className="min-h-screen bg-appbg">
      <nav className="sticky top-0 z-30 bg-card shadow-soft">
        <div className="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
          <Link to="/" className="text-xl font-extrabold text-primary">MLM Pro</Link>
          <div className="hidden items-center gap-5 md:flex">
            {navItems.map((item) => (
              <NavLink key={item.to} to={item.to} className="text-sm font-medium text-textSecondary hover:text-primary">{item.label}</NavLink>
            ))}
          </div>
          <div className="flex gap-2">
            <Link to="/login" className="rounded-xl border border-primary px-4 py-2 text-sm font-semibold text-primary">Login</Link>
            <Link to="/register" className="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white">Register</Link>
          </div>
        </div>
      </nav>
      <Outlet />
      <footer className="mt-12 bg-sidebar p-6 text-sm text-gray-300">
        <div className="mx-auto flex max-w-7xl flex-wrap justify-between gap-4">
          <p>© 2026 MLM Pro. All rights reserved.</p>
          <div className="flex gap-4">
            <a href="#">Terms</a><a href="#">Privacy</a><a href="#">Support</a>
          </div>
        </div>
      </footer>
    </div>
  );
}
