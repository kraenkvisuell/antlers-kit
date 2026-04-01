<?php

namespace Kraenkvisuell\Favicons;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Statamic\Console\Commands\Multisite;
use Statamic\Facades\Addon;
use Statamic\Facades\CP\Nav;
use Statamic\Facades\File;
use Statamic\Facades\Image;
use Statamic\Facades\Permission;
use Statamic\Facades\Site;
use Statamic\Facades\User;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Favicons\SiteDefaults\SiteDefaults;

class ServiceProvider extends AddonServiceProvider
{
    use GetsSectionDefaults;

    protected $vite = [
        'input' => [
            'resources/js/cp.js',
            'resources/css/cp.css',
        ],
        'publicDirectory' => 'resources/dist',
        'hotFile' => __DIR__ . '/../resources/dist/hot',
    ];

    protected $config = false;

    public function bootAddon()
    {
        $this
            ->bootAddonConfig()
            ->bootAddonBladeDirective()
            ->bootAddonPermissions()
            ->bootAddonNav()
            ->bootAddonSubscriber()
            ->bootAddonGlidePresets()
            ->bootMultisiteCommandHook();
    }

    protected function bootAddonConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/favicons.php', 'statamic.favicons');

        $this->publishes([
            __DIR__ . '/../config/favicons.php' => config_path('kraenkvisuell/favicons.php'),
        ], 'favicons-config');

        return $this;
    }

    protected function bootAddonBladeDirective()
    {
        Blade::directive('favicons', function ($tag) {
            return '<?php echo \Facades\Statamic\Favicons\Directives\FaviconsDirective::renderTag(' . $tag . ', $__data) ?>';
        });

        return $this;
    }

    protected function bootAddonPermissions()
    {
        Permission::group('favicons', 'Favicons', function () {
            Permission::register('edit favicons site defaults')->label(__('favicons::messages.edit_site_defaults'));
            Permission::register('edit favicons section defaults')->label(__('favicons::messages.edit_section_defaults'));
        });

        return $this;
    }

    protected function bootAddonNav()
    {
        Nav::extend(function ($nav) {
            if ($this->userHasFaviconPermissions()) {
                $nav->tools('Favicons')
                    ->route('favicons.index')
                    ->icon(File::get(__DIR__ . '/../resources/svg/nav-icon.svg'))
                    ->children(function () use ($nav) {
                        return [
                            $nav->item(__('favicons::messages.site_defaults'))->route('favicons.site-defaults.edit')->can('edit favicons site defaults'),
                            $nav->item(__('favicons::messages.section_defaults'))->route('favicons.section-defaults.index')->can('edit favicons section defaults'),
                        ];
                    });
            }
        });

        return $this;
    }

    protected function bootAddonSubscriber()
    {
        Event::subscribe(Subscriber::class);

        return $this;
    }

    protected function bootAddonGlidePresets()
    {
        $presets = collect([
            'favicons_twitter' => config('statamic.favicons.assets.twitter_preset'),
            'favicons_og' => config('statamic.favicons.assets.open_graph_preset'),
        ]);

        // The `twitter_graph_preset` was added later. If it's not set, gracefully
        // fall back so that existing sites generate off the original config.
        if (is_null($presets['favicons_twitter'])) {
            $presets['favicons_twitter'] = $presets['favicons_og'];
        }

        Image::registerCustomManipulationPresets($presets->filter()->all());

        return $this;
    }

    protected function bootMultisiteCommandHook()
    {
        Multisite::hook('after', function () {
            $settings = Addon::get('kraenkvisuell/favicons')->settings();

            $settings->set([
                'site_defaults' => [
                    Site::default()->handle() => $settings->get('site_defaults', []),
                ],
                'site_defaults_sites' => [
                    Site::default()->handle() => null,
                ],
            ]);

            $settings->save();
        });

        return $this;
    }

    private function userHasFaviconPermissions()
    {
        $user = User::current();

        return $user->can('edit favicons site defaults')
            || $user->can('edit favicons section defaults');
    }
}
