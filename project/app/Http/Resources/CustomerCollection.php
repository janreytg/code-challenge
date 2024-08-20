<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function($customer) {
                return [
                    'full_name' => $customer->getFullName(),
                    'email' => $customer->getEmail(),
                    'country' => $customer->getCountry(),
                    // Add other fields you want to include
                ];
            }),
            'meta' => [
                'total_customers' => $this->collection->count(),
                // Add any additional metadata you need
            ],
        ];
    }
}
