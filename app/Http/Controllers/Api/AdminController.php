<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\UserResource;
use App\Http\Resources\FeedbackResource;
use App\Http\Resources\CommerceResource;
use App\Http\Resources\ProductResource;
use App\Models\User;
use App\Models\Commerce;
use App\Models\Product;
use App\Models\Feedback;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('indexProducts');
        $this->middleware('can:manage-personal');
        $this->middleware('can:manage-commerces');
    }

/*----MANAGE USER---*/    
    public function indexUsers()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function showUser($id){
        return new UserResource(User::findOrFail($id));
    }    

    public function destroyUser($id){
        User::destroy($id);
        return with(
            ['msg' => 'user_removed']);
    }      

/*----MANAGE COMMERCE---*/ 
    public function indexCommerces()
    {
        $commerces = Commerce::all();
        return CommerceResource::collection($commerces);
    }

    public function showCommerce($id){
        return new CommerceResource(Commerce::findOrFail($id));
    }    

    public function destroyCommerce($id){
        $id = Commerce::with('user')->where('id', $id)->select('user_id')->pluck('user_id')->first();
        $user_id=$id;

        User::destroy($user_id);
        return with(
            ['msg' => 'commerce_removed']); 
    }  
/*----MANAGE PRODUCT---*/ 
    public function indexProducts()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }
    public function showaProduct($id){
        return new ProductResource(Product::findOrFail($id));
    }    

/*----MANAGE FEEDBACK---*/  
    public function showFeedback($id){
        return new FeedbackResource(Feedback::findOrFail($id));
    }      
}
