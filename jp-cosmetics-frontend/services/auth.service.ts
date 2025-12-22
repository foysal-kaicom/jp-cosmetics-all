import apiClient from "@/lib/axios";
import type {
  LoginPayload,
  LoginApiResponse,
  User,
} from "@/types/auth";

export const authService = {
  async login(payload: LoginPayload): Promise<{
    token: string;
    user: User;
  }> {
    const { data } = await apiClient.post<LoginApiResponse>(
      "/login",
      payload
    );

    return {
      token: data.data.token,
      user: data.data.customer,
    };
  },

  async me(): Promise<User> {
    const { data } = await apiClient.get<User>("/me");
    return data;
  },

  async logout(): Promise<void> {
    await apiClient.post("/logout");
  },
};
