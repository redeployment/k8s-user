<?php
/**
 * Created by PhpStorm.
 * User: michaelhu
 * Date: 2019/4/19
 * Time: 3:30 PM
 */

namespace App\Services;


class GatewayService extends BaseService
{
    const COMMON_NAME = "gateway";

    public $applicationID = null;
    public $authUser = null;

    function __construct()
    {
        return parent::__construct();

    }


    protected function getServiceInstance(){

        $agentInstance = null;

        //        $keyServiceCategory = 'serviceCatalogs';
        $keyServiceCategory = 'serviceCatalogsTemp';
        $agentService = config($keyServiceCategory.'.'.$this::COMMON_NAME);

        foreach ($agentService as $service) {
            if($service['status']=="passing"){

                $agentInstance = $service;
                break;
            }
        }

        $this->applicationID = $agentInstance['applicationID'];

//        dd($agentInstance);
        return $agentInstance;

    }

    public function getService(){

        return $this;
    }

    public function postToken($event, $jwtToken){


        $requestData = [
            "json" => [
                "credential" => [
//                            'id' => '5b1e79fe-72ec-451c-997b-5b961564a07a'
                    'id' => $this->applicationID
                ],
                "access_token" => $jwtToken['jwtToken'],
                "authenticated_userid" => "{$event->userId}",
                "token_type" => "bearer",
                "expires_in" => $jwtToken['$expires_in']
            ]

        ];

        $this->logLocal('info', 'request to gateway token api:');
        $this->logLocal('info', $requestData);

        $response = $this->request('POST','oauth2_tokens', $requestData);
        $body = $response->getBody();

        $this->logLocal('info', $body);

        return $body;

    }





}



