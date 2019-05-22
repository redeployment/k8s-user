<?php
/**
 * Created by PhpStorm.
 * User: michaelhu
 * Date: 2019/4/19
 * Time: 3:30 PM
 */

namespace App\Services;

use App\Logger\Logger;
use GuzzleHttp\Client;

class BaseService extends Client
{
    use Logger;
    const COMMON_NAME = "service_base";

    function __construct()
    {
        // init the default value
        $agentService = $this->getServiceInstance();

        if(!is_null($agentService)){
            // parent will construction automatically
            $config['base_uri'] = $agentService['address'].':'.$agentService['port'];
            return parent::__construct($config);
        }else{

            $this->logLocal("emergency", $this::COMMON_NAME." Service has not available instance");

            return null;
        }


    }


    protected function getServiceInstance(){

        $agentInstance = null;

        //        $keyServiceCategory = 'serviceCatalogs';
        $keyServiceCategory = 'serviceCatalogsTemp';

        $agentService = config("{$keyServiceCategory}.".$this::COMMON_NAME);

        foreach ($agentService as $service) {
            if($service['status']=="passing"){

                $agentInstance = $service;
                break;
            }
        }

        return $agentInstance;

    }


}



