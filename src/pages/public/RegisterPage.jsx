import { Link } from 'react-router-dom';
import Button from '../../components/Button';
import FormInput from '../../components/FormInput';
import { useFormValidation } from '../../hooks/useFormValidation';

const initial = { fullName: '', email: '', mobile: '', password: '', confirmPassword: '', referralCode: '', terms: false };

const validate = (v) => {
  const e = {};
  if (!v.fullName) e.fullName = 'Full name is required';
  if (!v.email.includes('@')) e.email = 'Valid email required';
  if (v.mobile.length < 10) e.mobile = 'Mobile must be 10 digits';
  if (v.password.length < 6) e.password = 'Minimum 6 characters';
  if (v.password !== v.confirmPassword) e.confirmPassword = 'Passwords do not match';
  if (!v.terms) e.terms = 'Please accept terms';
  return e;
};

export default function RegisterPage() {
  const { values, errors, submitted, handleChange, handleSubmit } = useFormValidation(initial, validate);

  return (
    <div className="mx-auto max-w-lg px-6 py-12">
      <form onSubmit={handleSubmit()} className="rounded-xl bg-card p-6 shadow-soft space-y-4">
        <h1 className="text-2xl font-bold">Create Account</h1>
        <FormInput label="Full Name" name="fullName" value={values.fullName} onChange={handleChange} error={errors.fullName} />
        <FormInput label="Email" name="email" value={values.email} onChange={handleChange} error={errors.email} />
        <FormInput label="Mobile" name="mobile" value={values.mobile} onChange={handleChange} error={errors.mobile} />
        <FormInput label="Password" type="password" name="password" value={values.password} onChange={handleChange} error={errors.password} />
        <FormInput label="Confirm Password" type="password" name="confirmPassword" value={values.confirmPassword} onChange={handleChange} error={errors.confirmPassword} />
        <FormInput label="Referral Code" name="referralCode" value={values.referralCode} onChange={handleChange} />
        <label className="flex items-start gap-2 text-sm text-textSecondary"><input type="checkbox" name="terms" checked={values.terms} onChange={handleChange} />Accept Terms & Conditions</label>
        {errors.terms ? <p className="text-xs text-danger">{errors.terms}</p> : null}
        {submitted ? <p className="rounded-xl bg-green-100 p-3 text-sm text-success">Registration successful.</p> : null}
        <Button className="w-full">Register</Button>
        <p className="text-sm text-textSecondary">Already have an account? <Link to="/login" className="text-primary">Login</Link></p>
      </form>
    </div>
  );
}
