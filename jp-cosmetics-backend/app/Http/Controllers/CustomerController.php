<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Product;
use App\Services\FileStorageService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{

    protected $fileStorageService;

    public function __construct(FileStorageService $fileStorageService)
    {
        $this->fileStorageService = $fileStorageService;
    }

    public function list()
    {
        $customers = Customer::paginate(10);
        return view('customers.list', compact('customers'));
    }

    public function orders($id)
    {
        $customer = Customer::findOrFail($id);
        $orders = $customer->orders()->orderByDesc('created_at')->paginate(10);

        return view('customers.orders', compact('customer', 'orders'));
    }


    public function edit($id)
    {
        $customer = Customer::with('addresses')->findOrFail($id);
        //return $customer;
        return view('customers.edit', compact('customer'));
    }

    public function update(CustomerUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $customer = Customer::with('addresses')->findOrFail($id);

            $data = $request->validated();

            if ($request->hasFile('image')) {
                if ($customer->image) {
                    $newFile = $request->file('image');
                    $fileToDelete = $customer->image;
                    $imageUploadResponse = $this->fileStorageService->updateFileFromCloud($fileToDelete, $newFile);
                    $data['image'] = $imageUploadResponse['public_path'];
                } else {
                    $image = $request->file('image');
                    $imageUploadResponse = $this->fileStorageService->uploadImageToCloud($image, 'customer');
                    $data['image'] = $imageUploadResponse['public_path'];
                }
            
            } else {
                $data['image'] = $customer->image;
            }
            
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = Hash::make($data['password']);
            }
            
            $customer->update([
                'name'       => $data['name'],
                'email'      => $data['email'],
                'phone'      => $data['phone'],
                'status'     => $data['status'],
                'image'      => $data['image'],
            ]);
            

            if (isset($data['addresses'])) {

                foreach ($data['addresses'] as  $idx => $addressData) {

                    if (isset($addressData['id'])) {
                        $address = CustomerAddress::findOrFail($addressData['id']);
                        if ($address && $address->customer_id == $customer->id) {
                            $address->update([
                                'title' => $addressData['title'],
                                'city' => $addressData['city'],
                                'area' => $addressData['area'],
                                'address' => $addressData['address'],
                                'status' => $addressData['status']
                            ]);
                        }
                    } 
                    else {
                        $newAddress = new CustomerAddress([
                            'customer_id' => $customer->id,
                            'title' => $addressData['title'],
                            'city' => $addressData['city'],
                            'area' => $addressData['area'],
                            'address' => $addressData['address'],
                            'status' => $addressData['status']
                        ]);
                        $newAddress->save();
                    }
                }
            }

            DB::commit();

            Toastr::success('Customer updated successfully.');
            return redirect()->route('customer.list');
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Customer update failed. Please try again.');
            return redirect()->route('customer.list');
        }
    }

    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);

        if ($customer->image && file_exists(public_path($customer->image))) {
            @unlink(public_path($customer->image));
        }

        $customer->delete();

        Toastr::success('Customer deleted successfully.');
        return redirect()->route('customer.list');
    }

}
