import axios from "axios";
import { parseCookies } from "nookies";
import { useAuthStore } from "@/store/authStore";
import { setAuthToken, clearAuthToken } from "@/lib/authCookies";

const isServer = typeof window === "undefined"

const baseURL = isServer
  ? process.env.INTERNAL_API_BASE_URL
  : process.env.NEXT_PUBLIC_API_BASE_URL;

if (!baseURL) {
  throw new Error("API base URL is not defined");
}

const apiClient = axios.create({
  baseURL,
  headers: {
    "Content-Type": "application/json",
  },
});

// Request interceptor: add token
apiClient.interceptors.request.use(
  (config) => {
    const { access_token } = parseCookies();
    if (access_token) {
      config.headers.Authorization = `Bearer ${access_token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);


apiClient.interceptors.response.use(
  (res) => res,
  (error) => {
    const status = error.response?.status;

    if (status === 401 && typeof window !== "undefined") {
      clearAuthToken();
      useAuthStore.setState({ user: null });

      // client-side soft navigation
      import("next/navigation").then(({ redirect }) => {
        redirect("/login");
      });

      return;
    }

    return Promise.reject(error);
  }
);


export default apiClient;
