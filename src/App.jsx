import {
  CircleDollarSign,
  Gift,
  LayoutDashboard,
  LifeBuoy,
  LogOut,
  Package,
  Settings,
  ShieldCheck,
  Ticket,
  User,
  Users,
  Wallet,
} from 'lucide-react';
import { Navigate, Route, Routes } from 'react-router-dom';
import AppLayout from './layouts/AppLayout';
import PublicLayout from './layouts/PublicLayout';
import AboutPage from './pages/public/AboutPage';
import ContactPage from './pages/public/ContactPage';
import LandingPage from './pages/public/LandingPage';
import LoginPage from './pages/public/LoginPage';
import PlansPage from './pages/public/PlansPage';
import RegisterPage from './pages/public/RegisterPage';
import BuyPlanPage from './pages/user/BuyPlanPage';
import DailyTaskPage from './pages/user/DailyTaskPage';
import DashboardPage from './pages/user/DashboardPage';
import LuckyWheelPage from './pages/user/LuckyWheelPage';
import ProfilePage from './pages/user/ProfilePage';
import ReferralsPage from './pages/user/ReferralsPage';
import SupportPage from './pages/user/SupportPage';
import TransactionsPage from './pages/user/TransactionsPage';
import WalletPage from './pages/user/WalletPage';
import WithdrawPage from './pages/user/WithdrawPage';
import AdminDashboardPage from './pages/admin/AdminDashboardPage';
import AdminLuckyWheelPage from './pages/admin/AdminLuckyWheelPage';
import AdminTransactionsPage from './pages/admin/AdminTransactionsPage';
import PlanManagementPage from './pages/admin/PlanManagementPage';
import SystemSettingsPage from './pages/admin/SystemSettingsPage';
import UserManagementPage from './pages/admin/UserManagementPage';
import WithdrawalManagementPage from './pages/admin/WithdrawalManagementPage';

const userMenu = [
  { to: '/app/dashboard', label: 'Dashboard', icon: LayoutDashboard },
  { to: '/app/buy-plan', label: 'Buy Plan', icon: Package },
  { to: '/app/daily-task', label: 'Daily Task', icon: ShieldCheck },
  { to: '/app/referrals', label: 'Referrals', icon: Users },
  { to: '/app/lucky-wheel', label: 'Lucky Wheel', icon: Gift },
  { to: '/app/wallet', label: 'Wallet', icon: Wallet },
  { to: '/app/withdraw', label: 'Withdraw', icon: CircleDollarSign },
  { to: '/app/transactions', label: 'Transactions', icon: Ticket },
  { to: '/app/profile', label: 'Profile', icon: User },
  { to: '/app/support', label: 'Support', icon: LifeBuoy },
  { to: '/login', label: 'Logout', icon: LogOut },
];

const adminMenu = [
  { to: '/admin/dashboard', label: 'Dashboard', icon: LayoutDashboard },
  { to: '/admin/plans', label: 'Plan Management', icon: Package },
  { to: '/admin/users', label: 'User Management', icon: Users },
  { to: '/admin/withdrawals', label: 'Withdrawals', icon: CircleDollarSign },
  { to: '/admin/lucky-wheel', label: 'Lucky Wheel', icon: Gift },
  { to: '/admin/transactions', label: 'Transactions', icon: Ticket },
  { to: '/admin/settings', label: 'System Settings', icon: Settings },
  { to: '/login', label: 'Logout', icon: LogOut },
];

export default function App() {
  return (
    <Routes>
      <Route element={<PublicLayout />}>
        <Route path="/" element={<LandingPage />} />
        <Route path="/plans" element={<PlansPage />} />
        <Route path="/about" element={<AboutPage />} />
        <Route path="/contact" element={<ContactPage />} />
        <Route path="/register" element={<RegisterPage />} />
        <Route path="/login" element={<LoginPage />} />
      </Route>

      <Route path="/app" element={<AppLayout menu={userMenu} />}>
        <Route index element={<Navigate to="dashboard" replace />} />
        <Route path="dashboard" element={<DashboardPage />} />
        <Route path="buy-plan" element={<BuyPlanPage />} />
        <Route path="daily-task" element={<DailyTaskPage />} />
        <Route path="referrals" element={<ReferralsPage />} />
        <Route path="lucky-wheel" element={<LuckyWheelPage />} />
        <Route path="wallet" element={<WalletPage />} />
        <Route path="withdraw" element={<WithdrawPage />} />
        <Route path="transactions" element={<TransactionsPage />} />
        <Route path="profile" element={<ProfilePage />} />
        <Route path="support" element={<SupportPage />} />
      </Route>

      <Route path="/admin" element={<AppLayout menu={adminMenu} />}>
        <Route index element={<Navigate to="dashboard" replace />} />
        <Route path="dashboard" element={<AdminDashboardPage />} />
        <Route path="plans" element={<PlanManagementPage />} />
        <Route path="users" element={<UserManagementPage />} />
        <Route path="withdrawals" element={<WithdrawalManagementPage />} />
        <Route path="lucky-wheel" element={<AdminLuckyWheelPage />} />
        <Route path="transactions" element={<AdminTransactionsPage />} />
        <Route path="settings" element={<SystemSettingsPage />} />
      </Route>

      <Route path="*" element={<Navigate to="/" replace />} />
    </Routes>
  );
}
