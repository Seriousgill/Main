import Table from '../../components/Table';
import { transactions } from '../../data/mockData';

export default function AdminTransactionsPage() {
  return <Table columns={['Date', 'Type', 'Amount', 'Status']} rows={transactions} />;
}
