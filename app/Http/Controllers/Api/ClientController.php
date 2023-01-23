<?php

namespace App\Http\Controllers\Api;
use DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ClientProductResource;
use App\Http\Resources\FeedbackResource;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;
class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('showproducts','showfeedbacks');
        $this->middleware('can:manage-orders')->except('showproducts','showfeedbacks');
    }

    /*-----SHOW ALL PRODUCT-----*/
    public function showproducts(){
        $products = Product::all();
        return ProductResource::collection($products);
    }
    
    /*-----OBTAIN ALL MY PRODUCTS-----*/
    public function myallorders(){

        $my_products = ProductOrder::whereHas(
            'user', function($q){
                $q->where('user_id', Auth::user()->id);
            }
        )->get();

        return with([
            'my_orders'=>ClientProductResource::collection($my_products)]);
    }
    /*-----ORDER PRODUCT-----*/
    public function orderProduct(Request $request){
        $client = Auth::user();
        $request->validate([
            'id' => ['required', 'numeric'],
            'amount' => ['required', 'numeric','min:1'],
        ]);   

        $gettingstock = Product::with('product')
                                    ->where('id', $request->id)
                                    ->select('stock')
                                    ->pluck('stock')
                                    ->first();

        if($request->amount <= $gettingstock){
            $order = ProductOrder::create([
                'product_id' => $request['id'],
                'user_id'=>Auth::user()->select('id')->pluck('id')->first(),
                'amount' => $request['amount'],
            ]);
            
            $client->productorder()->save($order); 

            /*--Owner Contact--*/
            $product_byuser_id = Product::with('user')
                                        ->where('id', $order->product_id)
                                        ->select('user_id')
                                        ->pluck('user_id')
                                        ->first();
            $contact_owner = User::with('user')
                                ->where('id', $product_byuser_id)
                                ->select('personal_phone')
                                ->pluck('personal_phone')
                                ->first();
            
            /*--Product Name--*/
            $product_name=Product::with('product')
                                ->where('id', $order->product_id)
                                ->select('name_product')
                                ->pluck('name_product')
                                ->first();

            /*--Reducing amount from the stock--*/
            DB::update('update products set stock = ? where id = ?',[$gettingstock-$request->amount,$order->product_id]);
   
            return with(
                ['msg'=> 'Thank you so much! This is your order',
                'name_product' => $product_name,
                'amount' => $order->amount,
                'owner_contact' => $contact_owner]);
        }else{
            return Response::deny('The amount is higher than the stock, try with less number than '.$gettingstock);
        }
    }
    /*--SHOW MY PRODUCT ORDER--*/
    public function showMyProduct(ProductOrder $id){   
        /*--Info my Order--- */
        if(Auth::user()->id == $id->user_id){ 
            $product=ProductOrder::find($id->id);
            $probando=new ClientProductResource(ProductOrder::find($id->id));

        /*---Contact Owner---*/
            $productOwner = ProductOrder::with('product')
                                        ->where('id', $id->id)
                                        ->select('product_id')
                                        ->pluck('product_id')
                                        ->first();
            $info_owner = Product::with('user')
                                ->where('id', $productOwner)
                                ->select('user_id')
                                ->pluck('user_id')
                                ->first();
            $contact_owner = User::with('user')
                                ->where('id', $info_owner)
                                ->select('personal_phone')
                                ->pluck('personal_phone')
                                ->first();            
            return with([
                'my_order'=>$probando,
                'product_owner_contact' => $contact_owner]);
        } else{
            return Response::deny('You do not own this product');
        } 
    }
    /*--EDIT MY PRODUCT ORDER--*/
    public function editOrderProduct(Request $request,ProductOrder $id){        
        if(Auth::user()->id == $id->user_id){
            $request->validate([
                'amount' => ['required', 'numeric','min:1'],
            ]); 
            
            $gettingProductId = ProductOrder::with('productorder')
                                    ->where('id', $id->id)
                                    ->select('product_id')
                                    ->pluck('product_id')
                                    ->first();    //Get just id from productorder table

            $gettingStock = Product::with('product')
                                    ->where('id', $gettingProductId)
                                    ->select('stock')
                                    ->pluck('stock')
                                    ->first();    //Get stock from product table

            if($id->amount > $request->amount){
                $rest=$id->amount - $request->amount;
                DB::update('update products set stock = ? where id = ?',[$gettingStock+$rest,$gettingProductId]);
                $id->update(
                    [ 
                        'amount' => $request['amount'],
                    ]);     
                return Response::allow('Order updated');                   
            } else{                 
                $rest=$gettingStock+$id->amount-$request->amount;
                DB::update('update products set stock = ? where id = ?',[$rest,$gettingProductId]);
                $id->update(
                    [ 
                        'amount' => $request['amount'],
                    ]); 
                return Response::allow('Order updated');                      
            }                                                                                                            
               
        }else{
            return Response::deny('You do not own this product');
        }
    }
    /*-----FEEDBACK-----*/
    public function showfeedbacks(){
        $feedbacks = Feedback::all();
        return FeedbackResource::collection($feedbacks);
    }

    public function showmyfeedbacks(){
        $my_feedbacks = Feedback::whereHas(
            'user', function($q){
                $q->where('user_id', Auth::user()->id);
            }
        )->get();

        return with([
            'my_feedbacks'=>FeedbackResource::collection($my_feedbacks)]);

        // $feedbacks = Feedback::all();
        // return FeedbackResource::collection($feedbacks);
    }

    public function postfeedback(Request $request){
        $client = Auth::user();
        $request->validate([
            'product_id' => ['required', 'numeric'],
            'score' => ['required', 'string'],
            'comment' => ['required', 'string','unique:feedback', ],
        ]);   

        $feedback = Feedback::create([
            'product_id' => $request['product_id'],
            'score' => $request['score'],
            'comment' => $request['comment'],
            'user_id'=>Auth::user()->select('id')->pluck('id')->first()
        ]);        
        $client->feedback()->save($feedback);    
        
        return with(['message' => 'Feedback created']);        
    }
    public function editfeedback(Request $request, Feedback $id){
        if(Auth::user()->id == $id->user_id){
            $request->validate([
                'product_id' => ['required','numeric'],
                'score' => ['string'],
                'comment' => [ 'string','unique:feedback'],
            ]); 
            
            $id->update(
                [
                    'product_id' => $request['product_id'],
                    'score' => $request['score'],
                    'comment' => $request['comment'],
                ]);
            return Response::allow('Feedback updated');
        } else{
            return Response::deny('You do not own this feedback');
        }  
    }  
    public function destroyfeedback(Feedback $id){
        if(Auth::user()->id == $id->user_id){
            Feedback::destroy($id->id);
            return with(['message' => 'feedback_removed']);
        } else{
            return Response::deny('You do not own this feedback');
        }    
    }      
}