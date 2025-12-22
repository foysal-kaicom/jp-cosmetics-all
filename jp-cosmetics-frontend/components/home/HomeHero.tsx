"use client";

import React, { useEffect, useRef, useState } from "react";
import KeenSlider, { KeenSliderInstance } from "keen-slider";
import "keen-slider/keen-slider.min.css";
import {
  ShoppingBag,
  ChevronLeft,
  ChevronRight,
  Sparkles,
  TrendingUp,
} from "lucide-react";
import WebPageWrapper from "../WebPageWrapper";
import Link from "next/link";
import { Category, HeroSlider } from "@/types";

export default function HomeHero({
  heroSliders, popularCategories
}: {
  heroSliders: HeroSlider[];
  popularCategories: Category[];
}) {
  const sliderRef = useRef<HTMLDivElement | null>(null);
  const sliderInstance = useRef<KeenSliderInstance | null>(null);
  const [currentSlide, setCurrentSlide] = useState(0);
  const [loaded, setLoaded] = useState(false);

  useEffect(() => {
    let timeout: any; // Move these to the top
    let mouseOver = false;

    function autoPlay() {
      clearTimeout(timeout);
      if (mouseOver) return;

      timeout = setTimeout(() => {
        sliderInstance.current?.next();
      }, 5000);
    }

    if (sliderRef.current) {
      sliderInstance.current = new KeenSlider(sliderRef.current, {
        loop: true,
        // duration: 1200,
        drag: true,
        slides: { perView: 1 },
        slideChanged(slider) {
          setCurrentSlide(slider.track.details.rel);
        },
        created() {
          setLoaded(true);
          autoPlay(); // Now safe
        },
      });
    }

    sliderRef.current?.addEventListener("mouseover", () => {
      mouseOver = true;
      clearTimeout(timeout);
    });

    sliderRef.current?.addEventListener("mouseout", () => {
      mouseOver = false;
      autoPlay();
    });

    return () => {
      clearTimeout(timeout);
      sliderInstance.current?.destroy();
    };
  }, []);

  return (
    <WebPageWrapper>
      <div className="flex flex-col lg:flex-row gap-6 lg:gap-8">
        {/* LEFT MAIN SLIDER */}
        <div className="relative lg:w-2/3 h-[500px] lg:h-[680px] rounded-2xl overflow-hidden shadow-2xl group">
          <div ref={sliderRef} className="keen-slider h-full">
            {heroSliders.map((slide, index) => (
              <div key={index} className="keen-slider__slide relative">
                {/* Background Image with Ken Burns Effect */}
                <div className="absolute inset-0 overflow-hidden">
                  <img
                    src={slide.image}
                    alt={slide.title}
                    className="w-full h-full object-cover scale-105 group-hover:scale-110 transition-transform duration-[8000ms]"
                  />
                </div>

                {/* Enhanced Gradient Overlays */}
                <div className="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent" />
                <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent" />

                {/* Content */}
                <div className="relative h-full flex flex-col justify-center px-8 md:px-16 lg:px-20 text-white space-y-6 animate-in fade-in slide-in-from-left-8 duration-700">
                  {/* Badge */}
                  <div className="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-pink-500 to-rose-600 rounded-full text-xs font-bold uppercase tracking-wider w-fit shadow-lg backdrop-blur-sm animate-in fade-in slide-in-from-left-4 duration-500">
                    <Sparkles className="w-4 h-4" />
                    {slide.label}
                  </div>

                  {/* Title */}
                  <h2 className="text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold leading-tight max-w-2xl drop-shadow-2xl animate-in fade-in slide-in-from-left-4 duration-1000">
                    {slide.title}
                  </h2>

                  {/* Description */}
                  <p className="max-w-xl text-base md:text-lg lg:text-xl text-gray-200 leading-relaxed animate-in fade-in slide-in-from-left-4 duration-1200">
                    {slide.short_description}
                  </p>

                  {/* CTA Button */}
                  {slide.url && (
                    <div className="animate-in fade-in slide-in-from-left-4 duration-1500">
                      <Link href={slide.url}>
                        <button className="group/btn relative overflow-hidden px-8 py-4 bg-gradient-to-r from-pink-500 to-rose-600 rounded-full font-bold text-white shadow-2xl hover:shadow-pink-500/50 transition-all duration-300 hover:scale-105 active:scale-95 flex items-center gap-3 cursor-pointer">
                          <span className="absolute inset-0 bg-gradient-to-r from-rose-600 to-pink-700 translate-x-full group-hover/btn:translate-x-0 transition-transform duration-500" />
                          <span className="relative z-10 flex items-center gap-3">
                            <ShoppingBag className="w-5 h-5" />
                            Visit
                          </span>
                        </button>
                      </Link>
                    </div>
                  )}
                </div>

                {/* Decorative Elements */}
                <div className="absolute bottom-0 right-0 w-64 h-64 bg-gradient-to-tl from-pink-500/20 to-transparent rounded-tl-full opacity-60" />
              </div>
            ))}
          </div>

          {/* Navigation Arrows */}
          {loaded && sliderInstance.current && (
            <>
              <button
                onClick={() => sliderInstance.current?.prev()}
                className="absolute left-4 top-1/2 -translate-y-1/2 z-20 p-3 bg-white/10 backdrop-blur-md rounded-full text-white hover:bg-white/20 transition-all duration-300 opacity-0 group-hover:opacity-100 hover:scale-110 active:scale-95 cursor-pointer"
                aria-label="Previous slide"
              >
                <ChevronLeft className="w-6 h-6" />
              </button>
              <button
                onClick={() => sliderInstance.current?.next()}
                className="absolute right-4 top-1/2 -translate-y-1/2 z-20 p-3 bg-white/10 backdrop-blur-md rounded-full text-white hover:bg-white/20 transition-all duration-300 opacity-0 group-hover:opacity-100 hover:scale-110 active:scale-95 cursor-pointer"
                aria-label="Next slide"
              >
                <ChevronRight className="w-6 h-6" />
              </button>
            </>
          )}

          {/* Slide Indicators */}
          {loaded && sliderInstance.current && (
            <div className="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex gap-2">
              {heroSliders.map((_, idx) => (
                <button
                  key={idx}
                  onClick={() => sliderInstance.current?.moveToIdx(idx)}
                  className={`transition-all duration-300 rounded-full ${
                    currentSlide === idx
                      ? "w-12 h-2 bg-white"
                      : "w-2 h-2 bg-white/50 hover:bg-white/75"
                  }`}
                  aria-label={`Go to slide ${idx + 1}`}
                />
              ))}
            </div>
          )}
        </div>

        {/* RIGHT SIDE FEATURE CARDS */}
        <div className="flex flex-row lg:flex-col gap-4 lg:gap-6 lg:w-1/3 h-auto lg:h-[680px]">
          {popularCategories.map((item, i) => (
            <Link
              key={i}
              href={`/category/${item.slug}`}
              className="relative flex-1 lg:h-1/2 rounded-2xl overflow-hidden group shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-1"
            >
              <div className="absolute inset-0">
                <img
                  src={item.image}
                  alt={item.name}
                  className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                />
              </div>

              <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent group-hover:from-black/70" />

              <div className="relative h-full flex flex-col justify-end p-6 text-white">
     
                <div className="inline-flex items-center gap-1.5 mb-3 px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold uppercase w-fit opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                  <TrendingUp className="w-3 h-3" />
                  Popular
                </div>

                <h3 className="text-xl md:text-2xl font-bold mb-2 group-hover:text-pink-300 transition-colors">
                  {item.name}
                </h3>

                <p className="text-sm text-gray-200 mb-3 opacity-90">
                  {item.description}
                </p>

                <div className="flex items-center gap-2 text-sm font-semibold group-hover:gap-3 transition-all">
                  Shop Now
                  <ChevronRight className="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                </div>
              </div>

              <div className="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-pink-500/30 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500" />
            </Link>
          ))}
        </div>
      </div>

      {/* Trust Badges / Features Bar */}
      <div className="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div className="flex items-center gap-4 p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
          <div className="p-3 bg-gradient-to-br from-pink-100 to-rose-100 rounded-full">
            <svg
              className="w-6 h-6 text-pink-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={2}
                d="M5 13l4 4L19 7"
              />
            </svg>
          </div>
          <div>
            <h4 className="font-bold text-gray-900">Premium Quality</h4>
            <p className="text-sm text-gray-600">
              Certified & Authentic Products
            </p>
          </div>
        </div>

        <div className="flex items-center gap-4 p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
          <div className="p-3 bg-gradient-to-br from-pink-100 to-rose-100 rounded-full">
            <svg
              className="w-6 h-6 text-pink-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={2}
                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
          </div>
          <div>
            <h4 className="font-bold text-gray-900">Best Prices</h4>
            <p className="text-sm text-gray-600">
              Competitive Pricing Guaranteed
            </p>
          </div>
        </div>

        <div className="flex items-center gap-4 p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
          <div className="p-3 bg-gradient-to-br from-pink-100 to-rose-100 rounded-full">
            <svg
              className="w-6 h-6 text-pink-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={2}
                d="M13 10V3L4 14h7v7l9-11h-7z"
              />
            </svg>
          </div>
          <div>
            <h4 className="font-bold text-gray-900">Fast Delivery</h4>
            <p className="text-sm text-gray-600">Express Shipping Available</p>
          </div>
        </div>
      </div>
    </WebPageWrapper>
  );
}
