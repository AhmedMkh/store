<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dashboard\Product;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProductAttachment extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'type', 'attachment'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($attachment) {
            // Delete image file from storage if it's an image type
            if ($attachment->type === 'image' && $attachment->attachment && file_exists(public_path('attachments/product_attachments/' . $attachment->attachment))) {
                unlink(public_path('attachments/product_attachments/' . $attachment->attachment));
            }
        });
    }

    /**
     * Get the image attribute with full path for images.
     * استرجاع المسار الكامل للصورة
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->type === 'image' && $this->attributes['attachment'] ?? null
                ? url('attachments/product_attachments/' . $this->attributes['attachment'])
                : url('attachments/default.png'),
        );
    }

    /**
     * Get the video attribute - returns video URL.
     * استرجاع رابط الفيديو
     */
    protected function video(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->type === 'video' ? ($this->attributes['attachment'] ?? '') : '',
        );
    }
}
