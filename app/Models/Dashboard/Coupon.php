<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dashboard\Order;
use Illuminate\Support\Str;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'usage_limit',
        'used_count',
        'expiry_date',
        'status',
        'discount_amount',
        'type',
    ];

    public function orders()
    {
        return $this->belongsTo(Order::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($coupon) {
            $coupon->used_count = 0;
            $coupon->status = 'active';
            
            // Generate unique code
            do {
                $coupon->code = strtoupper(Str::random(8));
            } while (self::where('code', $coupon->code)->exists());
        });


    }
}
