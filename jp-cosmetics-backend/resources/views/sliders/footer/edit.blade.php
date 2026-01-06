@extends('master')

@section('contents')

<div class="rounded shadow-sm">
    <div class="p-3 rounded-top" style="background-color: rgb(119, 82, 125); color:#ffffff">
        <h3 class="fs-5">Edit Footer Slider</h3>
    </div>

    <form action="{{ route('footer-sliders.update', $footerSlider->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-bottom">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-md-3 text-center">
                <p class="text-muted bg-green-300">Recomendation Image Size: 1085*700 px <span class="text-danger">*</span></p>
                <div class="position-relative border rounded bg-light d-flex align-items-center justify-content-center h-75">
                    <img id="imagePreview" src="{{ $footerSlider->image }}" class="w-100 h-100 object-fit-cover rounded"/>
                    <button type="button" id="removeImage" class="btn btn-sm btn-light bg-white border position-absolute top-0 end-0 rounded-circle">×</button>
                </div>
                <input type="file" accept="image/*" id="fileInput" name="image" class="d-none" />
                <label for="fileInput" class="btn btn-dark mt-3 w-100">Choose Image</label>
                @error('image') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-9 mt-10">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Label</label>
                        <select name="label" class="form-select">
                            <option value="">Select Label</option>
                            <option value="new_arrivals" {{ $footerSlider->label=='new_arrivals'?'selected':'' }}>New Arrivals</option>
                            <option value="new_collection" {{ $footerSlider->label=='new_collection'?'selected':'' }}>New Collection</option>
                            <option value="trending" {{ $footerSlider->label=='trending'?'selected':'' }}>Trending</option>
                            <option value="discount" {{ $footerSlider->label=='discount'?'selected':'' }}>Discount</option>
                        </select>
                        @error('label') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ $footerSlider->title }}">
                        @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">URL</label>
                        <input type="text" name="url" class="form-control" value="{{ $footerSlider->url }}">
                        @error('url') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $footerSlider->status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$footerSlider->status ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-12">
                        <label class="form-label">Short Description</label>
                        <textarea name="short_description" rows="3" class="form-control">{{ $footerSlider->short_description }}</textarea>
                        @error('short_description') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary px-4">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById("fileInput").addEventListener("change", function(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => document.getElementById("imagePreview").src = e.target.result;
    reader.readAsDataURL(file);
});
document.getElementById("removeImage").addEventListener("click", function() {
    document.getElementById("imagePreview").src = "{{ $footerSlider->image }}";
    document.getElementById("fileInput").value = "";
});
</script>

@endsection
