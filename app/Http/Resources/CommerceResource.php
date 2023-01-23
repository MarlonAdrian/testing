<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommerceResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name_commerce' => $this->name_commerce,
            'name_owner' => $this->user->getFullName(), 
            'state'=> $this->state,
            'contact'=> $this->user->personal_phone,
        ]; 
    }
}
