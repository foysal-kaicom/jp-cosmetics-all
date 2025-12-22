import { create } from "zustand";
import { persist, createJSONStorage } from "zustand/middleware";
import { authService } from "@/services/auth.service";
import { setAuthToken, clearAuthToken } from "@/lib/authCookies";
import type { AuthState } from "@/types/auth";

export const useAuthStore = create<AuthState>()(
  persist(
    (set) => ({
      user: null,
      loading: true,

      hydrate: async () => {
        try {
          const user = await authService.me();
          set({ user, loading: false });
        } catch {
          set({ user: null, loading: false });
        }
      },

      login: async (email, password) => {
        const res = await authService.login({ email, password });

        setAuthToken(res.token);
        set({ user: res.user });
      },

      logout: async () => {
        try {
          await authService.logout();
        } finally {
          clearAuthToken();
          set({ user: null });
          window.location.href = "/";
        }
      },

      setUser: (user) => set({ user }),
    }),
    {
      name: "auth-store",
      storage: createJSONStorage(() => localStorage),

      partialize: (state) => ({
        user: state.user,
      }),
    }
  )
);
