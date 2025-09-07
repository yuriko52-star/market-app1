<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;
     protected $fillable = [
        'content'
    ];
    public function items() {
       return $this->hasMany(Item::class); 
    }
}
