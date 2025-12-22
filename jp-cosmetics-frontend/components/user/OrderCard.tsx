import { Package } from "lucide-react";
import { CheckCircle } from "lucide-react";

import { Order } from "@/types/user";
import { formatDate } from "@/utils/formatDate";

type OrderCardProps = {
  order: Order;
};

function OrderCard({ order }: OrderCardProps) {
  const statusColors: Record<string, string> = {
    pending: "bg-yellow-100 text-yellow-800",
    confirm: "bg-blue-100 text-blue-800",
    dispatched: "bg-purple-100 text-purple-800",
    delivered: "bg-green-100 text-green-800",
    cancelled: "bg-red-100 text-red-800",
    returned: "bg-pink-100 text-pink-800",
    success: "bg-teal-100 text-teal-800",
  };
  return (
    <div className="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:bg-pink-50/50 transition-colors">
      <div className="flex items-center gap-4">
        <div className="w-12 h-12 bg-gradient-to-br from-pink-100 to-rose-100 rounded-lg flex items-center justify-center">
          <Package className="w-6 h-6 text-pink-600" />
        </div>
        <div>
          <p className="font-semibold text-gray-900">{order.order_number}</p>
          <p className="text-sm text-gray-600">
            {formatDate(order.created_at)}
          </p>
        </div>
      </div>
      <div className="text-right">
        <p className="font-bold text-gray-900">{order.payable_total}</p>
        <span
          className={`text-xs px-3 py-1.5 rounded-full flex gap-1 capitalize font-semibold ${
            statusColors[order.status] || "bg-gray-100 text-gray-800"
          }`}
        >
          {" "}
          <CheckCircle className="w-4 h-4" />
          {order.status}
        </span>
      </div>
    </div>
  );
}

export default OrderCard;
