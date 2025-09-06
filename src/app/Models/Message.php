<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Message extends Model
{
    use HasFactory;
    protected $fillable = ['purchase_id','user_id','body','is_read','image_path'];
    public function purchase() 
    {
        return $this->belongsTo(Purchase::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
/*メッセージの並び順を「新規メッセージが来た順」にする Controllerにて

$transactions = Purchase::where(function($q) use ($user) {
                        $q->where('user_id', $user->id)       // 自分が購入者
                          ->orWhereHas('item', function($q) use ($user) {
                              $q->where('user_id', $user->id); // 自分が出品者
                          });
                    })
                    ->where('status', 'paid') // 取引中
                    ->with(['item', 'messages' => function($q) {
                        $q->latest(); // 最新順に
                    }])
                    ->get()
                    ->sortByDesc(function($purchase) {
                        return optional($purchase->messages->first())->created_at;
                    });
                    */
                    


