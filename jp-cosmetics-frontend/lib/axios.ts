import axios from "axios";
import { parseCookies } from "nookies";

const apiClient = axios.create({
  baseURL: process.env.NEXT_PUBLIC_API_BASE_URL,
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

// Response interceptor: auto logout on 401
apiClient.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      // const logout = useAuthStore.getState().logout;
      // logout();

      // Optional: redirect to login page
      if (typeof window !== 'undefined') {
        window.location.href = '/login'; // Change to your login route
      }
    }

    return Promise.reject(error);
  }
);

export default apiClient;
