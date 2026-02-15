import { BrowserRouter, Navigate, Route, Routes } from 'react-router-dom';
import HomePage from './pages/public/HomePage';
import LoginPage from './pages/public/LoginPage';
import RegisterPage from './pages/public/RegisterPage';
import ForgotPasswordPage from './pages/public/ForgotPasswordPage';
import AppLayout from './layouts/AppLayout';
import ProtectedRoute from './components/ProtectedRoute';
import DashboardPage from './pages/user/DashboardPage';
import WalletPage from './pages/user/WalletPage';
import TeamPage from './pages/user/TeamPage';
import BinaryPage from './pages/user/BinaryPage';
import AdminDashboardPage from './pages/admin/AdminDashboardPage';
import AdminUsersPage from './pages/admin/AdminUsersPage';
import AdminWithdrawalsPage from './pages/admin/AdminWithdrawalsPage';

export default function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<HomePage />} />
        <Route path="/login" element={<LoginPage />} />
        <Route path="/register" element={<RegisterPage />} />
        <Route path="/forgot-password" element={<ForgotPasswordPage />} />

        <Route path="/" element={<ProtectedRoute><AppLayout /></ProtectedRoute>}>
          <Route path="dashboard" element={<DashboardPage />} />
          <Route path="wallet" element={<WalletPage />} />
          <Route path="team" element={<TeamPage />} />
          <Route path="binary" element={<BinaryPage />} />
          <Route path="admin" element={<ProtectedRoute admin><AdminDashboardPage /></ProtectedRoute>} />
          <Route path="admin/users" element={<ProtectedRoute admin><AdminUsersPage /></ProtectedRoute>} />
          <Route path="admin/withdrawals" element={<ProtectedRoute admin><AdminWithdrawalsPage /></ProtectedRoute>} />
        </Route>

        <Route path="*" element={<Navigate to="/" replace />} />
      </Routes>
    </BrowserRouter>
  );
}
