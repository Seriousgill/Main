import { Link } from 'react-router-dom';

export default function HomePage() {
  return (
    <div className="max-w-5xl mx-auto p-8 space-y-4">
      <h1 className="text-3xl font-bold">Secure MLM Growth Platform</h1>
      <p>Register, buy packages, earn daily rewards, referral bonuses, and track your binary growth.</p>
      <div className="grid md:grid-cols-3 gap-4">
        {[
          ['Basic', '₹2,000', '₹80/day'],
          ['Diamond', '₹10,000', '₹250/day'],
          ['Crown', '₹20,000', '₹550/day']
        ].map((p) => (
          <div key={p[0]} className="border rounded p-4 bg-white">
            <h3 className="font-semibold">{p[0]}</h3><p>{p[1]}</p><p>{p[2]}</p>
          </div>
        ))}
      </div>
      <Link className="bg-blue-600 text-white px-4 py-2 rounded inline-block" to="/register">Start Now</Link>
    </div>
  );
}
