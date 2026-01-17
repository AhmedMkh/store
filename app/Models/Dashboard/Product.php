<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dashboard\Subcategory;
    use App\Models\Dashboard\ProductAttachment;
use App\Models\Dashboard\Comment;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;


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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    /**
     * Get the image attribute with full path.
     * المسار الخاص بتخزين الصورة
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value
                ? url('attachments/products/' . $value)
                : url('attachments/default.png'),
        );
    }
}
