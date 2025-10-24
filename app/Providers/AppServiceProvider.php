<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Spatie\ImageOptimizer\OptimizerChain;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(OptimizerChain::class, function ($app) {
            return new OptimizerChain();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Blade directive for Rupiah currency formatting
        Blade::directive('rupiah', function ($expression) {
            return "<?php echo 'Rp ' . number_format((float) ($expression), 0, ',', '.'); ?>";
        });
    }
}
