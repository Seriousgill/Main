import Button from '../../components/Button';
import Card from '../../components/Card';
import FormInput from '../../components/FormInput';

export default function ProfilePage() {
  return (
    <div className="space-y-6">
      <Card title="Edit Profile"><div className="grid gap-4 md:grid-cols-2"><FormInput label="Full Name" /><FormInput label="Email" /><FormInput label="Mobile" /></div><Button className="mt-4">Save Profile</Button></Card>
      <Card title="Change Password"><div className="grid gap-4 md:grid-cols-2"><FormInput type="password" label="Current Password" /><FormInput type="password" label="New Password" /></div><Button className="mt-4">Update Password</Button></Card>
      <Card title="Bank & KYC"><div className="grid gap-4 md:grid-cols-2"><FormInput label="Bank Account" /><FormInput label="IFSC Code" /><FormInput label="UPI ID" /><FormInput label="KYC Document URL" /></div><Button className="mt-4">Update Details</Button></Card>
    </div>
  );
}
