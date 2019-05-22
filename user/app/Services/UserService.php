<?php
/**
 * Created by PhpStorm.
 * User: michaelhu
 * Date: 2019/4/19
 * Time: 3:30 PM
 */

namespace App\Services;


use App\Http\Controllers\API\CacheAPIController;

class InventoryService extends BaseService
{
    const COMMON_NAME = "service_user";

    public $authUser = null;

    function __construct()
    {
        return parent::__construct();

    }


    public function getUser($userID){
//        $this->request($method)



    }


}



