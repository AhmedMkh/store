<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// التحقق من وضع الصيانة (Maintenance Mode)
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// تسجيل الـ Autoloader الخاص بـ Composer
require __DIR__.'/../vendor/autoload.php';

// تشغيل التطبيق ومعالجة الطلب
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
