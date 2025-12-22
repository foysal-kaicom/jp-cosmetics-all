@extends('master')

@section('contents')

<div class="rounded shadow-sm">
    <div class="p-3 rounded-top" style="background-color: rgb(119, 82, 125); color:#ffffff">
        <h3 class="fs-5">Create Category</h3>
    </div>

    <!-- Form Start -->
    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-bottom">
        @csrf

        <div class="row g-4">
            <!-- Image Upload -->
            <div class="col-md-3 text-center">
                <p class="text-muted bg-green-300">Recomendation Image Size: 645*335 px</p>
                <div class="position-relative border rounded bg-light d-flex align-items-center justify-content-center h-75">
                    <img id="imagePreview" src="{{ asset('imagePH.png') }}" alt="Display Image" class="w-100 h-100 object-fit-cover rounded"/>
                    <button type="button" id="removeImage" class="btn btn-sm btn-light bg-white border position-absolute top-0 end-0 rounded-circle">×</button>
                </div>
                <input type="file" accept="image/*" id="fileInput" name="image" class="d-none" />
                <label for="fileInput" class="btn btn-dark mt-3 w-100">Choose Image</label>
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-9 mt-10">
                <div class="row g-3">
                    <!-- Name -->
                    <div class="col-md-4">
                        <label class="form-label">Name</label>
                        <input required type="text" name="name" id="name" class="form-control" placeholder="Enter Category Name" value="{{ old('name') }}" />
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Parent Category -->
                    <div class="col-md-4">
                        <label class="form-label">Parent Category (optional)</label>
                        <select name="parent_id" class="form-select">
                            <option value="">None</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Sequence</label>
                        <input required type="number"  name="sequence" class="form-control" placeholder="e.g. 1" />
                        @error('sequence')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <!-- isPopular -->
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_popular" value="1" {{ old('is_popular') == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_popular">Is Popular</label>
                        </div>
                        @error('is_popular')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    

                    <!-- Description -->
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="Short description...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                @hasPermission('categories.store')
                <div class="row g-3 mt-3">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary px-4">Save</button>
                    </div>
                </div>
                @endHasPermission
            </div>
        </div>
    </form>
    <!-- Form End -->
</div>

<!-- JS: Image preview + remove, and slugify -->
<script>
    // Image preview
    document.getElementById("fileInput").addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => document.getElementById("imagePreview").src = e.target.result;
        reader.readAsDataURL(file);
    });

    // Remove image
    document.getElementById("removeImage").addEventListener("click", function() {
        document.getElementById("imagePreview").src = "{{ asset('assets/img/default-image.jpg') }}";
        document.getElementById("fileInput").value = "";
    });

    // Slugify from name
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    const slugify = str => str
        .toString()
        .trim()
        .toLowerCase()
        .replace(/[\s\_]+/g, '-')         // spaces/underscores -> hyphen
        .replace(/[^a-z0-9\-]/g, '')      // remove non-alphanum
        .replace(/\-+/g, '-')             // collapse dashes
        .replace(/^\-+|\-+$/g, '');       // trim dashes

    nameInput.addEventListener('input', () => {
        if (!slugInput.value || slugInput.value === '' || slugInput.dataset.touched !== '1') {
            slugInput.value = slugify(nameInput.value);
        }
    });

    // If user edits slug manually, stop auto-sync
    slugInput.addEventListener('input', () => {
        slugInput.dataset.touched = '1';
    });
</script>

@endsection
