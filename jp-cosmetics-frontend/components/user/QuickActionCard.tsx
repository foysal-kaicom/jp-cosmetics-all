import { 
    ChevronRight
} from "lucide-react";

interface QuickActionCardProps {
    icon: React.ComponentType<{ className?: string }>;
    title: string;
    description: string;
    action: string;
}

function QuickActionCard({ icon: Icon, title, description, action }: QuickActionCardProps) {
  return (
    <div className="bg-gradient-to-br from-pink-50 to-rose-50 rounded-2xl p-6 border border-pink-100 hover:shadow-lg transition-all cursor-pointer group">
      <Icon className="w-8 h-8 text-pink-600 mb-3" />
      <h3 className="font-bold text-gray-900 mb-1">{title}</h3>
      <p className="text-sm text-gray-600 mb-4">{description}</p>
      <button className="text-pink-600 font-semibold text-sm flex items-center gap-1 group-hover:gap-2 transition-all">
        {action}
        <ChevronRight className="w-4 h-4" />
      </button>
    </div>
  );
}

export default QuickActionCard;