<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $packageConfig = base_path('../sampaui/config/sampaui.php');

        if (is_file($packageConfig)) {
            $this->mergeConfigFrom($packageConfig, 'sampaui');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $packageViews = base_path('../sampaui/resources/views');
        $packageComponents = $packageViews.'/components';

        if (is_dir($packageViews)) {
            $this->loadViewsFrom($packageViews, 'sampaui');
        }

        if (is_dir($packageComponents)) {
            Blade::anonymousComponentPath(
                $packageComponents,
                config('sampaui.component_prefix', 'sampaui')
            );
        }
    }
}
