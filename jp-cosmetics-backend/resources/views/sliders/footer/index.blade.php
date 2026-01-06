@extends('master')

@section('contents')
<style>
    .statusbtn-active {
        background-color: hsla(215, 94%, 42%, 0.879);
        cursor: pointer;
    }

    .statusbtn-disabled {
        background-color: hsla(358, 92%, 33%, 0.879);
        cursor: pointer;
    }

    th a:hover {
        color: #031a33;
        text-decoration: underline;
    }

    .hover-effect:hover .badge {
        background-color: rgb(29, 37, 43);
        cursor: pointer;
        text-decoration: underline;
    }

    .toggle-switch-lg .form-check-input {
        width: 3rem;
        height: 1.5rem;
        cursor: pointer;
    }

    .toggle-switch-lg .form-check-input:checked {
        background-color: #28a745;
        /* green for active */
        border-color: #28a745;
    }
</style>
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<section class="w-100 bg-white rounded overflow-hidden shadow">

    <div class="py-2.5 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2"
         style="background-color: rgb(119, 82, 125); color:#ffffff">
        <h3 class="text-md m-0">Footer Sliders</h3>
        <a href="{{ route('footer-sliders.create') }}" class="btn btn-primary btn-sm ms-2"
           style="background-color: hsla(227, 64%, 37%, 0.879); white-space:nowrap;">
            <i class="fa-solid fa-plus"></i> Add Slider
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Image</th>
                    <th>Label</th>
                    <th>Title</th>
                    <th>Status</th>
                    
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sliders as $slider)
                    <tr class="text-center">
                        <td>{{ $slider->id }}</td>
                        <td class="d-flex justify-center">
                            <img src="{{ $slider->image }}" 
                                 class="rounded" width="60" height="60">
                        </td>
                        <td>{{ ucfirst(str_replace('_',' ', $slider->label)) }}</td>
                        <td>{{ $slider->title }}</td>
                        {{-- <td class="px-4 py-2 {{ $slider->status == 1 ? 'bg-green-200 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                            {{ $slider->status == 1 ? 'Active' : 'Inactive' }}
                        </td> --}}
                        <td class="d-none d-sm-table-cell py-1 ">
                            <form action="{{ route('footer-sliders.footerToggleStatus', $slider->id) }}" method="POST">
                                @csrf
                                <div class="form-check form-switch toggle-switch-lg flex justify-center">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="toggleExam{{ $slider->id }}"
                                        onchange="if(confirm('Are you sure you want to {{ $slider->status ? 'disable' : 'enable' }} this Slider?')) { this.form.submit(); } else { this.checked = !this.checked; }"
                                        {{ $slider->status ? 'checked' : '' }}>
                                </div>
                            </form>
                        </td>
                        
                        <td>
                            <div class="d-flex gap-2 justify-center">
                                <a href="{{ route('footer-sliders.edit', $slider->id) }}" class="flex items-center gap-2 px-6 py-2 rounded-xl text-sm font-medium bg-blue-500 text-white hover:bg-blue-600 shadow-md transition">Edit</a>
                                <form action="{{ route('footer-sliders.destroy', $slider->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center gap-2 px-6 py-2 rounded-xl text-sm font-medium bg-red-500 text-white hover:bg-red-600 shadow-md transition" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No sliders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@endsection
