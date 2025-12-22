<?php

namespace App\Http\Controllers\Api;

use App\Models\FooterSlider;
use App\Models\HeaderSlider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{

    public function headerIndex()
    {
        try {
            $sliders = cache()->rememberForever('header_sliders', function () {
                return HeaderSlider::select(
                    'id',
                    'label',
                    'title',
                    'short_description',
                    'url',
                    'image',
                    'status'
                )
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->get()
                ->map(function($slider){
                    $slider->image = asset('uploads/' . $slider->image);
                    return $slider;
                });
            });

            return $this->responseWithSuccess($sliders, 'Header sliders fetched successfully');

        } catch (\Exception $e) {
            return $this->responseWithError('Unable to fetch header sliders', $e->getMessage());
        }
    }



    public function footerIndex()
    {
        try {
            $sliders = cache()->rememberForever('footer_sliders', function () {
                return FooterSlider::select(
                    'id',
                    'label',
                    'title',
                    'short_description',
                    'url',
                    'image',
                    'status'
                )
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->get()
                ->map(function($slider){
                    $slider->image = asset('uploads/' . $slider->image);
                    return $slider;
                });
            });

            return $this->responseWithSuccess($sliders, 'Footer sliders fetched successfully');

        } catch (\Exception $e) {
            return $this->responseWithError('Unable to fetch footer sliders', $e->getMessage());
        }
    }
}
