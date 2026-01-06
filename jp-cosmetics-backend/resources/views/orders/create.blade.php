@extends('master')

@section('contents')

<style>
    .prod-thumb { width: 52px; height: 52px; object-fit: cover; border-radius: 8px; }
    .badge-soft { background: #f6f7fb; border: 1px solid #e4e6ef; color: #5e6278; }
    .input-w-120 { max-width: 120px; }
    .input-w-140 { max-width: 140px; }
    .sticky-bottom-bar {
        position: sticky; bottom: 0; z-index: 9;
        background: #fff; border-top: 1px solid #e9ecef;
    }
</style>

<div class="rounded shadow-sm">
    <div class="p-3 rounded-top d-flex justify-content-between align-items-center"
         style="background-color: rgb(119, 82, 125); color:#ffffff">
        <h3 class="fs-5 m-0">Create Order</h3>
        {{-- @hasPermission('orders.index')
        <a href="{{ route('orders.index') }}" class="btn btn-light btn-sm">Back to List</a>
        @endHasPermission --}}
    </div>

    <form action="" method="POST" class="bg-white p-4 rounded-bottom" id="orderForm">
        @csrf

        {{-- TOP: Customer & Address --}}
        <div class="row g-4">
            <div class="col-lg-4">
                <label class="form-label">Customer <span class="text-danger">*</span></label>
                <select name="customer_id" id="customer_id" class="form-select" required>
                    <option value="">Select Customer</option>
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}"
                            data-name="{{ $c->name }}"
                            data-phone="{{ $c->phone }}"
                            data-email="{{ $c->email }}"
                        >
                            #{{ $c->id }} — {{ $c->name }} ({{ $c->phone }})
                        </option>
                    @endforeach
                </select>
                @error('customer_id') <div class="text-danger">{{ $message }}</div> @enderror
                <div class="small text-muted mt-1">Selecting customer will load their saved addresses below.</div>
            </div>

            <div class="col-lg-8">
                <label class="form-label d-flex justify-content-between">
                    <span>Shipping Address <span class="text-danger">*</span></span>
                    <span class="badge badge-soft">One must be default</span>
                </label>
                <div id="addressList" class="row g-2">
                    {{-- Filled by JS when customer selected --}}
                    <div class="text-muted small">Choose a customer to view addresses…</div>
                </div>
                <input type="hidden" name="customer_address_id" id="customer_address_id">
                @error('customer_address_id') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <hr class="my-4">

        {{-- ITEMS --}}
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="m-0">Items</h5>
            <button type="button" class="btn btn-sm btn-outline-primary" id="addItemBtn">+ Add Item</button>
        </div>
        <small class="text-muted d-block mt-1">Pick a product then its attribute/variant. Quantity must respect min/max.</small>

        <div class="table-responsive mt-3">
            <table class="table align-middle" id="itemsTable">
                <thead class="table-light">
                <tr>
                    <th style="width: 22%">Product</th>
                    <th style="width: 22%">Attribute / Variant</th>
                    <th style="width: 10%">Unit Price</th>
                    <th style="width: 11%">Qty</th>
                    <th style="width: 13%">Row Discount</th>
                    <th style="width: 12%">Row Subtotal</th>
                    <th style="width: 8%"></th>
                </tr>
                </thead>
                <tbody id="itemsBody">
                {{-- JS rows here --}}
                </tbody>
            </table>
        </div>

        {{-- BOTTOM: totals + payment --}}
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-select">
                            <option value="COD">COD</option>
                            <option value="online">Online</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select">
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="cancel">Cancel</option>
                            <option value="failed">Failed</option>
                            <option value="success">Success</option>
                            <option value="refunded">Refunded</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Payment Channel (optional)</label>
                        <input type="text" name="payment_channel" class="form-control" placeholder="bKash/Nagad/SSLCommerz/etc.">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Transaction ID (optional)</label>
                        <input type="text" name="transaction_id" class="form-control" placeholder="TXN123...">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Order Note (customer-facing)</label>
                        <textarea name="order_note" rows="2" class="form-control" placeholder="Any note for the order…"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Remarks (internal)</label>
                        <textarea name="remarks" rows="2" class="form-control" placeholder="Internal remarks…"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Receiver Name</label>
                        <input type="text" name="receiver_name" id="receiver_name" class="form-control" placeholder="Auto-fill from address">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Receiver Phone</label>
                        <input type="text" name="receiver_phone" id="receiver_phone" class="form-control" placeholder="Auto-fill from customer">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Order Status</label>
                        <select name="status" class="form-select">
                            <option value="pending">Pending</option>
                            <option value="confirm">Confirm</option>
                            <option value="dispatched">Dispatched</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="returned">Returned</option>
                            <option value="success">Success</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="border rounded p-3">
                    <div class="d-flex justify-content-between mb-2">
                        <div>Sub Total</div>
                        <div>
                            <input type="text" readonly class="form-control text-end input-w-140" id="sub_total_amount_show">
                            <input type="hidden" name="sub_total_amount" id="sub_total_amount">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <div>Delivery Charge</div>
                        <div>
                            <input type="number" step="0.01" value="0" class="form-control text-end input-w-140" name="delivery_charge" id="delivery_charge">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <div>Order Discount</div>
                        <div>
                            <input type="number" step="0.01" value="0" class="form-control text-end input-w-140" name="discount_amount" id="discount_amount">
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Grand Total</strong>
                        <div>
                            <input type="text" readonly class="form-control text-end input-w-140 fw-bold" id="payable_total_show">
                            <input type="hidden" name="payable_total" id="payable_total">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sticky-bottom-bar mt-4 py-3 d-flex justify-content-end">
            @hasPermission('orders.store')
            <button type="submit" class="btn btn-primary px-4">Place Order</button>
            @endHasPermission
        </div>
    </form>
