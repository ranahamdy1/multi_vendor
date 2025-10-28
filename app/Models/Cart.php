<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class Cart extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        'cookie_id', 'user_id', 'product_id', 'quantity', 'options',
    ];

    protected static function booted()
    {
        static::observe(CartObserver::class);
        static::addGlobalScope('cookie_id',function(Builder $builder) {
            $builder->where('cookie_id','=',Cart::getCookieId());
        });
    }

    public static function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 30*60*24);
        }
        return $cookie_id;
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Anonymous'
        ]);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
