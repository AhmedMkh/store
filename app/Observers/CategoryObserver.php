<?php

namespace App\Observers;

use App\Models\Dashboard\Category;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        // التحقق مما إذا كان حقل 'status' قد تغير فعلاً
        if ($category->isDirty('status')) {
            
            $newStatus = $category->status;

            // نقوم بعمل Loop وتحديث كل قسم فرعي على حدة
            // السبب: لكي يعمل الـ SubcategoryObserver الخاص بالمنتجات (الخطوة التالية)
            foreach ($category->subcategories as $subcategory) {
                $subcategory->update(['status' => $newStatus]);
            }
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
