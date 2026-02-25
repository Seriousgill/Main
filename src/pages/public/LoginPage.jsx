import { Link } from 'react-router-dom';
import Button from '../../components/Button';
import FormInput from '../../components/FormInput';

export default function LoginPage() {
  return (
    <div className="mx-auto max-w-md px-6 py-12">
      <form className="space-y-4 rounded-xl bg-card p-6 shadow-soft">
        <h1 className="text-2xl font-bold">Login</h1>
        <FormInput label="Email / Mobile" name="identity" />
        <FormInput label="Password" name="password" type="password" />
        <div className="text-right"><a href="#" className="text-sm text-primary">Forgot Password</a></div>
        <Button className="w-full">Login</Button>
        <p className="text-sm text-textSecondary">No account? <Link to="/register" className="text-primary">Register</Link></p>
      </form>
    </div>
  );
}
