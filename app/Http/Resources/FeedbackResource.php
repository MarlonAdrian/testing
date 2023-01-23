<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
{

    public function toArray($request)
    {

        return[
            'id'=> $this->id,
            'picture' => $this->product->path_image,                       
            'product' => $this->product->name_product,
            'score'=> $this->score,
            'comment'=>$this->comment,
            'comment_by'=> $this->user->getFullName(),

        ];
    }
}
