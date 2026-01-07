<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dashboard\Subcategory;
use App\Models\Dashboard\ProductAttatchment;


class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'subcategory_id', 'image', 'description', 'price', 'discount_price', 'status'];


    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function attatchments()
    {
        return $this->hasMany(ProductAttatchment::class);
    }
}
