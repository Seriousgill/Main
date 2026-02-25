export default function Card({ title, children, className = '' }) {
  return (
    <section className={`rounded-xl bg-card p-6 shadow-soft ${className}`}>
      {title ? <h3 className="mb-4 text-lg font-semibold text-textPrimary">{title}</h3> : null}
      {children}
    </section>
  );
}
