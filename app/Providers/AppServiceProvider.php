<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        \Illuminate\Support\Facades\View::composer(['partials.header', 'layouts.front', 'front.*'], function ($view) {
            try {
                if (Schema::hasTable('menu_items')) {
                    $headerMenuItems = \App\Models\MenuItem::with([
                        'page',
                        'activeChildren.page',
                        'activeChildren.activeChildren.page',
                        'activeChildren.activeChildren.activeChildren.page'
                    ])
                        ->whereNull('parent_id')
                        ->where('is_active', true)
                        ->orderBy('sort_order', 'asc')
                        ->get();
                    $view->with('headerMenuItems', $headerMenuItems);
                } else {
                    $view->with('headerMenuItems', collect());
                }

                if (Schema::hasTable('pages')) {
                    $navPages = \App\Models\Page::where('is_active', true)
                        ->whereNotNull('menu_location')
                        ->where('menu_location', '!=', 'none')
                        ->orderBy('sort_order', 'asc')
                        ->get()
                        ->groupBy('menu_location');
                    $view->with('navPages', $navPages);
                }
            } catch (\Throwable $e) {
                $view->with('headerMenuItems', collect());
                $view->with('navPages', collect());
            }
        });
    }
}
