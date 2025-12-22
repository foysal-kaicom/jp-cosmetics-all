"use client";

import React, { useState } from "react";
import { useKeenSlider } from "keen-slider/react";
import "keen-slider/keen-slider.min.css";
import CategoryCard from "./CategoryCard";
import Headline from "../Headline";
import WebPageWrapper from "../WebPageWrapper";
import { Category } from "@/types";

const HomeCategory = ({ popularCategories }: { popularCategories: Category[] }) => {
  const [currentSlide, setCurrentSlide] = useState(0);
  const [loaded, setLoaded] = useState(false);

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
 
    breakpoints: {
      "(max-width: 1024px)": {
        slides: { perView: 4, spacing: 12 },
      },
      "(max-width: 768px)": {
        slides: { perView: 3, spacing: 10 },
      },
      "(max-width: 640px)": {
        slides: { perView: 2, spacing: 10 },
      },
      "(max-width: 480px)": {
        slides: { perView: 1, spacing: 10 },
      },
    },
  });

  return (
    <WebPageWrapper>
      <Headline
        mainText="Our Categories"
        subText="Some of our popular categories"
        className="mb-10"
      />

      <div className="relative group px-4">
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
                instanceRef.current.track.details.slides.length - 5 // Adjust subtraction based on default perView
              }
            />
          </>
        )}

        {/* Slider Container */}
        <div ref={sliderRef} className="keen-slider scroll-fade-up z-0">
          {popularCategories.map((category, index) => (
            <div key={index} className="keen-slider__slide h-auto">
              <CategoryCard category={category} className="m-1.5" />
            </div>
          ))}
        </div>
      </div>

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
      className={`w-8 h-8 absolute top-1/2 -translate-y-1/2 cursor-pointer z-10 fill-current text-gray-800 bg-white rounded-full shadow-md p-2 hover:bg-gray-50 transition-all ${
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

export default HomeCategory;
