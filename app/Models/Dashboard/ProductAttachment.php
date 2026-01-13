<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dashboard\Product;
class ProductAttachment extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'type', 'url'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($attachment) {
            // Delete the file from storage
            if ($attachment->url && \Storage::exists($attachment->url)) {
                \Storage::delete($attachment->url);
            }
        });
    }

    public function getImageAttribute($value)
    {

        // التحقق من وجود قيمة للصورة
        if ($value) {
            return url('attachments/product_attachments/' . $value);
        }

        // إذا لم تكن هناك صورة، يمكن إرجاع صورة افتراضية
        return url('attachments/default.png');
    }
}
