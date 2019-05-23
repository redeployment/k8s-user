<?php
/**
 * Created by PhpStorm.
 * User: michaelhu
 * Date: 2019/4/19
 * Time: 3:30 PM
 */

namespace App\Services;


class ProductService extends BaseService
{
    const COMMON_NAME = "service_product";

    public $authUser = null;

    function __construct()
    {
        return parent::__construct();

    }


    public function getProduct($productID){
//        $this->request($method)

    }


}



