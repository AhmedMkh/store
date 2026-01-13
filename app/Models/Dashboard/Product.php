<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dashboard\Subcategory;
use App\Models\Dashboard\ProductAttatchment;
use Illuminate\Support\Str;


class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'subcategory_id', 'image', 'description', 'price', 'discount_price', 'status'];

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

        static::deleting(function ($model) {
            // Delete related attachments
        $model->attatchments()->delete();
        });
    }

    public function generateUniqueSlug($name, $exceptId = null)
    {
        $slug = Str::slug($name, '-');
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


    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function attachments()
    {
        return $this->hasMany(ProductAttachment::class);
    }

    public function getImageAttribute($value)
    {

        // التحقق من وجود قيمة للصورة
        if ($value) {
            return url('attachments/products/' . $value);
        }

        // إذا لم تكن هناك صورة، يمكن إرجاع صورة افتراضية
        return url('attachments/default.png');
    }
}
