"use client";

import { create } from "zustand";
import { persist } from "zustand/middleware";

export type CartItem = {
  product_id: number;
  product_name: string;
  attribute_value: string;
  product_attribute_id: number | null;
  unit_price: number;
  quantity: number;
  subtotal: number;
  discount_amount: number;
  discount_percentage: number | null;
  image: string;
};

type CartState = {
  items: CartItem[];

  addItem: (item: Omit<CartItem, "subtotal">) => void;
  removeItem: (product_id: number, product_attribute_id: number | null) => void;
  updateQuantity: (
    product_id: number,
    product_attribute_id: number | null,
    quantity: number
  ) => void;
  clearCart: () => void;

  cartSubtotal: () => number;
  cartDiscount: () => number;
  cartTotal: () => number;
};

export const useCartStore = create<CartState>()(
  persist(
    (set, get) => ({
      items: [],

      addItem: (item) =>
        set((state) => {
          const existing = state.items.find(
            (i) =>
              i.product_id === item.product_id &&
              i.product_attribute_id === item.product_attribute_id
          );

          if (existing) {
            return {
              items: state.items.map((i) =>
                i.product_id === item.product_id &&
                i.product_attribute_id === item.product_attribute_id
                  ? {
                      ...i,
                      quantity: i.quantity + item.quantity,
                      subtotal:
                        (i.quantity + item.quantity) * i.unit_price -
                        i.discount_amount,
                    }
                  : i
              ),
            };
          }

          const subtotal =
            item.unit_price * item.quantity - item.discount_amount;

          return {
            items: [...state.items, { ...item, subtotal }],
          };
        }),

      removeItem: (product_id, product_attribute_id) =>
        set((state) => ({
          items: state.items.filter(
            (i) =>
              !(
                i.product_id === product_id &&
                i.product_attribute_id === product_attribute_id
              )
          ),
        })),

      updateQuantity: (product_id, product_attribute_id, quantity) =>
        set((state) => ({
          items: state.items.map((i) =>
            i.product_id === product_id &&
            i.product_attribute_id === product_attribute_id
              ? {
                  ...i,
                  quantity,
                  subtotal: quantity * i.unit_price - i.discount_amount,
                }
              : i
          ),
        })),

      clearCart: () => set({ items: [] }),

      cartSubtotal: () =>
        get().items.reduce(
          (sum, item) => sum + item.unit_price * item.quantity,
          0
        ),

      cartDiscount: () =>
        get().items.reduce((sum, item) => sum + item.discount_amount, 0),

      cartTotal: () =>
        get().items.reduce((sum, item) => sum + item.subtotal, 0),
    }),
    {
      name: "ecommerce-cart",
    }
  )
);
