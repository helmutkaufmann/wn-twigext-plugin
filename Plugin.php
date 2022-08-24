<?php namespace Mercator\TwigExt;

/*
The MIT License (MIT)

Copyright (C) 2021 Helmut Kaufmann, https://mercator.li, software@mercator.li
Copyright (C) 2016 Vojta Svoboda

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

*/

use App;
use Backend;
use Exception;
use Event;
use Carbon\Carbon;
use System\Classes\PluginBase;
use Cms\Classes\Theme;
use Mercator\TwigExt\Classes\TimeDiffTranslator;

/**
 * Twig Extensions Plugin.
 *
 * @see http://twig.sensiolabs.org/doc/extensions/index.html#extensions-install
 */
class Plugin extends PluginBase {

  /**
   * Registers any back-end permissions used by this plugin.
   *
   * @return array
   */
   public function registerPermissions() {
       return ['mercator.twigextensions.configuration' => ['tab' => 'Twig Extensions', 'label' => 'Manage configuration', ],

     ];
   }

    /**
     * @var boolean Determine if this plugin should have elevated privileges.
     */
    public $elevated = true;

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails() {
        return ['name' => 'Twig Extensions', 'description' => "Extensive Twig extension library for Winter CMS, providing Laravel native functionality, such as caching, sessions, cryptography, access to directories, files/storage, and many more.",
        'author' => 'Helmut Kaufmann', 'icon' => 'icon-plus', 'homepage' => 'https://github.com/helmutkaufmann/wn-twigext-plugin', 'permissions' => ['mercator.twigextensions.configuration'],
        'category' => 'mercator', 'icon' => 'icon-cog',];
    }

    public function boot() {

	      $twig = App::make('twig.environment');

        $this
            ->app->singleton('time_diff_translator', function ($app) {
            $loader = $app->make('translation.loader');
            $locale = $app
                ->config
                ->get('app.locale');
            $translator = $app->make(TimeDiffTranslator::class , [$loader, $locale]);
            $translator->setFallback($app
                ->config
                ->get('app.fallback_locale'));

            return $translator;
        });
    }

    /**
     * Add Twig extensions.
     *
     * @return array
     */
    public function registerMarkupTags() {

        $filters = [];
        $functions = [];

        // init Twig
        $twig = App::make('twig.environment');

        // Add String Loader functions
        $functions += $this->getStringLoaderFunctions($twig);

        // Add global filters and functions
        foreach (glob(__DIR__ . "/twig/filters/_*.php") as $file) {
            require_once $file;
        }

        foreach (glob(__DIR__ . "/twig/functions/_*.php") as $file) {
            require_once $file;
        }

        // Add theme-specific filters and function
        $theme = Theme::getActiveTheme();
        $theme_path = $theme->getPath();

        foreach (glob($theme_path . "/twig/filters/_*.php") as $file) {
            require_once $file;
        }

        foreach (glob($theme_path . "/twig/functions/_*.php") as $file) {
            require_once $file;
        }

        // Return all filters and functions
        return ['filters' => $filters, 'functions' => $functions, ];
    }

    /**
     * Returns String Loader functions.
     *
     * @param \Twig_Environment $twig
     *
     * @return array
     */
    private function getStringLoaderFunctions($twig) {
    $stringLoader = new \Twig\Extension\StringLoaderExtension(); // LARA
        $stringLoaderFunc = $stringLoader->getFunctions();

        return ['template_from_string' => function ($template) use ($twig, $stringLoaderFunc) {
            $callable = $stringLoaderFunc[0]->getCallable();
            return $callable($twig, $template);
        }
        ];}

    /**
     * Returns Text filters.
     *
     * @param \Twig_Environment $twig
     *
     * @return array
     */
      private function getTextFilters($twig) {
        $textExtension = new Twig_Extensions_Extension_Text();
        $textFilters = $textExtension->getFilters();

        return ['truncate' => function ($value, $length = 30, $preserve = false, $separator = '...') use ($twig, $textFilters) {
            $callable = $textFilters[0]->getCallable();
            return $callable($twig, $value, $length, $preserve, $separator);
        }
        , 'wordwrap' => function ($value, $length = 80, $separator = "\n", $preserve = false) use ($twig, $textFilters) {
            $callable = $textFilters[1]->getCallable();
            return $callable($twig, $value, $length, $separator, $preserve);
        }
        ];
    }

    public function registerSettings() {

        return ['settings' => ['label' => 'Twig Extensions', 'description' => 'Twig extension library providing Laravel native functionality, such as caching, sessions, cryptography, access to directories, files/storage, and many more.',
        'category' => 'mercator', 'icon' => 'icon-cog', 'class' => 'Mercator\TwigExt\Models\Settings', 'order' => 500, 'keywords' => 'Helmut Kaufmann Twig Extensions Mercator (for Winter 1.2)', 'permissions' => ['mercator.twigext.twigextperm']]];

    }
}
