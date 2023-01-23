<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'name' => $this->getFullName(),
            'role' => $this->role->name,
            'email' => $this->email,
            'birthdate' => $this->birthdate,
            'personal_phone' => $this->personal_phone,
            'address' => $this->address,
            // 'token' => $this->token
        ];        
    }
}
