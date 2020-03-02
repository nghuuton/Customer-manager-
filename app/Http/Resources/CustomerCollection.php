<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($customers){
                return [
                    'id'        => $customers->id,
                    'name'      => $customers->name,
                    'email'     => $customers->email,
                    'phone'     => $customers->phone,
                    'address'   => $customers->address,
                    'total'     => $customers->total
                ];
            })
        ];
    }
}
