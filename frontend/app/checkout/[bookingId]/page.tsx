'use client';

import { useState } from 'react';
import { apiPost } from '@/lib/api';

export default function CheckoutPage({ params }: { params: { bookingId: string } }) {
  const [message, setMessage] = useState('');

  async function pay() {
    try {
      const token = localStorage.getItem('token') || '';
      const order = await apiPost<any>('/payments/razorpay/order', { booking_id: Number(params.bookingId) }, token);
      setMessage(`Order created: ${order.order_id}. Continue with Razorpay checkout script integration.`);
    } catch (error) {
      setMessage((error as Error).message);
    }
  }

  return (
    <div className="max-w-xl mx-auto bg-white rounded border p-6">
      <h1 className="text-xl font-bold mb-4">Checkout</h1>
      <button onClick={pay} className="bg-cyan-600 text-white px-4 py-2 rounded">Pay with Razorpay</button>
      {message && <p className="mt-3 text-sm">{message}</p>}
    </div>
  );
}
