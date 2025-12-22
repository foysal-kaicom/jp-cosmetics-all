"use client";
import { useState, useEffect } from "react";
import { useWishlistStore } from "@/store/wishListStore";

import ProductCard from "@/components/home/ProductCard";

function Wishlist() {
  const { items, fetch, loading } = useWishlistStore();

  
useEffect(() => {
  fetch();
}, []);


  return (
    <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
      <h2 className="text-2xl font-bold text-gray-900 mb-6">My Wishlist</h2>

      {items.length > 0 ? (
        <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-6">
          {items.map((i) => (
            <ProductCard key={i.id} product={i} wishlisted={true}/>
          ))}
        </div>
      ) : (
        <div className="flex justify-center items-center text-center text-gray-500 min-h-[48vh]">
          No items in wishlist
        </div>
      )}
    </div>
  );
}

export default Wishlist;
