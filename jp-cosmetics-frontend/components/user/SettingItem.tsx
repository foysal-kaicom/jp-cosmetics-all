import { Edit2 } from "lucide-react";

type Props = {
  title: string;
  description: string;
  danger?: boolean;
  onClick?: () => void;
};

function SettingItem({ title, description, danger ,onClick }: Props) {
    return (
        <div className="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
            <div>
                <h3 className={`font-semibold mb-1 ${danger ? 'text-red-600' : 'text-gray-900'}`}>
                    {title}
                </h3>
                <p className="text-sm text-gray-600">{description}</p>
            </div>
            <button onClick={onClick} className={`px-4 py-2 text-sm font-semibold rounded-lg transition-colors cursor-pointer ${
                danger 
                    ? 'text-red-600 hover:bg-red-50' 
                    : 'text-pink-600 hover:bg-pink-50'
            }`}>
                <Edit2 className="w-5 h-5" />
            </button>
        </div>
    );
}

export default SettingItem;