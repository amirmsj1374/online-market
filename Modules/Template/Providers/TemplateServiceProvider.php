<?php

namespace Modules\Template\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Template\Facades\ContentRepositoryFacade;
use Modules\Template\Facades\LayoutRepositoryFacade;
use Modules\Template\Facades\PageRepositoryFacade;
use Modules\Template\Facades\SectionRepositoryFacade;
use Modules\Template\Interfaces\ContentRepositoryInterface;
use Modules\Template\Interfaces\LayoutRepositoryInterface;
use Modules\Template\Interfaces\PageRepositoryInterface;
use Modules\Template\Interfaces\SectionRepositoryInterface;
use Modules\Template\Repositories\ContentRepository;
use Modules\Template\Repositories\LayoutRepository;
use Modules\Template\Repositories\PageRepository;
use Modules\Template\Repositories\SectionRepository;

class TemplateServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Template';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'template';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->bind(ContentRepositoryInterface::class, ContentRepository::class,
                         SectionRepositoryInterface::class, SectionRepository::class,
                         LayoutRepositoryInterface::class,  LayoutRepository::class,
                         PageRepositoryInterface::class,    PageRepository::class
                        );

        ContentRepositoryFacade::shouldProxyTo(ContentRepository::class);
        SectionRepositoryFacade::shouldProxyTo(SectionRepository::class);
        LayoutRepositoryFacade::shouldProxyTo(LayoutRepository::class);
        PageRepositoryFacade::shouldProxyTo(PageRepository::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
