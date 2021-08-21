<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // date format status
        Blade::directive('datetime', function ($expression) {
            return "<?php echo date('d/m/Y  H:i A', strtotime($expression)); ?>";
        });
        // Use boostrap pagination
        Paginator::useBootstrap();
        // If database not connected
        if (env('SYSTEM_INSTALLED') != 0)
        // Shere data with frontend
        {
            View::composer('*', 'App\Http\View\Composers\DataComposer');
        }
    }
}
