<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dashboard\User;
use App\Models\Dashboard\Product;

class Comment extends Model
{
    protected $fillable = [
        'content',
        'user_id',
        'product_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
