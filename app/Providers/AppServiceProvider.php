<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\SpecialPage;
use App\Models\Tag;
use App\Observers\ArticleObserver;
use Input;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        \View::composer('*', function ($view) {
            $categories = \Cache::remember('poular_categorys',1, function () {
                return $categories = Category::withCount('articles')
                    ->orderBy('articles_count','desc')
                    ->limit(10)
                    ->get();
            });
            $view->with('popular_categories', $categories);
        });

        \View::composer('*', function ($view) {
            $tags = \Cache::remember('popular_tags',1, function () {
                return $tags = Tag::withCount('discussions')
                    ->orderBy('discussions_count','desc')
                    ->limit(10)
                    ->get();
            });
            $view->with('popular_tags', $tags);
        });

        \View::composer('*', function ($view) {

            $specialPages = \Cache::remember('special_pages',1, function () {
                return $pages = SpecialPage::where('show_nav',1)
                    ->limit(10)
                    ->get();
            });

            $view->with('special_pages', $specialPages);
        });


        Carbon::setLocale('zh');
        Schema::defaultStringLength(191);

//        Article::observe(ArticleObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
