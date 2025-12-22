"use client";

import React, { useState } from 'react';
import { 
  Search, 
  SlidersHorizontal,
  X,
  Star,
  Heart,
  ShoppingCart,
  TrendingUp,
  Clock,
  Grid3x3,
  List,
  ChevronDown,
  Filter,
  Package,
  Tag,
  Sparkles
} from 'lucide-react';
import Link from 'next/link';

// Mock search results data
const searchResults = [
  {
    id: 1,
    name: "Luxury Hydrating Serum",
    brand: "Cosmetica Premium",
    category: "Skincare",
    price: 89.99,
    originalPrice: 119.99,
    rating: 4.8,
    reviewCount: 1247,
    image: "/assets/img/product/product1.png",
    inStock: true,
    badge: "BESTSELLER",
    discount: 25
  },
  {
    id: 2,
    name: "Matte Finish Foundation",
    brand: "Glamour Studio",
    category: "Makeup",
    price: 45.00,
    originalPrice: 65.00,
    rating: 4.5,
    reviewCount: 892,
    image: "/assets/img/product/product2.png",
    inStock: true,
    badge: "NEW",
    discount: 31
  },
  {
    id: 3,
    name: "Revitalizing Hair Mask",
    brand: "Nature's Best",
    category: "Hair Care",
    price: 35.00,
    originalPrice: 50.00,
    rating: 4.7,
    reviewCount: 634,
    image: "/assets/img/product/product3.png",
    inStock: true,
    badge: "",
    discount: 30
  },
  {
    id: 4,
    name: "Anti-Aging Night Cream",
    brand: "Youth Restore",
    category: "Skincare",
    price: 75.00,
    originalPrice: 95.00,
    rating: 4.9,
    reviewCount: 1521,
    image: "/assets/img/product/product4.png",
    inStock: false,
    badge: "HOT",
    discount: 21
  },
  {
    id: 5,
    name: "Waterproof Mascara",
    brand: "Lash Perfect",
    category: "Makeup",
    price: 28.00,
    originalPrice: 35.00,
    rating: 4.6,
    reviewCount: 756,
    image: "/assets/img/product/product1.png",
    inStock: true,
    badge: "",
    discount: 20
  },
  {
    id: 6,
    name: "Vitamin C Face Wash",
    brand: "Bright & Fresh",
    category: "Skincare",
    price: 22.00,
    originalPrice: 30.00,
    rating: 4.4,
    reviewCount: 423,
    image: "/assets/img/product/product2.png",
    inStock: true,
    badge: "SALE",
    discount: 27
  },
  {
    id: 7,
    name: "Eyeshadow Palette Pro",
    brand: "Color Magic",
    category: "Makeup",
    price: 55.00,
    originalPrice: 75.00,
    rating: 4.8,
    reviewCount: 1089,
    image: "/assets/img/product/product3.png",
    inStock: true,
    badge: "BESTSELLER",
    discount: 27
  },
  {
    id: 8,
    name: "Deep Conditioning Treatment",
    brand: "Silky Locks",
    category: "Hair Care",
    price: 42.00,
    originalPrice: 60.00,
    rating: 4.5,
    reviewCount: 512,
    image: "/assets/img/product/product4.png",
    inStock: true,
    badge: "",
    discount: 30
  }
];

const popularSearches = [
  "Moisturizer", "Foundation", "Lipstick", "Serum", "Face Mask",
  "Sunscreen", "Eye Cream", "Hair Oil", "Blush", "Concealer"
];

