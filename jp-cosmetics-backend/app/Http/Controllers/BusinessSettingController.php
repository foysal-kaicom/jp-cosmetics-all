<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Services\FileStorageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BusinessSettingController extends Controller
{

    protected $fileStorageService;

    public function __construct(FileStorageService $fileStorageService)
    {
        $this->fileStorageService = $fileStorageService;
    }
    public function edit()
    {
        $bsData = BusinessSetting::first(); // Always 1 row
        return view('business-settings.edit', compact('bsData'));
    }

    public function update(Request $request)
    {
        $bsData = BusinessSetting::firstOrCreate([]); // Ensure a row exists

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

            'certification_docs' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'authorized_docs' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'legal_docs' => 'nullable|array',
            'legal_docs.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',

            'header_logo' => 'nullable|image',
            'footer_logo' => 'nullable|image',
            'favicon_icon' => 'nullable|image',

            'inside_dhaka' => 'nullable|integer',
            'outside_dhaka' => 'nullable|integer',

            'header_advertisement' => 'nullable|image',
            'footer_advertisement' => 'nullable|image',

            'privacy_policy' => 'nullable|string',
            'terms_and_conditions' => 'nullable|string',
            'return_policy' => 'nullable|string',

            'facebook_url' => 'nullable|string',
            'twitter_url' => 'nullable|string',
            'linkedin_url' => 'nullable|string',
            'youtube_url' => 'nullable|string',
            'instagram_url' => 'nullable|string',
        ]);

        // Image Upload Helper
        $upload = function ($field) use ($request, $bsData) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                try {
                    $logoUploadResponse = $this->fileStorageService->uploadImageToCloud($file, 'business-settings');
                    return $logoUploadResponse['public_path'] ?? $bsData->$field ?? null;
                } catch (\Throwable $e) {
                    Log::error('BusinessSetting upload error for '.$field.': '.$e->getMessage());
                    return $bsData->$field ?? null;
                }
            }
            return $bsData->$field ?? null;
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
                try {
                    $logoUploadResponse = $this->fileStorageService->uploadImageToCloud($file, 'business-settings');
                    if (!empty($logoUploadResponse['public_path'])) {
                        $paths[] = $logoUploadResponse['public_path'];
                    }
                } catch (\Throwable $e) {
                    Log::warning('One of legal_docs failed to upload: '.$e->getMessage());
                }
            }
            if (!empty($paths)) {
                $validated['legal_docs'] = $paths;
            } else {
                // preserve existing value when uploads failed
                $validated['legal_docs'] = $bsData->legal_docs ?? null;
            }
        }

        // Set updated_by
        $validated['updated_by'] = Auth::id();

        // Update row
        $bsData->update($validated);

        cache()->forget('business_settings');

        return redirect()->back()->with('success', 'Business settings updated successfully');
    }
}
