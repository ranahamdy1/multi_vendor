<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id', 'user_id', 'payment_method', 'status', 'payment_status',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Customer'
        ]);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id', 'id', 'id')
            ->using(OrderItem::class)
            ->as('order_item')
            ->withPivot([
                'product_name', 'price', 'quantity', 'options',
            ]);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function addresses()
    {
        return $this->hasMany(OrderAdress::class);
    }

    public function billingAddress()
    {
        return $this->hasOne(OrderAdress::class, 'order_id', 'id')
            ->where('type', '=', 'billing');
    }

    public function shippingAddress()
    {
        return $this->hasOne(OrderAdress::class, 'order_id', 'id')
            ->where('type', '=', 'shipping');
    }
    protected static function booted()
    {
        static::creating(function (Order $order) {
            // 20220001, 20220002
            $order->number = Order::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber()
    {
        // SELECT MAX(number) FROM orders
        $year =  Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');
        if ($number) {
            return $number + 1;
        }
        return $year . '0001';
    }
}
