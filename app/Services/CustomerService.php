<?php

namespace App\Services;

use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;

class CustomerService
{
    public function addCustomer(StoreCustomerRequest $customerRequest)
    {
        $dataToStore = [
            "name" => $customerRequest->name,
            "location" => $customerRequest->location,
        ];
        $customer = new Customer($dataToStore);
        $customer->save();
        return $customer;
    }
}
