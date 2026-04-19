<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\RepositoryServiceProvider::class, // This will add auto, if created by: php artisan make:provider RepositoryServiceProvider
    Spatie\Permission\PermissionServiceProvider::class, // This added manually
];
