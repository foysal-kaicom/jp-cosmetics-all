"use client";

import React, { useState } from "react";
import { useKeenSlider } from "keen-slider/react";
import "keen-slider/keen-slider.min.css";
import { Quote } from "lucide-react";
import WebPageWrapper from "../WebPageWrapper";
import Headline from "../Headline";

const HomeReview = () => {
  const [currentSlide, setCurrentSlide] = useState(0);
  const [loaded, setLoaded] = useState(false);

  // Initialize Keen Slider
  const [sliderRef, instanceRef] = useKeenSlider<HTMLDivElement>({
    initial: 0,
    loop: true, // Reviews usually loop endlessly
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
      <Headline
        className="mb-10 scroll-fade-up"
        mainText="What every one say about us"
        subText=""
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
            />

            <Arrow
              onClick={(e: any) =>
                e.stopPropagation() || instanceRef.current?.next()
              }
            />
          </>
        )}

        {/* Slider Container */}
        <div
          ref={sliderRef}
          className="keen-slider scroll-fade-up cursor-grab active:cursor-grabbing"
        >
          {[...Array(5)].map((_, index) => (
            <div key={index} className="keen-slider__slide mb-6">
              <div className="max-w-3xl text-center flex flex-col items-center mx-auto tracking-wider text-sm leading-7">
                <Quote className="rotate-180 text-[#ec6b81] size-8" />

                <p className="text-gray-500 my-3">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                  Nihil tenetur est ipsum dolorum a ullam sint saepe assumenda,
                  laboriosam labore impedit, esse aliquid similique temporibus
                  porro iusto nisi illum, quod omnis dolores fugit facilis.
                  Praesentium labore dolore consectetur esse est, nulla
                  voluptates reprehenderit, suscipit delectus iste mollitia
                  dolores nesciunt? Ex.
                </p>

                {/* Avatar Image */}
                <img
                  src="https://avatars.githubusercontent.com/u/66457643?v=4" // Placeholder path based on your pattern
                  alt="User Avatar"
                  className="size-20 rounded-full bg-gray-200 object-cover mb-2"
                />

                <p className="font-semibold text-[#ec6b81]">Miss. Jenny Doe</p>
                <p className="text-gray-400">Founder</p>
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* Pagination Dots */}
      {loaded && instanceRef.current && (
        <div className="flex justify-center pb-4 gap-2">
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

function Arrow(props: { left?: boolean; onClick: (e: any) => void }) {
  return (
    <svg
      onClick={props.onClick}
      className={`w-10 h-10 absolute top-1/2 -translate-y-1/2 cursor-pointer z-10 fill-current text-gray-400 hover:text-[#ec6b81] transition-colors bg-transparent p-1 ${
        props.left ? "left-0 lg:left-10" : "right-0 lg:right-10"
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

export default HomeReview;
