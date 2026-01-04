import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  output: "standalone",

  images: {
    remotePatterns: [
      {
        protocol: "https",
        hostname: "media.kaicombd.com",
        pathname: "/**",
      },
      {
        protocol: "https",
        hostname: "admin.kaicombd.com",
        pathname: "/**",
      },
      {
        protocol: "https",
        hostname: "pub-cfecc035f10c47098992ddff2b26fa4e.r2.dev",
        pathname: "/**",
      },

      // LOCAL DEV (only if you really need them)
      {
        protocol: "http",
        hostname: "localhost",
        port: "3000",
        pathname: "/**",
      },
      {
        protocol: "http",
        hostname: "127.0.0.1",
        pathname: "/**",
      },
      {
        protocol: "http",
        hostname: "192.168.0.101",
        pathname: "/**",
      },
    ],
  },
};

export default nextConfig;
