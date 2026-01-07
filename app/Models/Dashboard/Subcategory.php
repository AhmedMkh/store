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

    public function getImageAttribute($value)
    {

        // التحقق من وجود قيمة للصورة
        if ($value) {
            return url('attachments/subcategories/' . $value);
        }

        // إذا لم تكن هناك صورة، يمكن إرجاع صورة افتراضية
        return url('attachments/default.png');
    }
}