const SearchPage = () => {
  const [searchQuery, setSearchQuery] = useState("serum");
  const [viewMode, setViewMode] = useState<'grid' | 'list'>('grid');
  const [showFilters, setShowFilters] = useState(false);
  const [sortBy, setSortBy] = useState('relevance');
  const [priceRange, setPriceRange] = useState([0, 200]);
  const [selectedCategories, setSelectedCategories] = useState<string[]>([]);
  const [selectedBrands, setSelectedBrands] = useState<string[]>([]);
  const [minRating, setMinRating] = useState(0);
  const [inStockOnly, setInStockOnly] = useState(false);

  const categories = ["Skincare", "Makeup", "Hair Care", "Fragrance", "Body Care"];
  const brands = ["Cosmetica Premium", "Glamour Studio", "Nature's Best", "Youth Restore", "Lash Perfect"];

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    console.log("Searching for:", searchQuery);
  };

  const toggleCategory = (category: string) => {
    setSelectedCategories(prev => 
      prev.includes(category) 
        ? prev.filter(c => c !== category)
        : [...prev, category]
    );
  };

  const toggleBrand = (brand: string) => {
    setSelectedBrands(prev => 
      prev.includes(brand) 
        ? prev.filter(b => b !== brand)
        : [...prev, brand]
    );
  };

  const clearAllFilters = () => {
    setSelectedCategories([]);
    setSelectedBrands([]);
    setPriceRange([0, 200]);
    setMinRating(0);
    setInStockOnly(false);
  };

  return (
    <div className="bg-gray-50 min-h-screen">
      {/* Search Header */}
      <div className="bg-white border-b sticky top-0 z-40 shadow-sm">
        <div className="max-w-7xl mx-auto px-[5%] py-4">
          <form onSubmit={handleSearch} className="flex gap-3">
            <div className="flex-1 relative">
              <input
                type="text"
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                placeholder="Search for products, brands, or categories..."
                className="w-full px-5 py-3 pl-12 border-2 border-gray-300 rounded-xl focus:border-pink-500 focus:outline-none transition-colors"
              />
              <Search className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
            </div>
            <button
              type="submit"
              className="px-6 py-3 bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-600 hover:to-rose-700 text-white font-bold rounded-xl transition-all shadow-lg hover:scale-105 cursor-pointer"
            >
              Search
            </button>
          </form>
        </div>
      </div>

      <div className="max-w-7xl mx-auto px-[5%] py-6">
        {/* Results Header */}
        <div className="mb-6">
          <div className="flex items-center justify-between mb-4">
            <div>
              <h1 className="text-2xl font-bold text-gray-900 mb-1">
                Search Results for "{searchQuery}"
              </h1>
              <p className="text-gray-600">
                Found <span className="font-semibold text-pink-600">{searchResults.length}</span> products
              </p>
            </div>

            <div className="flex items-center gap-3">
              {/* View Mode Toggle */}
              <div className="flex bg-white rounded-lg border border-gray-300 overflow-hidden">
                <button
                  onClick={() => setViewMode('grid')}
                  className={`p-2.5 transition-colors cursor-pointer ${
                    viewMode === 'grid' 
                      ? 'bg-pink-500 text-white' 
                      : 'text-gray-600 hover:bg-gray-100'
                  }`}
                >
                  <Grid3x3 className="w-5 h-5" />
                </button>
                <button
                  onClick={() => setViewMode('list')}
                  className={`p-2.5 transition-colors cursor-pointer ${
                    viewMode === 'list' 
                      ? 'bg-pink-500 text-white' 
                      : 'text-gray-600 hover:bg-gray-100'
                  }`}
                >
                  <List className="w-5 h-5" />
                </button>
              </div>

              {/* Sort Dropdown */}
              <div className="relative">
                <select
                  value={sortBy}
                  onChange={(e) => setSortBy(e.target.value)}
                  className="appearance-none px-4 py-2.5 pr-10 bg-white border border-gray-300 rounded-lg font-medium text-gray-700 cursor-pointer hover:border-pink-500 focus:border-pink-500 focus:outline-none"
                >
                  <option value="relevance">Most Relevant</option>
                  <option value="price-low">Price: Low to High</option>
                  <option value="price-high">Price: High to Low</option>
                  <option value="rating">Highest Rated</option>
                  <option value="newest">Newest First</option>
                </select>
                <ChevronDown className="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" />
              </div>

              {/* Filter Toggle (Mobile) */}
              <button
                onClick={() => setShowFilters(!showFilters)}
                className="lg:hidden px-4 py-2.5 bg-white border border-gray-300 rounded-lg font-medium text-gray-700 flex items-center gap-2 hover:border-pink-500 cursor-pointer"
              >
                <SlidersHorizontal className="w-5 h-5" />
                Filters
              </button>
            </div>
          </div>

          {/* Popular Searches */}
          <div className="flex items-center gap-2 flex-wrap">
            <span className="text-sm text-gray-600">Popular:</span>
            {popularSearches.slice(0, 6).map((term, index) => (
              <button
                key={index}
                onClick={() => setSearchQuery(term)}
                className="px-3 py-1 bg-white border border-gray-300 rounded-full text-sm text-gray-700 hover:border-pink-500 hover:text-pink-600 transition-colors cursor-pointer"
              >
                {term}
              </button>
            ))}
          </div>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6">
          {/* Filters Sidebar */}
          <div className={`${showFilters ? 'block' : 'hidden'} lg:block`}>
            <div className="bg-white rounded-xl shadow-md p-6 sticky top-24">
              <div className="flex items-center justify-between mb-6">
                <h2 className="text-xl font-bold text-gray-900 flex items-center gap-2">
                  <Filter className="w-5 h-5" />
                  Filters
                </h2>
                <button
                  onClick={clearAllFilters}
                  className="text-sm text-pink-600 hover:text-pink-700 font-semibold cursor-pointer"
                >
                  Clear All
                </button>
              </div>

              <div className="space-y-6">
                {/* Categories */}
                <div>
                  <h3 className="font-bold text-gray-900 mb-3">Categories</h3>
                  <div className="space-y-2">
                    {categories.map((category) => (
                      <label key={category} className="flex items-center gap-2 cursor-pointer group">
                        <input
                          type="checkbox"
                          checked={selectedCategories.includes(category)}
                          onChange={() => toggleCategory(category)}
                          className="w-4 h-4 rounded border-gray-300 text-pink-600 focus:ring-pink-500 cursor-pointer"
                        />
                        <span className="text-sm text-gray-700 group-hover:text-pink-600 transition-colors">
                          {category}
                        </span>
                      </label>
                    ))}
                  </div>
                </div>

                {/* Price Range */}
                <div className="pt-6 border-t">
                  <h3 className="font-bold text-gray-900 mb-3">Price Range</h3>
                  <div className="flex items-center gap-3 mb-3">
                    <input
                      type="number"
                      value={priceRange[0]}
                      onChange={(e) => setPriceRange([Number(e.target.value), priceRange[1]])}
                      className="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:border-pink-500 focus:outline-none"
                      placeholder="Min"
                    />
                    <span className="text-gray-500">-</span>
                    <input
                      type="number"
                      value={priceRange[1]}
                      onChange={(e) => setPriceRange([priceRange[0], Number(e.target.value)])}
                      className="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:border-pink-500 focus:outline-none"
                      placeholder="Max"
                    />
                  </div>
                  <input
                    type="range"
                    min="0"
                    max="200"
                    value={priceRange[1]}
                    onChange={(e) => setPriceRange([priceRange[0], Number(e.target.value)])}
                    className="w-full accent-pink-600 cursor-pointer"
                  />
                </div>

                {/* Brands */}
                <div className="pt-6 border-t">
                  <h3 className="font-bold text-gray-900 mb-3">Brands</h3>
                  <div className="space-y-2">
                    {brands.map((brand) => (
                      <label key={brand} className="flex items-center gap-2 cursor-pointer group">
                        <input
                          type="checkbox"
                          checked={selectedBrands.includes(brand)}
                          onChange={() => toggleBrand(brand)}
                          className="w-4 h-4 rounded border-gray-300 text-pink-600 focus:ring-pink-500 cursor-pointer"
                        />
                        <span className="text-sm text-gray-700 group-hover:text-pink-600 transition-colors">
                          {brand}
                        </span>
                      </label>
                    ))}
                  </div>
                </div>

                {/* Rating */}
                <div className="pt-6 border-t">
                  <h3 className="font-bold text-gray-900 mb-3">Minimum Rating</h3>
                  <div className="space-y-2">
                    {[4, 3, 2, 1].map((rating) => (
                      <button
                        key={rating}
                        onClick={() => setMinRating(rating)}
                        className={`w-full flex items-center gap-2 px-3 py-2 rounded-lg transition-colors cursor-pointer ${
                          minRating === rating
                            ? 'bg-pink-50 border-2 border-pink-500'
                            : 'border border-gray-300 hover:border-pink-300'
                        }`}
                      >
                        <div className="flex items-center gap-1">
                          {[...Array(rating)].map((_, i) => (
                            <Star key={i} className="w-4 h-4 text-amber-400 fill-amber-400" />
                          ))}
                        </div>
                        <span className="text-sm text-gray-700">& Up</span>
                      </button>
                    ))}
                  </div>
                </div>

                {/* Availability */}
                <div className="pt-6 border-t">
                  <label className="flex items-center gap-2 cursor-pointer group">
                    <input
                      type="checkbox"
                      checked={inStockOnly}
                      onChange={(e) => setInStockOnly(e.target.checked)}
                      className="w-4 h-4 rounded border-gray-300 text-pink-600 focus:ring-pink-500 cursor-pointer"
                    />
                    <span className="text-sm font-semibold text-gray-700 group-hover:text-pink-600 transition-colors">
                      In Stock Only
                    </span>
                  </label>
                </div>
              </div>
            </div>
          </div>

          {/* Results Grid/List */}
          <div>
            <div className={viewMode === 'grid' 
              ? 'grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6' 
              : 'space-y-4'
            }>
              {searchResults.map((product) => (
                <div
                  key={product.id}
                  className={`bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all group ${
                    viewMode === 'list' ? 'flex' : ''
                  }`}
                >
                  {/* Product Image */}
                  <Link 
                    href={`/product/${product.id}`} 
                    className={`relative overflow-hidden cursor-pointer ${
                      viewMode === 'list' ? 'w-48 flex-shrink-0' : 'aspect-square'
                    }`}
                  >
                    <img
                      src={product.image}
                      alt={product.name}
                      className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    />
                    
                    {product.badge && (
                      <div className="absolute top-3 left-3">
                        <span className="px-3 py-1 bg-gradient-to-r from-pink-500 to-rose-600 text-white text-xs font-bold rounded-full">
                          {product.badge}
                        </span>
                      </div>
                    )}
                    
                    {product.discount > 0 && (
                      <div className="absolute top-3 right-3">
                        <span className="px-2 py-1 bg-green-600 text-white text-xs font-bold rounded-full">
                          -{product.discount}%
                        </span>
                      </div>
                    )}

                    <div className="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                      <button className="p-2 bg-white rounded-full shadow-lg hover:bg-pink-50 cursor-pointer">
                        <Heart className="w-5 h-5 text-gray-700" />
                      </button>
                    </div>
                  </Link>

                  {/* Product Info */}
                  <div className="p-4 flex-1 flex flex-col">
                    <span className="text-xs text-pink-600 font-semibold mb-1">
                      {product.brand}
                    </span>
                    
                    <Link href={`/product/${product.id}`} className="cursor-pointer">
                      <h3 className="font-bold text-gray-900 mb-2 group-hover:text-pink-600 transition-colors line-clamp-2">
                        {product.name}
                      </h3>
                    </Link>

                    <div className="flex items-center gap-1 mb-3">
                      <div className="flex items-center">
                        {[...Array(5)].map((_, i) => (
                          <Star
                            key={i}
                            className={`w-4 h-4 ${
                              i < Math.floor(product.rating)
                                ? 'text-amber-400 fill-amber-400'
                                : 'text-gray-300 fill-gray-300'
                            }`}
                          />
                        ))}
                      </div>
                      <span className="text-xs text-gray-600">
                        ({product.reviewCount})
                      </span>
                    </div>

                    <div className="flex items-baseline gap-2 mb-3">
                      <span className="text-2xl font-bold text-pink-600">
                        ৳{product.price.toFixed(2)}
                      </span>
                      {product.originalPrice > product.price && (
                        <span className="text-sm text-gray-400 line-through">
                          ৳{product.originalPrice.toFixed(2)}
                        </span>
                      )}
                    </div>

                    <div className="flex items-center gap-2 mt-auto">
                      <button
                        disabled={!product.inStock}
                        className="flex-1 py-2.5 bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-600 hover:to-rose-700 text-white font-bold rounded-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 cursor-pointer text-sm"
                      >
                        <ShoppingCart className="w-4 h-4" />
                        {product.inStock ? 'Add to Cart' : 'Out of Stock'}
                      </button>
                    </div>
                  </div>
                </div>
              ))}
            </div>

            {/* Pagination */}
            <div className="flex items-center justify-center gap-2 mt-8">
              <button className="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 cursor-pointer font-medium">
                Previous
              </button>
              {[1, 2, 3, 4, 5].map((page) => (
                <button
                  key={page}
                  className={`px-4 py-2 rounded-lg font-medium cursor-pointer ${
                    page === 1
                      ? 'bg-gradient-to-r from-pink-500 to-rose-600 text-white'
                      : 'border border-gray-300 text-gray-700 hover:bg-gray-50'
                  }`}
                >
                  {page}
                </button>
              ))}
              <button className="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 cursor-pointer font-medium">
                Next
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default SearchPage;