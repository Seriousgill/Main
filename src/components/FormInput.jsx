export default function FormInput({ label, error, ...props }) {
  return (
    <label className="block">
      <span className="mb-1 block text-sm font-medium text-textPrimary">{label}</span>
      <input
        className={`w-full rounded-xl border px-3 py-2 outline-none transition focus:ring-2 focus:ring-primary ${error ? 'border-danger' : 'border-gray-300'}`}
        {...props}
      />
      {error ? <span className="mt-1 block text-xs text-danger">{error}</span> : null}
    </label>
  );
}
