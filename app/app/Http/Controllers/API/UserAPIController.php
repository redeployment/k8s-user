<?php

namespace App\Http\Controllers\API;

use App\Facades\GatewayService;

use Illuminate\Http\Request;


use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\User;

class UserAPIController extends APIController
{


    function __construct(Request $request)
    {

        // init the default value
        // parent will construction automatically
        parent::__construct($request);

    }


    /**
     * API get Service.
     *
     * @param  Request $request
     * @return string json
     */
    public function apiGetService(Request $request)
    {
//        dd($request);

        $data = $this->m_requestData;

        $this->pushDataWithKeyValue("client says:", $data);
        $this->pushDataWithKeyValue("Service says", "I am User Service");

        return $this->getJSONResponse();

    }

    /**
     * API get User.
     *
     * @param  Request $request
     * @return string json
     */
    public function apiGetUsers(Request $request)
    {
        $users = User::all();

        $this->setData($users);

        return $this->getJSONResponse();
    }

    /**
     * API get User.
     *
     * @param  Request $request
     * @return string json
     */
    public function apiGetUser(Request $request){

        $userID = $this->m_requestData['user_id'];
        $data = [];

        $cacheTag = User::COMMON_NAME;
        $cacheKey = "user_id.{$userID}";
        $user = \Cache::tags($cacheTag)->remember($cacheKey, CacheAPIController::SYSTEM_CACHE_TIMEOUT, function () use ($userID) {

            $user = User::find($userID);

            $this->logLocal('info', "api get user id:{$userID}");
            $this->logLocal('info', $user);

            return $user;
        });

        $this->setData($user);

        return $this->getJSONResponse();

    }

    /**
     * API call product vervice.
     *
     * @param  Request $request
     * @return string json
     */
    public function apiCallProduct(Request $request)
    {

        $data = array(
            Carbon::now()->format('h:i:s').'-'.rand(1, 9)." User Service says: " => 'Hello master, this is user service',
            Carbon::now()->format('h:i:s').'-'.rand(1, 9)." User Service says: " => 'I will call Product Service together',

        );


        $clientUserConsulAgent = new Client([
            'base_uri' => 'http://192.168.50.172:8500'
        ]);

//        $response = $clientUserConsulAgent->request('GET','v1/catalog/service/nginx_product');
//        $body = $response->getBody();
//
//        $result = json_decode($body, true);

//        dd($result);
        $productService = config('serviceCatalogs.nginx_product');
//        dd($productService);


        if($productService[0]['address'] && $productService[0]['port']){
            // ready to query user
            $clientProductService = new Client([
                'base_uri' => "http://{$productService[0]['address']}:{$productService[0]['port']}"
            ]);
//            dump($result[0]);

            $response = $clientProductService->request('GET','api/v1/product/');
            $body = $response->getBody();

            $resultProduct = json_decode($body, true);
//            dd($resultProduct);

            if($resultProduct['meta']['return_code'] == API_RETURN_CODE_INIT
                && $resultProduct['meta']['result_code'] == API_RESULT_CODE_INIT){
                $data[Carbon::now()->format('h:i:s').'-'.rand(1, 9)." Product Service says: "] = $resultProduct['data']['answer'];

            }else{
                $data[Carbon::now()->format('h:i:s').'-'.rand(1, 9)." User Service says: "] = 'It seems like Product Service API has some issues :(';

            }

        }else{

            $data[Carbon::now()->format('h:i:s').'-'.rand(1, 9)." User Service says: "] = 'It seems like Product Service is not available :(';

        }


        $this->setData($data);

        return $this->getJSONResponse();

    }


}
