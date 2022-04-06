<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Post;
use App\Models\Tag;
use App\Models\PostTag;

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
        view()->composer('*',function($view){

        $posts_model = new Post();
        $posts = $posts_model->getPosts();

        $tags_model = new Tag();
        $tags = $tags_model->getTags();
        $selectedTag = $tags_model->getSelectedTag();

        $view->with('posts',$posts)->with('tags',$tags)->with('selectedTag',$selectedTag);

        });

        if (App::environment(['production'])) {
            URL::forceScheme('https');
        }
    }
}
