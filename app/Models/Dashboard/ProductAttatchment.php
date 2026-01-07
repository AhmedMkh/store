<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dashboard\Product;
class ProductAttatchment extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'type', 'url'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
