import { FilterOption, ProductFilters } from "@/types";
import { SlidersHorizontal, X } from "lucide-react";

const MobileFilters = ({
  isOpen,
  filters,
  categories,
  brands,
  onClose,
  onFilterChange,
  onPriceChange,
  onClearAll,
  activeFiltersCount
}: {
  isOpen: boolean;
  filters: { category: string[]; brand: string[]; price: number };
  categories: FilterOption[];
  brands: FilterOption[];
  onClose: () => void;
  onFilterChange: (type: 'category' | 'brand', value: string) => void;
  onPriceChange: (value: number) => void;
  onClearAll: () => void;
  activeFiltersCount: number;
}) => {
  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 z-50 lg:hidden">
      <div 
        className="absolute inset-0 bg-black/50 backdrop-blur-sm"
        onClick={onClose}
      />
      
      <div className="absolute right-0 top-0 bottom-0 w-full max-w-sm bg-white shadow-2xl overflow-y-auto">
        <div className="p-6 space-y-6">
          <div className="flex items-center justify-between pb-4 border-b border-gray-200">
            <h2 className="text-xl font-bold text-gray-900 flex items-center gap-2">
              <SlidersHorizontal className="w-5 h-5 text-pink-600" />
              Filters
            </h2>
            <button
              onClick={onClose}
              className="p-2 hover:bg-gray-100 rounded-full transition-colors"
            >
              <X className="w-5 h-5" />
            </button>
          </div>

          <div className="border-b border-gray-100 pb-6">
            <h3 className="font-semibold text-gray-900 mb-3 text-sm uppercase tracking-wide">Category</h3>
            <div className="space-y-3">
              {categories.map((cat) => (
                <label key={cat.id} className="flex items-center gap-3 cursor-pointer">
                  <input
                    type="checkbox"
                    value={cat.name}
                    checked={filters.category.includes(cat.id.toString())}
                    onChange={() => onFilterChange('category', cat.id.toString())}
                    className="w-5 h-5 rounded border-gray-300 text-pink-600 focus:ring-pink-500 cursor-pointer"
                  />
                  <span className="text-gray-700">{cat.name}</span>
                </label>
              ))}
            </div>
          </div>

          <div className="border-b border-gray-100 pb-6">
            <h3 className="font-semibold text-gray-900 mb-3 text-sm uppercase tracking-wide">Brand</h3>
            <div className="space-y-3">
              {brands.map((brand) => (
                <label key={brand.id} className="flex items-center gap-3 cursor-pointer">
                  <input
                    type="checkbox"
                    value={brand.name}
                    checked={filters.brand.includes(brand.id.toString())}
                    onChange={() => onFilterChange('brand', brand.id.toString())}
                    className="w-5 h-5 rounded border-gray-300 text-pink-600 focus:ring-pink-500 cursor-pointer"
                  />
                  <span className="text-gray-700">{brand.name}</span>
                </label>
              ))}
            </div>
          </div>

          {/* <div className="pb-6">
            <div className="flex items-center justify-between mb-3">
              <h3 className="font-semibold text-gray-900 text-sm uppercase tracking-wide">Price Range</h3>
              <span className="text-pink-600 font-bold">${filters.price}</span>
            </div>
            <input
              type="range"
              min="0"
              max="1000"
              step="10"
              value={filters.price}
              onChange={(e) => onPriceChange(Number(e.target.value))}
              className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-pink-600"
            />
            <div className="flex justify-between text-xs text-gray-500 mt-2">
              <span>BDT 0</span>
              <span>BDT 1000</span>
            </div>
          </div> */}

          <button
            onClick={onClose}
            className="w-full py-3 bg-gradient-to-r from-pink-500 to-rose-600 text-white font-semibold rounded-xl hover:from-pink-600 hover:to-rose-700 transition-all shadow-lg"
          >
            Apply Filters ({activeFiltersCount})
          </button>

          {activeFiltersCount > 0 && (
            <button
              onClick={() => {
                onClearAll();
                onClose();
              }}
              className="w-full py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:border-pink-400 hover:text-pink-600 transition-all"
            >
              Clear All Filters
            </button>
          )}
        </div>
      </div>
    </div>
  );
};

export default MobileFilters;