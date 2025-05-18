<?php

namespace Innoboxrr\Wirecomments\Providers;


use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Innoboxrr\Wirecomments\Http\Livewire\Comment;
use Innoboxrr\Wirecomments\Http\Livewire\Comments;
use Innoboxrr\Wirecomments\Http\Livewire\Like;
use Innoboxrr\Wirecomments\Policies\CommentPolicy;

class WirecommentsServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(CommentPolicy::class, function ($app) {
            return new CommentPolicy;
        });

        Gate::policy(\Innoboxrr\Wirecomments\Models\Comment::class, CommentPolicy::class);

        $this->app->register(MarkdownServiceProvider::class);
    }


    /**
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            // Publish config file
            $this->publishes([
                __DIR__.'/../../config/wirecomments.php' => config_path('wirecomments.php'),
            ], 'wirecomments-config');

            $this->publishes([
                __DIR__.'/../../tailwind.config.js' => base_path('tailwind.config.js'),
            ], 'wirecomments-tailwind-config');
    
            // Add this line to publish your views
            $this->publishes([
                __DIR__.'/../../resources/views' => resource_path('views/vendor/wirecomments'),
            ], 'wirecomments-views');
        }
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'wirecomments');
        Livewire::component('comments', Comments::class);
        Livewire::component('comment', Comment::class);
        Livewire::component('like', Like::class);
    }
}
