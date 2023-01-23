<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [    
            'product_id'=> $this->id,              
            'product' => $this->product->name_product,
            'description' => $this->product->description,
            'amount' => $this->amount,

            // 'product_id'=> $this->id,                  
            // 'name_product' => $this->name_product,
            // 'amount' =>$this->amount,
        ]; 
    }
}
