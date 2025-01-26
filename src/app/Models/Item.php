<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id','name','brand_name','image','price','description','condition_id'
    ];
    public function condition() {
        return $this->belongsTo(Condition::class);
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function likes() {
        return $this->hasMany(Like::class);
    }
    public function purchase() {
        return $this->hasOne(Purchase::class);
    }
    public function categories() {
        return $this->belongsToMany(Category::class,'category-item');
    }
         
}
