import { toast, Bounce, ToastOptions, Theme } from "react-toastify";

type CustomToastOptions = ToastOptions & {
  autoClose?: number;
  theme?: Theme;
};

const defaultOptions: ToastOptions = {
  position: "bottom-right",
  autoClose: 2000,
  hideProgressBar: false,
  closeOnClick: false,
  pauseOnHover: true,
  draggable: true,
  theme: "light",
  transition: Bounce,
};

const buildOptions = (options?: CustomToastOptions): ToastOptions => ({
  ...defaultOptions,
  ...options, // overrides autoClose & theme if passed
});

export const showToast = {
  success: (message: string, options?: CustomToastOptions) =>
    toast.success(message, buildOptions(options)),

  error: (message: string, options?: CustomToastOptions) =>
    toast.error(message, buildOptions(options)),

  warning: (message: string, options?: CustomToastOptions) =>
    toast.warn(message, buildOptions(options)),

  info: (message: string, options?: CustomToastOptions) =>
    toast.info(message, buildOptions(options)),
};
