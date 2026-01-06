@extends('master')

@section('contents')

<section class="w-100 bg-white rounded overflow-hidden shadow">
    <!-- Header -->
    <div class="p-3 rounded-top" style="background-color: rgb(119, 82, 125); color:#ffffff">
        <h3 class="fs-5">Edit Category</h3>
    </div>

    <!-- Form -->
    <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-bottom">
        @csrf
    
        <div class="row g-4">
            <!-- Image -->
            <div class="col-md-3 text-center">
                <div class="position-relative border rounded bg-light d-flex align-items-center justify-content-center h-75">
                    <img id="imagePreview"
                         src="{{ $category->image }}"
                         alt="Category Image" class="w-100 h-100 object-fit-cover rounded" />
                    <button type="button" id="removeImage" class="btn btn-sm btn-light bg-white border position-absolute top-0 end-0 rounded-circle">×</button>
                </div>
                <input type="file" accept="image/*" id="fileInput" name="image" class="d-none" />
                <label for="fileInput" class="btn btn-dark mt-3 w-100">Choose Image</label>
                @error('image') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- Fields -->
            <div class="col-md-9 mt-10">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Category Name" value="{{ old('name', $category->name) }}" />
                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Parent Category (optional)</label>
                        <select name="parent_id" class="form-select">
                            <option value="">None</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ (string)old('parent_id', $category->parent_id) === (string)$cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Sequence</label>
                        <input type="number" name="sequence" class="form-control" value="{{ old('sequence', $category->sequence) }}" />
                        @error('sequence') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row g-3 mt-3">

                    <!-- Is Popular -->
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_popular" value="1" {{ old('is_popular', $category->is_popular) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_popular">Is Popular</label>
                        </div>
                        @error('is_popular') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>


                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="Short description...">{{ old('description', $category->description) }}</textarea>
                        @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>

                @hasPermission('categories.update')
                <div class="row g-3 mt-3">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary px-4">Update</button>
                    </div>
                </div>
                @endHasPermission
            </div>
        </div>
    </form>
</section>

<!-- JS: Image preview/remove -->
<script>
    document.getElementById("fileInput").addEventListener("change", function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = ev => document.getElementById("imagePreview").src = ev.target.result;
        reader.readAsDataURL(file);
    });
    document.getElementById("removeImage").addEventListener("click", function() {
        document.getElementById("imagePreview").src = "{{ asset('imagePH.png') }}";
        document.getElementById("fileInput").value = "";
    });
</script>

@endsection
