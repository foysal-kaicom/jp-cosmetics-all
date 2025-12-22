import { PaginationData } from "@/types";
import { ChevronLeft, ChevronRight } from "lucide-react";

const Pagination = ({
  paginationData,
  onPageChange
}: {
  paginationData: PaginationData;
  onPageChange: (page: number) => void;
}) => {
  if (paginationData.last_page <= 1) return null;

  const getPageNumbers = () => {
    const pages = [];
    const current = paginationData.current_page;
    const last = paginationData.last_page;

    // Always show first page
    pages.push(1);

    // Show ellipsis if needed
    if (current > 3) {
      pages.push('...');
    }

    // Show pages around current
    for (let i = Math.max(2, current - 1); i <= Math.min(last - 1, current + 1); i++) {
      pages.push(i);
    }

    // Show ellipsis if needed
    if (current < last - 2) {
      pages.push('...');
    }

    // Always show last page
    if (last > 1) {
      pages.push(last);
    }

    return pages;
  };

  return (
    <div className="flex flex-col sm:flex-row items-center justify-between gap-4 mt-12 pt-8 border-t border-gray-200">
      <div className="text-sm text-gray-600">
        Showing <span className="font-semibold text-gray-900">{paginationData.from}</span> to{' '}
        <span className="font-semibold text-gray-900">{paginationData.to}</span> of{' '}
        <span className="font-semibold text-gray-900">{paginationData.total}</span> results
      </div>

      <div className="flex items-center gap-2">
        {/* Previous Button */}
        <button
          onClick={() => onPageChange(paginationData.current_page - 1)}
          disabled={paginationData.current_page === 1}
          className="flex items-center gap-1 px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:border-pink-400 hover:text-pink-600 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:border-gray-300 disabled:hover:text-gray-700 transition-colors cursor-pointer"
        >
          <ChevronLeft className="w-4 h-4" />
          <span className="hidden sm:inline">Previous</span>
        </button>

        {/* Page Numbers */}
        <div className="flex items-center gap-1">
          {getPageNumbers().map((page, index) => {
            if (page === '...') {
              return (
                <span key={`ellipsis-${index}`} className="px-3 py-2 text-gray-400">
                  ...
                </span>
              );
            }

            const pageNum = page as number;
            const isActive = pageNum === paginationData.current_page;

            return (
              <button
                key={pageNum}
                onClick={() => onPageChange(pageNum)}
                className={`min-w-[40px] px-3 py-2 rounded-lg font-medium transition-all cursor-pointer ${
                  isActive
                    ? 'bg-gradient-to-r from-pink-500 to-rose-600 text-white shadow-md'
                    : 'border border-gray-300 text-gray-700 hover:border-pink-400 hover:text-pink-600'
                }`}
              >
                {pageNum}
              </button>
            );
          })}
        </div>

        {/* Next Button */}
        <button
          onClick={() => onPageChange(paginationData.current_page + 1)}
          disabled={paginationData.current_page === paginationData.last_page}
          className="flex items-center gap-1 px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:border-pink-400 hover:text-pink-600 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:border-gray-300 disabled:hover:text-gray-700 transition-colors cursor-pointer"
        >
          <span className="hidden sm:inline">Next</span>
          <ChevronRight className="w-4 h-4" />
        </button>
      </div>
    </div>
  );
};

export default Pagination;