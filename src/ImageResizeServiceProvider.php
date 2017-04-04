<?php
/**
 * Created by PhpStorm.
 * User: selamet
 * Date: 4/4/17
 * Time: 2:18 PM
 */

namespace Ariwira\ImageResize;
use Illuminate\Support\ServiceProvider;

class ImageResizeServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        // merge default config
        $this->mergeConfigFrom(
            __DIR__.'/../config/resize.php',
            'image'
        );

//        // set configuration
//        $app->configure('image');
//
//        // create image
//        $app->singleton('image',function ($app) {
//            return new Image($app['config']->get('image'));
//        });

        $app->alias('image', 'Ariwira\ImageResize\Image');
    }
}