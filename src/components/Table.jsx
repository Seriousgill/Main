export default function Table({ columns, rows }) {
  return (
    <div className="overflow-x-auto rounded-xl bg-card shadow-soft">
      <table className="min-w-full">
        <thead className="bg-gray-50 text-left text-sm text-textSecondary">
          <tr>
            {columns.map((col) => (
              <th key={col} className="px-4 py-3 font-medium">{col}</th>
            ))}
          </tr>
        </thead>
        <tbody>
          {rows.map((row, idx) => (
            <tr key={idx} className="border-t border-gray-100 text-sm text-textPrimary">
              {Object.values(row).map((value, vIdx) => (
                <td key={vIdx} className="px-4 py-3">{value}</td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
