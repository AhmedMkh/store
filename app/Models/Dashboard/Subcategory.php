<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dashboard\Category;
use App\Models\Dashboard\Product;
class Subcategory extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'category_id', 'image', 'status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
