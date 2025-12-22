// stores/useWishlistStore.ts
import { create } from "zustand";
import {wishListService} from "@/services/user.service";
import type {Product} from "@/types/index"

type WishlistState = {
  items: Product[];
  loading: boolean;

  fetch: () => Promise<void>;
  add: (productId: number) => Promise<void>;
  remove: (productId: number) => Promise<void>;
};

export const useWishlistStore = create<WishlistState>((set, get) => ({
  items: [],
  loading: false,

  fetch: async () => {
    set({ loading: true });
    try {
      const data = await wishListService.list();
      set({ items: data });
    } finally {
      set({ loading: false });
    }
  },

  add: async (productId) => {
    await wishListService.add(productId);

    // 🔥 optimistic update
    set(state => ({
      items: state.items.map(item =>
        item.id === productId
          ? item
          : item
      )
    }));

    // OR safer:
    await get().fetch();
  },

  remove: async (productId) => {
    await wishListService.delete(productId);

    // 🔥 update state immediately
    set(state => ({
      items: state.items.filter(
        item => item.id !== productId
      )
    }));
  },
}));
