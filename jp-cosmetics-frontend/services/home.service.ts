import apiClient from "@/lib/axios";
import { Brand, BusinessInfo, Category, FooterSlider, HeroSlider, Product } from "@/types";

export const getBusinessInfo = async (): Promise<BusinessInfo> => {
  try {
    const response = await apiClient.get("/settings");
    return response.data?.data;
  } catch (error) {
    console.error("Failed to fetch business info", error);
    return {} as BusinessInfo;
  }
};

export const getHeroSliders = async (): Promise<HeroSlider[]> => {
  try {
    const response = await apiClient.get("/header-sliders");
    return response.data?.data;
  } catch (error) {
    console.error("Failed to fetch Hero Sliders info", error);
    return [] as HeroSlider[];
  }
};

export const getCategories = async (): Promise<Category[]> => {
  try {
    const response = await apiClient.get("/categories");
    return response.data?.data;
  } catch (error) {
    console.error("Failed to fetch Category Info", error);
    return [] as Category[];
  }
};

export const getPopularCategories = async (): Promise<Category[]> => {
  try {
    const response = await apiClient.get("/categories/popular/list");
    return response.data?.data;
  } catch (error) {
    console.error("Failed to fetch Popular Category Info", error);
    return [] as Category[];
  }
};

export const getBrands = async (): Promise<Brand[]> => {
  try {
    const response = await apiClient.get("/brands");
    return response.data?.data;
  } catch (error) {
    console.error("Failed to fetch Brands Info", error);
    return [] as Brand[];
  }
};

export const getFooterSliders = async (): Promise<FooterSlider[]> => {
  try {
    const response = await apiClient.get("/footer-sliders");
    return response.data?.data;
  } catch (error) {
    console.error("Failed to fetch Footer Sliders Info", error);
    return [] as FooterSlider[];
  }
};

export const getTrendingProducts = async (): Promise<Product[]> => {
  try {
    const response = await apiClient.get("/trending-products"); 
    return response.data?.data;
  } catch (error) {
    console.error("Failed to fetch Trending Products Info", error);
    return [] as Product[];
  }
};

export const getPopularProducts = async (): Promise<Product[]> => {
  try {
    const response = await apiClient.get("/popular-products"); 
    return response.data?.data;
  } catch (error) {
    console.error("Failed to fetch Popular Products Info", error);
    return [] as Product[];
  }
};