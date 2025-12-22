import { Gift } from "lucide-react";

interface RewardItemProps {
    title: string;
    points: number;
}

function RewardItem({ title, points }: RewardItemProps) {
    return (
        <div className="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:bg-pink-50/50 transition-colors">
            <div className="flex items-center gap-3">
                <Gift className="w-5 h-5 text-pink-600" />
                <p className="font-semibold text-gray-900">{title}</p>
            </div>
            <button className="px-4 py-2 bg-gradient-to-r from-pink-500 to-rose-600 text-white text-sm font-semibold rounded-lg hover:shadow-lg transition-all">
                {points}
            </button>
        </div>
    );
}

export default RewardItem;