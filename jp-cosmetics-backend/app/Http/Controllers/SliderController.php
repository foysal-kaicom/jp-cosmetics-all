<?php

namespace App\Http\Controllers;

use App\Models\FooterSlider;
use App\Models\HeaderSlider;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class SliderController extends Controller
{

     protected $fileStorageService;

    public function __construct(FileStorageService $fileStorageService)
    {
        $this->fileStorageService = $fileStorageService;
    }

    // ----- Header Sliders -----
    public function headerIndex() {
        $sliders = HeaderSlider::all();
        return view('sliders.header.index', compact('sliders'));
    }

    public function headerCreate() {
        return view('sliders.header.create');
    }

    public function headerStore(Request $request) {
        $data = $request->validate([
            'label' => 'nullable|in:new_arrivals,new_collection,trending,discount',
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'url' => 'nullable|url',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $logoUploadResponse = $this->fileStorageService->uploadImageToCloud($request->file('image'), 'header_sliders');
            
            $data['image'] = $logoUploadResponse['public_path'];
        }
        $data['status'] = 1;
        HeaderSlider::create($data);
        cache()->forget('header_sliders');
        return redirect()->route('header-sliders.index')->with('success', 'Header slider added!');
    }

    public function headerEdit(HeaderSlider $headerSlider) {
        return view('sliders.header.edit', compact('headerSlider'));
    }

    public function headerUpdate(Request $request, HeaderSlider $headerSlider) { 
        $data = $request->validate([
            'label' => 'nullable|in:new_arrivals,new_collection,trending,discount',
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($headerSlider->image && file_exists(public_path('uploads/'.$headerSlider->image))) {
                unlink(public_path('uploads/'.$headerSlider->image));
            }

            // Save new image
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/header_sliders'), $imageName);
            $data['image'] = 'header_sliders/' . $imageName;
        }

        $headerSlider->update($data);

        cache()->forget('header_sliders');

        return redirect()->route('header-sliders.index')->with('success', 'Header slider updated!');
    }

    public function headerToggleStatus($id)
    {
        try {
            $headerSlider = HeaderSlider::findOrFail($id);
    
            if ($headerSlider->status) {
                $headerSlider->status = false;
                $headerSlider->save();
                cache()->forget('header_sliders');
            } else {
                $headerSlider->status = true;
                $headerSlider->save();
                cache()->forget('header_sliders');
            }
            Toastr::success('Status changed successfully.');
            return redirect()->route('header-sliders.index');
        } catch (\Exception $e) {
            Toastr::success('Status not changed');
            return redirect()->route('header-sliders.index');
        }
    }

    public function headerDestroy(HeaderSlider $headerSlider) {
        $headerSlider->delete();
        cache()->forget('header_sliders');
        return redirect()->route('header-sliders.index')->with('success', 'Header slider deleted!');
    }






    // ----- Footer Sliders -----
    public function footerIndex() {
        $sliders = FooterSlider::all();
        return view('sliders.footer.index', compact('sliders'));
    }

    public function footerCreate() {
        return view('sliders.footer.create');
    }

    public function footerStore(Request $request) {
        $data = $request->validate([
            'label' => 'nullable|in:new_arrivals,new_collection,trending,discount',
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'url' => 'nullable|url',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $logoUploadResponse = $this->fileStorageService->uploadImageToCloud($request->file('image'), 'footer_sliders');
            $data['image'] = $logoUploadResponse['public_path'];
        }

        $data['status'] = 1;

        FooterSlider::create($data);

        cache()->forget('footer_sliders');

        return redirect()->route('footer-sliders.index')->with('success', 'Footer slider added!');
    }

    public function footerEdit(FooterSlider $footerSlider) {
        return view('sliders.footer.edit', compact('footerSlider'));
    }

    public function footerUpdate(Request $request, FooterSlider $footerSlider) {
        $data = $request->validate([
            'label' => 'nullable|in:new_arrivals,new_collection,trending,discount',
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($footerSlider->image) {
                $newFile = $request->file('image');
                $fileToDelete = $footerSlider->image;
                $logoUploadResponse = $this->fileStorageService->updateFileFromCloud($fileToDelete, $newFile);
            } else {
                $logo = $request->file('image');
                $logoUploadResponse = $this->fileStorageService->uploadImageToCloud($logo, 'footer_sliders');
            }
            $data['image'] = $logoUploadResponse['public_path'];
        }

        $footerSlider->update($data);

        cache()->forget('footer_sliders');

        return redirect()->route('footer-sliders.index')->with('success', 'Footer slider updated!');
    }

    public function footerToggleStatus($id)
    {
        try {
            $footerSlider = FooterSlider::findOrFail($id);
    
            if ($footerSlider->status) {
                $footerSlider->status = false;
                $footerSlider->save();
                cache()->forget('footer_sliders');
            } else {
                $footerSlider->status = true;
                $footerSlider->save();
                cache()->forget('footer_sliders');
            }
            Toastr::success('Status changed successfully.');
            return redirect()->route('footer-sliders.index');
        } catch (\Exception $e) {
            Toastr::success('Status not changed');
            return redirect()->route('footer-sliders.index');
        }
    }

    public function footerDestroy(FooterSlider $footerSlider) {
        $footerSlider->delete();
        cache()->forget('footer_sliders');
        return redirect()->route('footer-sliders.index')->with('success', 'Footer slider deleted!');
    }
}
