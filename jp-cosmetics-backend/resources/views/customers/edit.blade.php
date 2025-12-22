@extends('master')

@section('contents')

<div class="rounded shadow-sm">
    <div class="p-3 rounded-top" style="background-color: rgb(119, 82, 125); color:#ffffff">
        <h3 class="fs-5">Edit Customer</h3>
    </div>

    <form action="{{ route('customer.update', $customer->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-bottom">
        @csrf

        <div class="row g-4">
            <!-- Customer Image -->
            <div class="col-md-3 text-center">
                <div class="position-relative border rounded bg-light d-flex align-items-center justify-content-center" style="min-height:240px;">
                    <img id="customerImagePreview" src="{{ asset($customer->image ?? 'imagePH.png') }}" alt="Customer Image" class="w-100 h-100 object-fit-cover rounded"/>
                    <button type="button" id="removeCustomerImage" class="btn btn-sm btn-light bg-white border position-absolute top-0 end-0 rounded-circle">×</button>
                </div>
                <input type="file" accept="image/*" id="customerImageInput" name="image" class="d-none" />
                <label for="customerImageInput" class="btn btn-dark mt-3 w-100">Choose Customer Image</label>
                @error('image') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- Customer Fields -->
            <div class="col-md-9 mt-10">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Name</label>
                        <input required type="text" name="name" id="name" class="form-control" placeholder="Enter First Name" value="{{ old('name', $customer->name) }}" />
                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input required type="email" name="email" id="email" class="form-control" placeholder="Enter Email" value="{{ old('email', $customer->email) }}" />
                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Phone Number" value="{{ old('phone', $customer->phone) }}" />
                        @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>



                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ old('status', $customer->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $customer->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="banned" {{ old('status', $customer->status) == 'banned' ? 'selected' : '' }}>Banned</option>
                        </select>
                        @error('status') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Addresses -->
        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="m-0">Customer Addresses</h5>
                <button class="btn btn-sm btn-outline-primary" type="button" id="addAddressBtn">+ Add Address</button>
            </div>
            <small class="text-muted d-block mt-1">
                Add one or more addresses for the customer.
            </small>

            <div id="addressesContainer" class="mt-3">
                @php $oldAddresses = old('addresses', $customer->addresses->toArray()); @endphp

                @foreach($oldAddresses as $idx => $address)
                    <div class="address-row border-2 rounded p-3 mb-3" data-address-row="{{ $idx }}">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong>Address #{{ $idx + 1 }}</strong>
                            <button class="btn btn-sm btn-outline-danger btn-remove-address" type="button">Remove</button>
                        </div>

                        <div class="row g-3">
                            <!-- Hidden Field for Address ID -->
                            <input type="hidden" name="addresses[{{ $idx }}][id]" value="{{ $address['id'] }}" />

                            <div class="col-md-4">
                                <label class="form-label">Title</label>
                                <input type="text" name="addresses[{{ $idx }}][title]" class="form-control" value="{{ $address['title'] ?? '' }}" placeholder="e.g., Home, Office">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" name="addresses[{{ $idx }}][city]" class="form-control" value="{{ $address['city'] ?? '' }}" placeholder="City">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Area (Optional)</label>
                                <input type="text" name="addresses[{{ $idx }}][area]" class="form-control" value="{{ $address['area'] ?? '' }}" placeholder="Area">
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="addresses[{{ $idx }}][status]" class="form-select">
                                    <option value="1" {{ isset($address['status']) && $address['status'] == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ isset($address['status']) && $address['status'] == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label">Address</label>
                                <textarea name="addresses[{{ $idx }}][address]" class="form-control" rows="2">{{ $address['address'] ?? '' }}</textarea>
                            </div>
                            {{-- <div class="col-md-2">
                                <label class="form-label d-block">Default?</label>
                                <div class="form-check">
                                    <input
                                        class="form-check-input default-address-radio"
                                        type="radio"
                                        name="default_address_key"
                                        value="{{ $idx }}"
                                        {{ (isset($address['is_default']) && $address['is_default']) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label">Set as default</label>
                                </div>
                            </div> --}}

                            {{-- place it in rowHtml after Address. in controller, if a address is default (DB) = current index is selected for default then skip otherwise check and update --}}
                            {{-- <div class="col-md-2">
                                <label class="form-label d-block">Default?</label>
                                <div class="form-check">
                                    <input class="form-check-input default-address-radio" type="radio" name="default_address_key" value="${i}">
                                    <label class="form-check-label">Set as default</label>
                                </div>
                            </div> --}}
            
                        </div>
                    </div>
                @endforeach

                @error('addresses.*.*') <div class="text-danger mt-2">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row g-3 mt-4">
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary px-4">Update Customer</button>
            </div>
        </div>
    </form>
</div>

<!-- JS -->
<script>
    const customerImageInput = document.getElementById('customerImageInput');
    const customerImagePreview = document.getElementById('customerImagePreview');
    document.getElementById('customerImageInput').addEventListener('change', e => {
        const f = e.target.files[0]; if (!f) return;
        const r = new FileReader(); r.onload = ev => customerImagePreview.src = ev.target.result; r.readAsDataURL(f);
    });
    document.getElementById('removeCustomerImage').addEventListener('click', () => {
        customerImagePreview.src = "{{ asset('imagePH.png') }}";
        customerImageInput.value = "";
    });

    const container = document.getElementById('addressesContainer');
    let idx = Array.from(container.querySelectorAll('[data-address-row]'))
        .reduce((m, el) => Math.max(m, parseInt(el.getAttribute('data-address-row'), 10)), -1);
    if (isNaN(idx)) idx = 0;

    document.getElementById('addAddressBtn').addEventListener('click', () => {
        idx++;
        container.insertAdjacentHTML('beforeend', rowHtml(idx));
    });

    container.addEventListener('click', e => {
        if (e.target.matches('.btn-remove-address')) {
            e.preventDefault();
            e.target.closest('.address-row')?.remove();
        }
    });

    function rowHtml(i) {
        return `
        <div class="address-row border rounded p-3 mb-3" data-address-row="${i}">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong>Address #${i + 1}</strong>
                <button class="btn btn-sm btn-outline-danger btn-remove-address" type="button">Remove</button>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Title</label>
                    <input type="text" name="addresses[${i}][title]" class="form-control" placeholder="e.g., Home, Office">
                </div>
                <div class="col-md-4">
                    <label class="form-label">City</label>
                    <input type="text" name="addresses[${i}][city]" class="form-control" placeholder="City">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Area (Optional)</label>
                    <input type="text" name="addresses[${i}][area]" class="form-control" placeholder="Area">
                </div>
            </div>
            <div class="row g-3 mt-1">
                
            </div>
            <div class="row g-3 mt-1">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="addresses[${i}][status]" class="form-select">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="col-md-7">
                    <label class="form-label">Address</label>
                    <textarea name="addresses[${i}][address]" class="form-control" rows="2"></textarea>
                </div>
            </div>
        </div>`;
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('addressesContainer');
    
        function ensureOneDefaultChecked() {
            const radios = container.querySelectorAll('.default-address-radio');
            if (!radios.length) return;
            const anyChecked = Array.from(radios).some(r => r.checked);
            if (!anyChecked) radios[0].checked = true;
        }
    
        // On load
        ensureOneDefaultChecked();
    
        // When adding a row, select it by default if none selected yet
        document.getElementById('addAddressBtn').addEventListener('click', () => {
            // slight delay to allow rowHtml to insert
            setTimeout(ensureOneDefaultChecked, 0);
        });
    
        // When removing a row, keep at least one checked
        container.addEventListener('click', (e) => {
            if (e.target.matches('.btn-remove-address')) {
                setTimeout(ensureOneDefaultChecked, 0);
            }
        });
    });
    </script>
    

@endsection
