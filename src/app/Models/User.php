<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    //  MustVerifyEmailTraitを入れるとTrait 'App\Models\MustVerifyEmailTrait' not foundエラーになる

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile() {
        return $this->hasOne(Profile::class);
    }
    public function items() {
        return $this->hasMany(Item::class);
    }
    public function comments() {
        return $this->hasMany(Comment::class);
        
    }
    public function likedItems() {
        
        return $this->belongsToMany(Item::class, 'likes', 'user_id', 'item_id')->withTimestamps();
    }
    public function purchases() {
        return $this->hasMany(Purchase::class);
    }
    public function buyItems()
    {
        return $this->belongsToMany(Item::class,'purchases','user_id','item_id')
        ->withPivot('payment_method', 'shipping_address', 'shipping_post_code', 'shipping_building')
        ->withTimestamps();
    }
    public function sellItems()
    {
        return $this->hasMany(Item::class,'user_id');
    }
}
