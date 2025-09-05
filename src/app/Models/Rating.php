<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = ['purchase_id', 'from_user_id','to_user_id', 'rating'];
    public function fromUser() {
        return $this->belongsTo(User::class, 'from_user_id');
    }
    public function toUser() {
        return $this->belongsTo(User::class, 'to_user_id');
    }
    public function purchase() {
        return $this->belongsTo(Purchase::class);
    }
    
}
