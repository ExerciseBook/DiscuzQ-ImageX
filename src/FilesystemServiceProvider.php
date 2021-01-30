<?php

namespace ExerciseBook\DiscuzQCloudinary;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Filesystem\FilesystemServiceProvider as ServiceProvider;
use Illuminate\Support\Arr;
use League\Flysystem\Filesystem;

class FilesystemServiceProvider extends ServiceProvider
{
    /**
     * @param string $string
     * @param $default
     * @return mixed
     */
    public function get_config($app, string $string, $default)
    {
        return (Arr::get(app()['discuz.config'], $string, $default));
    }

    /**
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function boot()
    {
        $this->app->make('filesystem')->extend('imagex', function ($app, $config) {
            $filesystem_config = $this->get_config($app,'filesystems', null);

            if ($filesystem_config === null) {
                throw new Exception("No filesystem configuration declared.");
            }

            $cloudinary_config = Arr::get($filesystem_config, 'disks.imagex', null);

            if ($cloudinary_config === null) {
                throw new Exception("No ImageX configuration Found.");
            }

            $ImageXAdapter = new ImageXAdapter($cloudinary_config);

            return new Filesystem($ImageXAdapter);
        });
    }
}
