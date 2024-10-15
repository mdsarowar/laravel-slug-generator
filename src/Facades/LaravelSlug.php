<?php
namespace Sarowar\LaravelSlugGenerator\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * @see \Sarowar\LaravelSlugGenerator\laravelSlug
 */
class LaravelSlug extends Facade
{

    protected static function getFacadeAccessor()
    {
      return 'laravel-slug-generator';
    }
}
