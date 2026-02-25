/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        primary: '#1E3A8A',
        success: '#16A34A',
        danger: '#DC2626',
        warning: '#F59E0B',
        sidebar: '#111827',
        appbg: '#F3F4F6',
        card: '#FFFFFF',
        textPrimary: '#111827',
        textSecondary: '#6B7280',
        purpleStart: '#6D28D9',
        purpleEnd: '#9333EA',
      },
      borderRadius: {
        xl: '12px',
      },
      boxShadow: {
        soft: '0 4px 12px rgba(17, 24, 39, 0.08)',
      },
    },
  },
  plugins: [],
};
