<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Auth;

class BusinessSettingController extends Controller
{
    public function edit()
    {
        $bsData = BusinessSetting::first(); // Always 1 row
        return view('business-settings.edit', compact('bsData'));
    }

    public function update(Request $request)
    {
        $bsData = BusinessSetting::first();

        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'business_email' => 'nullable|email',
            'business_phone' => 'nullable|string',
            'website_url' => 'nullable|string',
            'bkash_number' => 'nullable|string',
            'certificate_amount' => 'nullable|string',
            'address' => 'nullable|string',

            'tin_number' => 'nullable|string',
            'bin_number' => 'nullable|string',
            'trade_license' => 'nullable|string',

            'certification_docs' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'authorized_docs' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'legal_docs.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png',

            'header_logo' => 'nullable|image',
            'footer_logo' => 'nullable|image',
            'favicon_icon' => 'nullable|image',

            'inside_dhaka' => 'nullable|integer',
            'outside_dhaka' => 'nullable|integer',

            'header_advertisement' => 'nullable|image',
            'footer_advertisement' => 'nullable|image',

            'privacy_policy' => 'nullable',
            'terms_and_conditions' => 'nullable',
            'return_policy' => 'nullable',

            'facebook_url' => 'nullable|string',
            'twitter_url' => 'nullable|string',
            'linkedin_url' => 'nullable|string',
            'youtube_url' => 'nullable|string',
            'instagram_url' => 'nullable|string',
        ]);

        // Image Upload Helper
        $upload = function($field) use ($request, $bsData) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = "uploads/business-settings/" . time() . "_" . $file->getClientOriginalName();
                $file->move(public_path('uploads/business-settings'), $path);
                return $path;
            }
            return $bsData->$field;
        };

        // Upload images
        $validated['header_logo'] = $upload('header_logo');
        $validated['footer_logo'] = $upload('footer_logo');
        $validated['favicon_icon'] = $upload('favicon_icon');

        $validated['header_advertisement'] = $upload('header_advertisement');
        $validated['footer_advertisement'] = $upload('footer_advertisement');

        // Single Documents
        $validated['certification_docs'] = $upload('certification_docs');
        $validated['authorized_docs'] = $upload('authorized_docs');

        // Multiple legal docs
        if ($request->hasFile('legal_docs')) {
            $paths = [];
            foreach ($request->file('legal_docs') as $file) {
                $path = "uploads/business-settings/legal_" . time() . "_" . $file->getClientOriginalName();
                $file->move(public_path('uploads/business-settings'), $path);
                $paths[] = $path;
            }
            $validated['legal_docs'] = $paths;
        }

        // Set updated_by
        $validated['updated_by'] = Auth::id();

        // Update row
        $bsData->update($validated);
        
        cache()->forget('business_settings');

        return redirect()->back()->with('success', 'Business settings updated successfully');
    }
}
