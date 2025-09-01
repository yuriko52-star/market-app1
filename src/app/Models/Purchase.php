<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

      protected $fillable = [
        'user_id','item_id','payment_method','shipping_address','shipping_post_code',
        'shipping_building','status',
    ];
    public function buyer() {
        return $this->belongsTo(User::class,'user_id');
    }
    public function item() {
        return $this->belongsTo(Item::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
