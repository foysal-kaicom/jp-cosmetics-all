"use client";

import React, { useState } from "react";
import { useKeenSlider } from "keen-slider/react";
import "keen-slider/keen-slider.min.css";
import ProductCard from "./ProductCard";
import WebPageWrapper from "../WebPageWrapper";
import Headline from "../Headline";
import { Product } from "@/types";

// Type definition
// export type Product = {
//   mainImg: string;
//   subImg: string;
//   rate: number;
//   prevprice: number;
//   price: number;
//   label: string;
//   badge: string;
//   discount: string;
//   catId: number;
// };

// Mock Data (Expanded to demonstrate scrolling)
// const products: Product[] = [
//   {
//     mainImg: "/assets/img/product/product2.png",
//     subImg: "/assets/img/product/product1.png",
//     rate: 3,
//     prevprice: 60.99,
//     price: 49.99,
//     label: "Luxury Makeup Kit",
//     badge: "new",
//     discount: "10% off",
//     catId: 1,
//   },
//   {
//     mainImg: "/assets/img/product/product3.png",
//     subImg: "/assets/img/product/product4.png",
//     rate: 4,
//     prevprice: 80.0,
//     price: 65.5,
//     label: "Hydrating Serum",
//     badge: "hot",
//     discount: "15% off",
//     catId: 1,
//   },
//   {
//     mainImg: "/assets/img/product/product2.png",
//     subImg: "/assets/img/product/product1.png",
//     rate: 5,
//     prevprice: 45.0,
//     price: 30.0,
//     label: "Matte Lipstick",
//     badge: "sale",
//     discount: "20% off",
//     catId: 2,
//   },
//   {
//     mainImg: "/assets/img/product/product3.png",
//     subImg: "/assets/img/product/product4.png",
//     rate: 4,
//     prevprice: 120.0,
//     price: 100.0,
//     label: "Night Cream",
//     badge: "new",
//     discount: "5% off",
//     catId: 2,
//   },
//   {
//     mainImg: "/assets/img/product/product2.png",
//     subImg: "/assets/img/product/product1.png",
//     rate: 3,
//     prevprice: 55.0,
//     price: 45.0,
//     label: "Face Cleanser",
//     badge: "",
//     discount: "",
//     catId: 1,
//   },
//   {
//     mainImg: "/assets/img/product/product3.png",
//     subImg: "/assets/img/product/product4.png",
//     rate: 5,
//     prevprice: 70.0,
//     price: 60.0,
//     label: "Eye Shadow Palette",
//     badge: "hot",
//     discount: "10% off",
//     catId: 3,
//   },
//   {
//     mainImg: "/assets/img/product/product2.png",
//     subImg: "/assets/img/product/product1.png",
//     rate: 4,
//     prevprice: 35.0,
//     price: 25.0,
//     label: "Blush Brush",
//     badge: "",
//     discount: "",
//     catId: 3,
//   },
// ];

const HomeTrending = ({ products }: { products: Product[] }) => {
  const [currentSlide, setCurrentSlide] = useState(0);
  const [loaded, setLoaded] = useState(false);

  // Initialize Keen Slider
  const [sliderRef, instanceRef] = useKeenSlider<HTMLDivElement>({
    initial: 0,
    slides: {
      perView: 5,
      spacing: 16,
    },
    slideChanged(slider) {
      setCurrentSlide(slider.track.details.rel);
    },
    created() {
      setLoaded(true);
    },
    // Breakpoints for responsiveness
    breakpoints: {
      "(max-width: 1280px)": {
        slides: { perView: 3.5, spacing: 16 },
      },
      "(max-width: 1024px)": {
        slides: { perView: 2.5, spacing: 12 },
      },
      "(max-width: 768px)": {
        slides: { perView: 2, spacing: 10 },
      },
      "(max-width: 680px)": {
        slides: { perView: 1, spacing: 10 },
      },
    },
  });

  return (
    <WebPageWrapper>
      <Headline
        className="mb-5 scroll-fade-up"
        mainText="Trending Products"
        subText="Add our products to weekly line up"
      />
      {/* Show All Button */}
      <div className="flex justify-center mb-5">
        <button className="relative w-[160px] overflow-hidden rounded-md bg-[#ec6b81] p-1 font-semibold text-white shadow-md group scroll-fade-up cursor-pointer">
          <span className="absolute inset-0 bg-[#d85a72] rounded-md -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></span>
          <div className="relative z-10 flex items-center justify-center text-sm px-8 py-2">
            Show All
          </div>
        </button>
      </div>

      {/* Slider Section */}
      <div className="relative group px-2">
        {/* Navigation Arrows */}
        {loaded && instanceRef.current && (
          <>
            <Arrow
              left
              onClick={(e: any) =>
                e.stopPropagation() || instanceRef.current?.prev()
              }
              disabled={currentSlide === 0}
            />

            <Arrow
              onClick={(e: any) =>
                e.stopPropagation() || instanceRef.current?.next()
              }
              disabled={
                currentSlide ===
                instanceRef.current.track.details.slides.length - 5 // Adjust based on max perView
              }
            />
          </>
        )}

        {/* Slider Container */}
        <div
          ref={sliderRef}
          className="keen-slider scroll-fade-up z-0 py-4 border"
        >
          {products.map((product, index) => (
            <ProductCard
              key={index}
              product={product}
              className="keen-slider__slide m-1.5 h-full"
              wishlisted={false}
            />
          ))}
        </div>
      </div>

      {/* Pagination Dots */}
      {loaded && instanceRef.current && (
        <div className="flex justify-center py-4 gap-2">
          {[
            ...Array(instanceRef.current.track.details.slides.length).keys(),
          ].map((idx) => {
            return (
              <button
                key={idx}
                onClick={() => {
                  instanceRef.current?.moveToIdx(idx);
                }}
                className={`w-3 h-3 rounded-full transition-colors duration-200 ${
                  currentSlide === idx ? "bg-[#ec6b81]" : "bg-gray-300"
                }`}
                aria-label={`Go to slide ${idx + 1}`}
              ></button>
            );
          })}
        </div>
      )}
    </WebPageWrapper>
  );
};

// --- Helper Components for Arrows ---

function Arrow(props: {
  disabled: boolean;
  left?: boolean;
  onClick: (e: any) => void;
}) {
  const disabledClass = props.disabled ? " opacity-30 cursor-not-allowed" : "";
  return (
    <svg
      onClick={props.onClick}
      className={`w-8 h-8 absolute top-1/2 -translate-y-1/2 cursor-pointer z-10 fill-current text-white bg-[#ec6b81] rounded-full shadow-md p-2 hover:bg-[#d85a72] transition-all ${
        props.left ? "left-0" : "right-0"
      } ${disabledClass}`}
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 24 24"
    >
      {props.left && (
        <path d="M16.67 0l2.83 2.829-9.339 9.175 9.339 9.167-2.83 2.829-12.17-11.996z" />
      )}
      {!props.left && (
        <path d="M5 3l3.057-3 11.943 12-11.943 12-3.057-3 9-9z" />
      )}
    </svg>
  );
}

export default HomeTrending;
