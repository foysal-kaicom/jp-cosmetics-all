<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Http\Controllers\Controller;

class BusinessSettingController extends Controller
{
    public function show()
    {
        try {
            $settings = cache()->rememberForever('business_settings', function () {
                $businessSetting = BusinessSetting::select(
                    'business_name',
                    'business_email',
                    'business_phone',
                    'website_url',
                    'bkash_number',
                    'trade_license',
                    'address',
                    'header_logo',
                    'footer_logo',
                    'favicon_icon',
                    'inside_dhaka',
                    'outside_dhaka',
                    'header_advertisement',
                    'footer_advertisement',
                    'facebook_url',
                    'twitter_url',
                    'linkedin_url',
                    'youtube_url',
                    'instagram_url'
                )->first();

                if ($businessSetting) {
                    // Convert image paths to full URLs
                    $businessSetting->header_logo = $businessSetting->header_logo;
                    $businessSetting->footer_logo = $businessSetting->footer_logo ;
                    $businessSetting->favicon_icon = $businessSetting->favicon_icon ;
                    $businessSetting->header_advertisement = $businessSetting->header_advertisement;
                    $businessSetting->footer_advertisement = $businessSetting->footer_advertisement;
                }

                return $businessSetting;
            });

            return $this->responseWithSuccess(
                $settings,
                'Business settings fetched successfully',
                200
            );

        } catch (\Exception $e) {
            return $this->responseWithError(
                'Unable to fetch business settings',
                $e->getMessage()
            );
        }
    }



}
