import { useEffect, useState } from 'react';
import api from '../../api/client';

export default function BinaryPage() {
  const [tree, setTree] = useState(null);
  useEffect(() => { api.get('/binary/tree').then((res) => setTree(res.data)); }, []);
  if (!tree) return <p>Loading...</p>;
  return <div className="bg-white p-4 shadow rounded space-y-2">
    <h2 className="text-xl font-semibold">Binary Tree</h2>
    <p>Current: {tree.me?.name}</p><p>Left: {tree.left?.name || 'Empty'}</p><p>Right: {tree.right?.name || 'Empty'}</p>
    <p>Points L/R: {tree.points?.leftPoints || 0}/{tree.points?.rightPoints || 0}</p>
  </div>;
}
