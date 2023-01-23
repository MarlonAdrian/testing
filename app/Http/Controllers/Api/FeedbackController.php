<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Http\Resources\FeedbackResource;

class FeedbackController extends Controller
{
    public function feedbacks(){
        $feedbacks = Feedback::all();
        return FeedbackResource::collection($feedbacks);
    }
}
