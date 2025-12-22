import { FilterOption, ProductFilters } from "@/types";
import { X } from "lucide-react";

const ActiveFilterTags = ({
  filters,
  categories,
  brands,
  onRemove,
  onClearAll
}: {
  filters: { category: string[]; brand: string[]; price: number };
  categories: FilterOption[];
  brands: FilterOption[];
  onRemove: (type: 'category' | 'brand', value: string) => void;
  onClearAll: () => void;
}) => {
  const activeFiltersCount = filters.category.length + filters.brand.length + (filters.price < 1000 ? 1 : 0);
  
  if (activeFiltersCount === 0) return null;

  // Get full category objects for selected categories
  const selectedCategories = categories.filter(cat => filters.category.includes(cat.name));
  const selectedBrands = brands.filter(brand => filters.brand.includes(brand.name));

  return (
    <div className="flex flex-wrap items-center gap-2 mb-6">
      <span className="text-sm font-medium text-gray-700">Active filters:</span>
      
      {selectedCategories.map((cat) => (
        <button
          key={cat.id}
          onClick={() => onRemove('category', cat.name)}
          className="flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-pink-500 to-rose-600 text-white text-sm rounded-full hover:from-pink-600 hover:to-rose-700 transition-all"
        >
          {cat.name}
          <X className="w-3 h-3" />
        </button>
      ))}

      {selectedBrands.map((brand) => (
        <button
          key={brand.id}
          onClick={() => onRemove('brand', brand.name)}
          className="flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-pink-500 to-rose-600 text-white text-sm rounded-full hover:from-pink-600 hover:to-rose-700 transition-all"
        >
          {brand.name}
          <X className="w-3 h-3" />
        </button>
      ))}

      {filters.price < 1000 && (
        <button
          onClick={() => onRemove('category', '')}
          className="flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-pink-500 to-rose-600 text-white text-sm rounded-full hover:from-pink-600 hover:to-rose-700 transition-all"
        >
          Max ${filters.price}
          <X className="w-3 h-3" />
        </button>
      )}

      <button
        onClick={onClearAll}
        className="text-sm text-gray-600 hover:text-pink-600 font-medium underline ml-2"
      >
        Clear all
      </button>
    </div>
  );
};

export default ActiveFilterTags;