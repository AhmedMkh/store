<?php

namespace App\Observers;

use App\Models\Dashboard\Subcategory;

class SubcategoryObserver
{
    /**
     * Handle the Subcategory "created" event.
     */
    public function created(Subcategory $subcategory): void
    {
        //
    }

    /**
     * Handle the Subcategory "updated" event.
     */
    public function updated(Subcategory $subcategory): void
    {
        // التحقق مما إذا كان حقل 'status' قد تغير
        if ($subcategory->isDirty('status')) {
            
            $newStatus = $subcategory->status;

            // هنا نحدث المنتجات مباشرة دفعة واحدة (أسرع في الأداء)
            // إلا إذا كنت تريد عمل Observer للمنتجات أيضاً، وقتها استخدم Loop
            $subcategory->products()->update(['status' => $newStatus]);
        }
    }

    /**
     * Handle the Subcategory "deleted" event.
     */
    public function deleted(Subcategory $subcategory): void
    {
        //
    }

    /**
     * Handle the Subcategory "restored" event.
     */
    public function restored(Subcategory $subcategory): void
    {
        //
    }

    /**
     * Handle the Subcategory "force deleted" event.
     */
    public function forceDeleted(Subcategory $subcategory): void
    {
        //
    }
}
