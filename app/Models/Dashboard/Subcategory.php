<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dashboard\Category;
use App\Models\Dashboard\Product;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Subcategory extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'category_id', 'image', 'status'];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = $model->generateUniqueSlug($model->name);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('name')) {
                $model->slug = $model->generateUniqueSlug($model->name, $model->id);
            }
        });
    }
    public function generateUniqueSlug($name, $exceptId = null)
    {
        $slug = \Illuminate\Support\Str::slug($name, '-');
        $originalSlug = $slug;
        $counter = 1;

        while (self::slugExists($slug, $exceptId)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
    private static function slugExists($slug, $exceptId = null)
    {
        $query = self::where('slug', $slug);

        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        return $query->exists();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the image attribute with full path.
     * المسار الخاص بتخزين الصورة
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value
                ? url('attachments/subcategories/' . $value)
                : url('attachments/default.png'),
        );
    }
}
