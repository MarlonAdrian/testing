<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'received',
        'product_id',
        'amount',
    ];  
    
    //Relación de uno a muchos
    public function user()
    {
        return $this->belongsTo(User::class);
    }      
    
    // public function product()
    // {
    //     return $this->hasOne(Product::class);
    // }    

    // Relación de uno a muchos
    // Un pedido le pertenece un producto    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }    
}
