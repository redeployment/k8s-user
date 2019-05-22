<?php
/**
 * Created by PhpStorm.
 * User: michaelhu
 * Date: 2019/4/22
 * Time: 2:00 PM
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;



class ProductService extends Facade
{
    public static function getFacadeAccessor(){

        return \App\Services\ProductService::class;
    }

}
