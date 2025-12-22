import { setCookie, destroyCookie, parseCookies } from "nookies";

const TOKEN_KEY = "access_token";

export const setAuthToken = (token: string) => {
  setCookie(null, TOKEN_KEY, token, {
    maxAge: 60 * 60 * 24 * 7,
    path: "/",
    sameSite: "lax",
  });
};

export const getAuthToken = (ctx?: any) => {
  const cookies = parseCookies(ctx);
  return cookies[TOKEN_KEY];
};

export const clearAuthToken = () => {
  destroyCookie(null, TOKEN_KEY, { path: "/" });
};
