<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dashboard\Coupon;
use App\Models\Dashboard\User;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'coupon_id',
        'status',
    ];

    public function coupon()
    {
        return $this->hasOne(Coupon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
