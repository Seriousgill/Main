export default function Button({ children, variant = 'primary', className = '', ...props }) {
  const variants = {
    primary: 'bg-primary text-white hover:bg-blue-900',
    success: 'bg-success text-white hover:bg-green-700',
    danger: 'bg-danger text-white hover:bg-red-700',
    gradient: 'bg-gradient-to-r from-purpleStart to-purpleEnd text-white',
    outline: 'border border-primary text-primary hover:bg-blue-50',
  };

  return (
    <button className={`rounded-xl px-4 py-2 font-semibold transition ${variants[variant]} ${className}`} {...props}>
      {children}
    </button>
  );
}
