"use client";

import ProductListComponent from "@/components/shop/ProductListComponent";
import apiClient from "@/lib/axios";
import { ProductFilters, ProductList } from "@/types";
import { showToast } from "@/utils/toast";
import { useEffect, useState } from "react";
import { useRouter, useSearchParams } from "next/navigation";

export default function Shop() {
  const router = useRouter();
  const searchParams = useSearchParams();

  const [productList, setProductList] = useState<ProductList>();
  const [productFilters, setProductFilters] = useState<ProductFilters>();
  const [query, setQuery] = useState<string>("");

  /* ---------------- API CALLS ---------------- */

  const getProducts = async (query: string) => {
    try {
      const res = await apiClient.get<{
        success: boolean;
        data: ProductList;
        message: string;
      }>(`/products${query ? `?${query}` : ""}`);

      if (res.data.success) {
        setProductList(res.data.data);
      }
    } catch (error: any) {
      showToast.error(
        error?.response?.data?.message ||
          "Can not get products at this moment"
      );
    }
  };

  const getProductFilters = async () => {
    try {
      const res = await apiClient.get<{
        success: boolean;
        data: ProductFilters;
        message: string;
      }>("/products/filter-data");

      if (res.data.success) {
        setProductFilters(res.data.data);
      }
    } catch (error: any) {
      showToast.error(
        error?.response?.data?.message ||
          "Can not get subscription plans at this moment"
      );
    }
  };

  /* ---------------- QUERY HANDLER ---------------- */

  const updateQueryParams = (updates: Record<string, string | null>) => {
    const params = new URLSearchParams(searchParams.toString());

    Object.entries(updates).forEach(([key, value]) => {
      if (!value) {
        params.delete(key);
      } else {
        params.set(key, value);
      }
    });

    const newQuery = params.toString();

    router.replace(`?${newQuery}`, { scroll: true });
    setQuery(newQuery);
  };

  /* ---------------- HANDLERS ---------------- */

  const handleFilterChange = (filters: {
    category: string[];
    brand: string[];
    price: number;
  }) => {
    updateQueryParams({
      // API expects category_id & brand_ids
      category_id: filters.category.length
        ? filters.category.join(",")
        : null,
      brand_ids: filters.brand.length ? filters.brand.join(",") : null,
      // price: filters.price ? filters.price.toString() : null,
      page: "1",
    });
  };

  const handleSortChange = (sort: string) => {
    updateQueryParams({
      sort,
      page: "1",
    });
  };

  const handlePageChange = (page: number) => {
    updateQueryParams({
      page: page.toString(),
    });
  };

  /* ---------------- EFFECTS ---------------- */

  useEffect(() => {
    if (!productFilters) getProductFilters();
  }, []);

  useEffect(() => {
    const urlQuery = searchParams.toString();
    setQuery(urlQuery);
  }, [searchParams]);

  useEffect(() => {
    console.log(query);
    setProductList(undefined);
    getProducts(query);
  }, [query]);

  /* ---------------- RENDER ---------------- */

  return (
    <>
      {/* {productList && productFilters && productList.data.length > 0 ? ( */}
        <ProductListComponent
          products={productList?.data || []}
          paginationData={productList?.meta || { total: 0, page: 1, pageSize: 12 }}
          filterOptions={productFilters || { categories: [], brands: [], price: 0 }}
          onPageChange={handlePageChange}
          onFilterChange={handleFilterChange}
          onSortChange={handleSortChange}
        />
      {/* // ) : (
      //   <div className="text-center mt-20 text-gray-500">
      //     No products found.
      //   </div>
      // )} */}
    </>
  );
}
