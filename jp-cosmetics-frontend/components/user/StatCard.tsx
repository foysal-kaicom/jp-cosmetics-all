import { ReactNode } from "react";

interface StatCardProps {
  icon: React.ComponentType<{ className?: string }>;
  label: string;
  value: null | number | string;
  change: string;
  color: string;
}

function StatCard({ icon: Icon, label, value, change, color }: StatCardProps) {

  return (
    <div className="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
      <div
        className={`w-12 h-12 rounded-xl bg-gradient-to-br from-${color}-100 to-${color}-200 flex items-center justify-center mb-4`}
      >
        <Icon className={`w-6 h-6 text-${color}-600`} />
      </div>
      <p className="text-3xl font-bold text-gray-900 mb-1">{value}</p>
      <p className="text-sm font-semibold text-gray-900">{label}</p>
      <p className="text-xs text-gray-500 mt-1">{change}</p>
    </div>
  );
}

export default StatCard;
