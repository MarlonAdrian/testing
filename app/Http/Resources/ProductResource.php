<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code_product' => $this->code_product,
            'picture' => $this->path_image,                       
            'name_product' => $this->name_product,
            'description' => $this->description,
            'price' => $this->price,
            // 'name_commerce' => $this->user->commerces->name_commerce,
            'name_owner' => $this->user->getFullName(), 
        ]; 
    }
}