</div>

{{-- ===== DATASET FOR JS (no AJAX required) ===== --}}
@php
    use Illuminate\Support\Str;

    $datasetCustomers = $customers->map(function ($c) {
        return [
            'id'    => $c->id,
            'name'  => trim($c->name ?? ''),
            'phone' => $c->phone,
            'email' => $c->email,
            'addresses' => $c->addresses->map(function ($a) {
                return [
                    'id'         => $a->id,
                    'title'      => $a->title,
                    'city'       => $a->city,
                    'area'       => $a->area,
                    'address'    => $a->address,
                    'is_default' => $a->is_default ? 1 : 0,
                ];
            })->values()->all(),
        ];
    })->values()->all();

    $datasetProducts = $products->map(function ($p) {
           

        return [
            'id'   => $p->id,
            'name' => $p->name,
            'img'  => $p->primary_image,
            'attributes' => $p->attributes->map(function ($a) {
                return [
                    'id'              => $a->id,
                    'name'            => $a->attribute_name,
                    'value'           => $a->attribute_value,
                    'unit_price'      => (float) ($a->unit_price ?? 0),
                    'stock'           => (int) $a->stock,
                    'min_order'       => (int) ($a->min_order ?? 1),
                    'max_order'       => is_null($a->max_order) ? null : (int) $a->max_order,
                    'discount_type'   => $a->discount_type,            // null|fixed|percentage
                    'discount_amount' => (float) ($a->discount_amount ?? 0),
                ];
            })->values()->all(),
        ];
    })->values()->all();
@endphp

<script>
    const DATASET = {
        customers: @json($datasetCustomers),
        products: @json($datasetProducts),
    };
</script>



