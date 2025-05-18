<?php

namespace Innoboxrr\Wirecomments\Providers;


use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Illuminate\Support\Str;
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

        $this->mergeConfigFrom(__DIR__ . '/../../config/wirecomments.php', 'wirecomments');
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
        $this->registerLivewireComponents();
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'wirecomments');
    }

    protected function registerLivewireComponents()
    {
        $livewirePath = __DIR__.'/../Http/Livewire';
        $namespace = 'Innoboxrr\\Wirecomments\\Http\\Livewire';

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($livewirePath)
        );

        $components = [];

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                // Generar la clase a partir de la ruta
                $class = $namespace . '\\' . str_replace(
                    ['/', '\\', '.php'],
                    ['\\', '\\', ''],
                    substr($file->getPathname(), strlen($livewirePath) + 1)
                );

                if (class_exists($class) && is_subclass_of($class, \Livewire\Component::class)) {
                    // Convertir la ruta relativa de la clase a kebab-case
                    $relativePath = str_replace(
                        '\\',
                        '/',
                        substr($class, strlen($namespace) + 1)
                    );

                    // Convertir cada segmento del path a kebab-case
                    $kebabPath = collect(explode('/', $relativePath))
                        ->map(fn($segment) => Str::kebab($segment))
                        ->implode('.');

                    $viewName = 'wirecomments::livewire.' . $kebabPath;

                    // Log para depurar el registro
                    // Log::info("Registrando componente: $viewName => $class");

                    // Registrar el componente en Livewire
                    Livewire::component($viewName, $class);

                    // Agregar el componente al array
                    $components[$viewName] = $class;
                }
            }
        }
    }
}
