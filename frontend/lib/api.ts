const API_BASE = process.env.NEXT_PUBLIC_API_BASE || 'http://localhost:8000/api';

export async function apiGet<T>(path: string): Promise<T> {
  const response = await fetch(`${API_BASE}${path}`, { cache: 'no-store' });
  if (!response.ok) throw new Error(`GET ${path} failed`);
  return response.json();
}

export async function apiPost<T>(path: string, body: unknown, token?: string): Promise<T> {
  const response = await fetch(`${API_BASE}${path}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      ...(token ? { Authorization: `Bearer ${token}` } : {}),
    },
    body: JSON.stringify(body),
  });

  if (!response.ok) {
    const payload = await response.json().catch(() => ({}));
    throw new Error(payload.message || `POST ${path} failed`);
  }

  return response.json();
}
