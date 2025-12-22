"use client";

import React, { useState } from "react";
import { useKeenSlider } from "keen-slider/react";
import "keen-slider/keen-slider.min.css";
import WebPageWrapper from "../WebPageWrapper";
import { FooterSlider } from "@/types";
import Image from "next/image";

const HomePromo = ({ footerSliders }: { footerSliders: FooterSlider[] }) => {
  const [currentSlide, setCurrentSlide] = useState(0);
  const [loaded, setLoaded] = useState(false);

  // Initialize Keen Slider
  const [sliderRef, instanceRef] = useKeenSlider<HTMLDivElement>({
    initial: 0,
    loop: true,
    slides: {
      perView: 1,
      spacing: 16,
    },
    slideChanged(slider) {
      setCurrentSlide(slider.track.details.rel);
    },
    created() {
      setLoaded(true);
    },
  });

  return (
    <WebPageWrapper>
      <div className="relative group">
        {/* Navigation Arrows */}
        {loaded && instanceRef.current && (
          <>
            <Arrow
              left
              onClick={(e: any) =>
                e.stopPropagation() || instanceRef.current?.prev()
              }
            />

            <Arrow
              onClick={(e: any) =>
                e.stopPropagation() || instanceRef.current?.next()
              }
            />
          </>
        )}

        {/* Slider Container */}
        <div ref={sliderRef} className="keen-slider scroll-fade-up">
          {footerSliders.map((slider, index) => (
            <div key={index} className="keen-slider__slide">
              <Image
                src={slider.image}
                alt="Promo Banner"
                className="h-[250px] w-full object-cover aspect-auto rounded-lg" // Added rounded-lg for better aesthetics
                width={1000}
                height={250}
              />
            </div>
          ))}
        </div>

        {/* Pagination Dots */}
        {loaded && instanceRef.current && (
          <div className="flex justify-center absolute bottom-4 w-full gap-2 z-10">
            {[
              ...Array(instanceRef.current.track.details.slides.length).keys(),
            ].map((idx) => {
              return (
                <button
                  key={idx}
                  onClick={() => {
                    instanceRef.current?.moveToIdx(idx);
                  }}
                  className={`w-3 h-3 rounded-full transition-colors duration-200 shadow-sm ${
                    currentSlide === idx
                      ? "bg-white"
                      : "bg-white/50 hover:bg-white/80"
                  }`}
                  aria-label={`Go to slide ${idx + 1}`}
                ></button>
              );
            })}
          </div>
        )}
      </div>
    </WebPageWrapper>
  );
};

// --- Helper Components for Arrows ---

function Arrow(props: { left?: boolean; onClick: (e: any) => void }) {
  return (
    <svg
      onClick={props.onClick}
      className={`w-10 h-10 absolute top-1/2 -translate-y-1/2 cursor-pointer z-10 fill-current text-white bg-black/20 hover:bg-black/40 rounded-full p-2 transition-all backdrop-blur-sm ${
        props.left ? "left-2" : "right-2"
      }`}
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

export default HomePromo;
