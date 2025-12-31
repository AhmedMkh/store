<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';


    public function getImageAttribute($value)
    {

        // التحقق من وجود قيمة للصورة
        if ($value) {
            return url('attachments/categories/' . $value);
        }

        // إذا لم تكن هناك صورة، يمكن إرجاع صورة افتراضية
        return url('attachments/default.png');
    }
}
