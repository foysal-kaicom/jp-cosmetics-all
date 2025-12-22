"use client";

import { useEffect, useState } from "react";
import {
  MapPin,
  CreditCard,
  ShoppingBag,
  ChevronRight,
  Plus,
  Check,
  Truck,
  Shield,
} from "lucide-react";
import { useCartStore } from "@/store/cart-store";
import { useAuthStore } from "@/store/authStore";
import apiClient from "@/lib/axios";
import { Address } from "@/types/user";
import { addressService } from "@/services/user.service";
import { useRouter } from "next/navigation";
import { showToast } from "@/utils/toast";
import Link from "next/link";

export default function CheckoutPage() {
  const router = useRouter();
  const [selectedAddress, setSelectedAddress] = useState<Address | null>(null);
  const [selectedPayment, setSelectedPayment] = useState(0);
  const [promoCode, setPromoCode] = useState("");
  const [promoApplied, setPromoApplied] = useState(false);

  const { items, clearCart } = useCartStore();

  const user = useAuthStore().user;

  // ================= ADDRESSES =================
  const [addresses, setAddresses] = useState<Address[]>([]);

  // ================= PAYMENT METHODS =================
  const paymentMethods = [
    {
      id: 1,
      type: "COD",
      name: "Cash On Delivery",
      charge: 60,
      isDefault: true,
    },
    {
      id: 2,
      type: "online",
      name: "Online Payment",
      charge: 120,
    },
  ];

  const selectedPaymentCharge = paymentMethods[selectedPayment]?.charge ?? 0;

  // ================= CALCULATIONS =================
  const subtotal = items.reduce(
    (sum, item) => sum + item.unit_price * item.quantity,
    0
  );

  const discount = items.reduce((sum, item) => sum + item.discount_amount, 0);

  const promoDiscount = promoApplied ? subtotal * 0.05 : 0; // 5% promo
  const tax = 0; // 5% VAT

  const total =
    subtotal - discount - promoDiscount + tax + selectedPaymentCharge;

  const handleApplyPromo = () => {
    if (promoCode.trim()) {
      setPromoApplied(true);
    }
  };

  const fetchAddress = async () => {
    try {
      const data = await addressService.list();
      setAddresses(data);
    } catch (error) {
      console.error("Failed to fetch orders", error);
    } finally {
      // setLoading(false);
    }
  };

  useEffect(() => {
    fetchAddress();
  }, []);

  const handleOrder = async () => {
    if (!selectedAddress) {
      showToast.error("Please select a delivery address");
      return;
    }
    if (!user?.id) {
      showToast.error("Please login to place an order");
      return;
    }

    if (items.length === 0) {
      showToast.error("Your cart is empty");
      return;
    }

    const selectedPay = paymentMethods[selectedPayment];

    const payload = {
      products: items.map((item) => ({
        product_id: item.product_id,
        product_attribute_id: item.product_attribute_id,
        unit_price: item.unit_price,
        quantity: item.quantity,
        subtotal: item.subtotal,
        discount_amount: item.discount_amount,
        discount_percentage: item.discount_percentage ?? null,
      })),

      customer_id: user.id,

      receiver_name: user.name,
      receiver_phone: user.phone,
      receiver_email: user.email ?? null,

      shipping_city: selectedAddress?.city ?? "",
      shipping_area: selectedAddress?.area ?? "",
      shipping_location: selectedAddress?.address ?? "",
      customer_address_id: selectedAddress?.id ?? null,

      payment_status: "pending",
      payment_method: selectedPay.type, // "COD" | "online"

      delivery_charge: selectedPay.charge,
      order_note: promoApplied ? `Promo applied: ${promoCode}` : null,
    };

    try {
      const response = await apiClient.post("/order/place-order", payload);

      showToast.success("Order placed successfully!");

      clearCart();
      router.push(`/user/orders?order_id=${response.data.order_id}`);
    } catch (error: any) {
      showToast.error(
        error?.response?.data?.message ??
          "Failed to place order. Please try again."
      );
    }
  };

  // ================= EMPTY CART =================
  if (items.length === 0) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <h2 className="text-xl font-bold">Your cart is empty</h2>
      </div>
    );
  }

  // ================= UI =================
  return (
    <div className="min-h-screen bg-gray-50 py-8 px-4">
      <div className="max-w-7xl mx-auto">
        <h1 className="text-3xl font-bold mb-8">Checkout</h1>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
          {/* LEFT */}
          <div className="lg:col-span-2 space-y-6">
            {/* ADDRESS */}
            <div className="bg-white rounded-2xl p-6 border">
              <div className="flex items-center justify-between mb-6">
                <h2 className="text-xl font-bold flex items-center gap-2">
                  <MapPin /> Delivery Address
                </h2>
                <Link href="/user/addresses" className="text-pink-600 flex items-center gap-1">
                  <Plus className="w-4 h-4" /> Add New
                </Link>
              </div>

              {addresses.length > 0 ? (
                addresses.map((addr, index) => (
                  <div
                    key={index}
                    onClick={() => setSelectedAddress(addr)}
                    className={`border-2 rounded-xl p-4 mb-3 cursor-pointer ${
                      selectedAddress?.id === addr.id
                        ? "border-pink-500 bg-pink-50"
                        : "border-gray-200"
                    }`}
                  >
                    <div className="flex gap-3">
                      <div className="w-5 h-5 rounded-full border flex items-center justify-center">
                        {selectedAddress?.id === addr.id && (
                          <Check className="w-3 h-3 text-pink-600" />
                        )}
                      </div>
                      <div>
                        <p className="font-bold">{addr.title}</p>
                        <p className="text-sm">
                          {addr.city}, {addr.area}
                        </p>
                        <p className="text-sm text-gray-600">{addr.address}</p>
                      </div>
                    </div>
                  </div>
                ))
              ) : (
                <p className="text-gray-500 text-sm">
                  No addresses found. Add a new address.
                </p>
              )}
            </div>

            {/* PAYMENT */}
            <div className="bg-white rounded-2xl p-6 border">
              <h2 className="text-xl font-bold flex items-center gap-2 mb-6">
                <CreditCard /> Payment Method
              </h2>

              {paymentMethods.map((payment, index) => (
                <div
                  key={payment.id}
                  onClick={() => setSelectedPayment(index)}
                  className={`border-2 rounded-xl p-4 mb-3 cursor-pointer ${
                    selectedPayment === index
                      ? "border-pink-500 bg-pink-50"
                      : "border-gray-200"
                  }`}
                >
                  <div className="flex justify-between">
                    <p className="font-bold">{payment.name}</p>
                    <p className="font-semibold">৳ {payment.charge}</p>
                  </div>
                </div>
              ))}
            </div>

            {/* ORDER ITEMS */}
            <div className="bg-white rounded-2xl p-6 border">
              <h2 className="text-xl font-bold flex items-center gap-2 mb-6">
                <ShoppingBag /> Order Items ({items.length})
              </h2>

              {items.map((item) => (
                <div
                  key={`${item.product_id}-${item.product_attribute_id}`}
                  className="flex gap-4 pb-4 border-b last:border-0 border-pink-300 mb-2"
                >
                  <img
                    src={item.image}
                    className="w-20 h-20 rounded-xl object-cover"
                  />
                  <div className="flex-1">
                    <p className="font-bold">{item.product_name} ({item.attribute_value})</p>
                    <p className="text-sm text-gray-600">
                      Qty: {item.quantity}
                    </p>
                    <p className="font-bold mt-1">
                      ৳ {item.subtotal.toFixed(2)}
                    </p>
                  </div>
                </div>
              ))}
            </div>
          </div>

          {/* RIGHT */}
          <div className="bg-white rounded-2xl p-6 border sticky top-6 h-fit">
            <h2 className="text-xl font-bold mb-6">Order Summary</h2>

            {/* PROMO */}
            <div className="flex gap-2 mb-6">
              <input
                value={promoCode}
                onChange={(e) => setPromoCode(e.target.value)}
                disabled={promoApplied}
                placeholder="Promo code"
                className="border px-3 py-2 rounded-xl w-full"
              />
              <button
                onClick={handleApplyPromo}
                disabled={promoApplied}
                className="bg-black text-white px-4 rounded-xl"
              >
                Apply
              </button>
            </div>

            {/* PRICE */}
            <div className="space-y-2 border-y py-4">
              <div className="flex justify-between">
                <span>Subtotal</span>
                <span>৳ {subtotal.toFixed(2)}</span>
              </div>

              <div className="flex justify-between text-green-600">
                <span>Discount</span>
                <span>- ৳ {discount.toFixed(2)}</span>
              </div>

              {promoApplied && (
                <div className="flex justify-between text-green-600">
                  <span>Promo</span>
                  <span>- ৳ {promoDiscount.toFixed(2)}</span>
                </div>
              )}

              {/* <div className="flex justify-between">
                <span>VAT (5%)</span>
                <span>৳ {tax.toFixed(2)}</span>
              </div> */}

              <div className="flex justify-between">
                <span>Payment Charge</span>
                <span>৳ {selectedPaymentCharge.toFixed(2)}</span>
              </div>
            </div>

            <div className="flex justify-between font-bold text-lg py-4">
              <span>Total</span>
              <span className="text-pink-600">৳ {total.toFixed(2)}</span>
            </div>

            <button
              onClick={handleOrder}
              className="w-full py-4 bg-pink-600 text-white rounded-xl font-bold flex items-center justify-center gap-2 cursor-pointer"
            >
              Place Order <ChevronRight />
            </button>

            {/* TRUST */}
            <div className="mt-6 space-y-2 text-sm text-gray-600">
              <div className="flex gap-2">
                <Shield className="text-green-600" /> Secure payment
              </div>
              <div className="flex gap-2">
                <Truck className="text-blue-600" /> Easy returns
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
