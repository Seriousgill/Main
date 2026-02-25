import Table from '../../components/Table';

const rows = [
  { user: 'Maya Singh', amount: '₹1,500', method: 'UPI', status: 'Pending', action: 'Approve/Reject' },
  { user: 'Rahul Roy', amount: '₹2,000', method: 'Bank', status: 'Approved', action: 'Updated' },
];

export default function WithdrawalManagementPage() {
  return <Table columns={['User', 'Amount', 'Method', 'Status', 'Action']} rows={rows} />;
}