<script>
(function(){
    const customerSel = document.getElementById('customer_id');
    const addressList = document.getElementById('addressList');
    const addressHidden = document.getElementById('customer_address_id');
    const receiverName = document.getElementById('receiver_name');
    const receiverPhone = document.getElementById('receiver_phone');

    const itemsBody = document.getElementById('itemsBody');
    const addItemBtn = document.getElementById('addItemBtn');

    const subTotalShow = document.getElementById('sub_total_amount_show');
    const subTotalInp  = document.getElementById('sub_total_amount');
    const deliveryInp  = document.getElementById('delivery_charge');
    const orderDiscInp = document.getElementById('discount_amount');
    const totalShow    = document.getElementById('payable_total_show');
    const totalInp     = document.getElementById('payable_total');

    let rowIdx = 0;

    function money(n){ return (Number(n||0)).toFixed(2); }

    function computeRow(row){
        const priceEl = row.querySelector('.unit_price');
        const qtyEl   = row.querySelector('.qty');
        const discEl  = row.querySelector('.row_discount');
        const subEl   = row.querySelector('.row_subtotal');

        const price = parseFloat(priceEl.value || 0);
        const qty   = parseInt(qtyEl.value || 0, 10);
        const disc  = parseFloat(discEl.value || 0);

        const sub   = Math.max(0, (price * qty) - disc);
        subEl.value = money(sub);
    }

    function computeTotals(){
        let sub = 0;
        itemsBody.querySelectorAll('.row_subtotal').forEach(i => sub += parseFloat(i.value||0));
        subTotalShow.value = money(sub);
        subTotalInp.value  = money(sub);

        const del = parseFloat(deliveryInp.value||0);
        const od  = parseFloat(orderDiscInp.value||0);

        const grand = Math.max(0, sub + del - od);
        totalShow.value = money(grand);
        totalInp.value  = money(grand);
    }

    function fillAddressesFor(customerId){
        addressList.innerHTML = '';
        addressHidden.value = '';
        receiverName.value = '';
        receiverPhone.value = '';

        const c = DATASET.customers.find(x=> String(x.id) === String(customerId));
        if(!c){
            addressList.innerHTML = '<div class="text-muted small">No addresses found.</div>';
            return;
        }
        // default selection
        let defId = null;
        if (c.addresses.length){
            const def = c.addresses.find(a=>a.is_default==1) || c.addresses[0];
            defId = def.id;
        }
        addressHidden.value = defId || '';

        // receiver autofill
        receiverName.value = c.name || '';
        receiverPhone.value = c.phone || '';

        const rows = c.addresses.map(a=>{
            const checked = (String(a.id) === String(defId)) ? 'checked' : '';
            const addrTxt = [a.title, a.area, a.city].filter(Boolean).join(' • ');
            return `
            <div class="col-md-6">
                <label class="border rounded p-2 w-100 d-flex align-items-start gap-2">
                    <input type="radio" name="address_radio" class="form-check-input mt-1"
                           value="${a.id}" ${checked}>
                    <span>
                        <div class="fw-semibold">${a.title}</div>
                        <div class="small text-muted">${a.address}</div>
                        <div class="small">${addrTxt}</div>
                    </span>
                </label>
            </div>`;
        }).join('');

        addressList.innerHTML = rows || '<div class="text-muted small">No addresses on record.</div>';
    }

    function rowTemplate(i){
        const productOpts = DATASET.products.map(p=>`<option value="${p.id}">${p.name}</option>`).join('');
        return `
        <tr data-row="${i}">
            <td>
                <select name="items[${i}][product_id]" class="form-select prod_sel" required>
                    <option value="">Select Product</option>
                    ${productOpts}
                </select>
            </td>
            <td>
                <select name="items[${i}][product_attribute_id]" class="form-select attr_sel" required disabled>
                    <option value="">Select Attribute</option>
                </select>
                <div class="form-text small stock_hint"></div>
            </td>
            <td>
                <input type="text" class="form-control text-end unit_price input-w-120" name="items[${i}][unit_price]" readonly>
            </td>
            <td>
                <input type="number" class="form-control text-end qty input-w-120" name="items[${i}][quantity]" value="1" min="1">
            </td>
            <td>
                <input type="text" class="form-control text-end row_discount input-w-120" name="items[${i}][discount_amount]" value="0" readonly>
            </td>
            <td>
                <input type="text" class="form-control text-end row_subtotal input-w-120" name="items[${i}][sub_total]" readonly>
                <input type="hidden" name="items[${i}][payable]" class="row_payable">
                <input type="hidden" name="items[${i}][coupon_id]" value="">
            </td>
            <td class="text-end">
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row">Remove</button>
            </td>
        </tr>`;
    }

    function refreshAttrOptions(row, productId){
        const attrSel   = row.querySelector('.attr_sel');
        const priceEl   = row.querySelector('.unit_price');
        const qtyEl     = row.querySelector('.qty');
        const discEl    = row.querySelector('.row_discount');
        const stockHint = row.querySelector('.stock_hint');

        attrSel.innerHTML = `<option value="">Select Attribute</option>`;
        attrSel.disabled = true;
        priceEl.value = '';
        discEl.value = '0';
        stockHint.textContent = '';
        qtyEl.min = 1;
        qtyEl.removeAttribute('max');

        const prod = DATASET.products.find(p=> String(p.id) === String(productId));
        if(!prod) return;
        if (!prod.attributes.length) return;

        const opts = prod.attributes.map(a=>{
            let tag = a.name && a.value ? `${a.name}: ${a.value}` : (a.value || a.name);
            const priceText = a.unit_price ? ` — ${Number(a.unit_price).toFixed(2)}` : '';
            return `<option value="${a.id}"
                        data-price="${a.unit_price||0}"
                        data-stock="${a.stock||0}"
                        data-min="${a.min_order||1}"
                        data-max="${a.max_order||''}"
                        data-dtype="${a.discount_type||''}"
                        data-damt="${a.discount_amount||0}"
                    >${tag}${priceText}</option>`;
        }).join('');

        attrSel.innerHTML = `<option value="">Select Attribute</option>${opts}`;
        attrSel.disabled = false;
    }

    function onAttrChanged(row){
        const attrSel = row.querySelector('.attr_sel');
        const sel = attrSel.options[attrSel.selectedIndex];
        if(!sel || !sel.value){
            row.querySelector('.unit_price').value = '';
            row.querySelector('.row_discount').value = '0';
            computeRow(row); computeTotals();
            return;
        }
        const price = parseFloat(sel.dataset.price || 0);
        const stock = parseInt(sel.dataset.stock || 0,10);
        const minO  = parseInt(sel.dataset.min || 1,10);
        const maxO  = sel.dataset.max ? parseInt(sel.dataset.max,10) : null;
        const dType = sel.dataset.dtype || '';
        const dAmt  = parseFloat(sel.dataset.damt || 0);

        // set UI fields
        row.querySelector('.unit_price').value = money(price);

        const qtyEl = row.querySelector('.qty');
        qtyEl.value = Math.max(minO, parseInt(qtyEl.value||minO,10));
        qtyEl.min = minO;
        if (maxO) qtyEl.max = maxO; else qtyEl.removeAttribute('max');

        const stockHint = row.querySelector('.stock_hint');
        const limits = [];
        if (!isNaN(stock)) limits.push(`Stock: ${stock}`);
        if (minO) limits.push(`Min: ${minO}`);
        if (maxO) limits.push(`Max: ${maxO}`);
        stockHint.textContent = limits.join(' | ');

        // compute row discount (from attribute)
        let rowDisc = 0;
        if (dType === 'fixed') rowDisc = dAmt;
        else if (dType === 'percentage') rowDisc = (price * (dAmt/100));
        row.querySelector('.row_discount').value = money(rowDisc);

        computeRow(row); computeTotals();
    }

    function addRow(){
        const i = rowIdx++;
        itemsBody.insertAdjacentHTML('beforeend', rowTemplate(i));
    }

    // EVENTS
    customerSel.addEventListener('change', e=>{
        const id = e.target.value;
        fillAddressesFor(id);
    });

    addressList.addEventListener('change', e=>{
        if (e.target.name === 'address_radio'){
            addressHidden.value = e.target.value;
        }
    });

    addItemBtn.addEventListener('click', addRow);

    itemsBody.addEventListener('click', e=>{
        if (e.target.matches('.btn-remove-row')){
            e.preventDefault();
            e.target.closest('tr')?.remove();
            computeTotals();
        }
    });

    itemsBody.addEventListener('change', e=>{
        const row = e.target.closest('tr');
        if (e.target.matches('.prod_sel')){
            refreshAttrOptions(row, e.target.value);
        }
        if (e.target.matches('.attr_sel')){
            onAttrChanged(row);
        }
        if (e.target.matches('.qty')){
            // clamp to min/max
            const min = e.target.min ? parseInt(e.target.min,10) : 1;
            const max = e.target.max ? parseInt(e.target.max,10) : null;
            let v = parseInt(e.target.value||min,10);
            if (isNaN(v) || v < min) v = min;
            if (max && v > max) v = max;
            e.target.value = v;
            computeRow(row); computeTotals();
        }
    });

    [deliveryInp, orderDiscInp].forEach(el=>{
        el.addEventListener('input', computeTotals);
    });

    // INIT
    addRow();
    computeTotals();

})();
</script>

@endsection
