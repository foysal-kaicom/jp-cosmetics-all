import RewardItem from "@/components/user/RewardItem";
import { Gift } from "lucide-react";

export default function Rewards() {
    return (
        <div className="space-y-6">
            <div className="bg-gradient-to-br from-pink-500 to-rose-600 text-white rounded-2xl p-8 shadow-xl">
                <div className="flex items-center justify-between mb-6">
                    <div>
                        <h2 className="text-3xl font-bold mb-2">150 Points</h2>
                        <p className="text-pink-100">You're 50 points away from your next reward!</p>
                    </div>
                    <Gift className="w-16 h-16 opacity-20" />
                </div>
                
                <div className="bg-white/20 rounded-full h-3 mb-4">
                    <div className="bg-white rounded-full h-3 w-3/4"></div>
                </div>
                
                <p className="text-sm text-pink-100">Earn 1 point for every $1 spent</p>
            </div>

            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 className="text-xl font-bold text-gray-900 mb-4">Available Rewards</h3>
                <div className="space-y-3">
                    <RewardItem title="$10 Off Your Next Order" points={100} />
                    <RewardItem title="Free Shipping" points={50} />
                    <RewardItem title="Exclusive Product Sample" points={75} />
                </div>
            </div>
        </div>
    );
}