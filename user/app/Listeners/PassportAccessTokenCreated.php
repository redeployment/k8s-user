<?php

namespace App\Listeners;


use App\Http\Controllers\API\APIController;
use App\Logger\Logger;
use Laravel\Passport\Events\AccessTokenCreated;

use App\Http\Controllers\API\APIResponse;


use App\Facades\GatewayService;
use Carbon\Carbon;

use Laravel\Passport\Passport;
use League\OAuth2\Server\CryptKey;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Signer\Key;


class PassportAccessTokenCreated
{
    use APIResponse, Logger;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AccessTokenCreated $event
     * @return void
     */
    public function handle(AccessTokenCreated $event)
    {
        // sync this token to gateway

//        dump($event);
        $params = \Request::all();
        if (array_key_exists('grant_type', $params)) {
            $grantType = $params['grant_type'];
        } else {
            $grantType = null;
        }

        if ($grantType == 'password') {

            $token = Passport::token()->find($event->tokenId);

            $jwtToken = $this->createJWTToken($event, $token);
//            dd($jwtToken);
            if($jwtToken['jwtToken']){
//                dd($jwtToken);
                $bResult = GatewayService::postToken($event, $jwtToken);

            }else{


            }


        }
    }

    function createJWTToken(AccessTokenCreated $event, $token){

        $strResult = null;


//        dump($token);
        if($token){
            $key = 'file://'.Passport::keyPath('oauth-private.key');
            $privateKey = new CryptKey($key, null, false);
//            dump($privateKey);

            if($privateKey){

                // stimulate : League\OAuth2\Server\Entities\Traits\AccessTokenTrait
                // function : convertToJWT()
                $now = Carbon::createFromFormat(APIController::DATE_TIME_FORMAT,$token->created_at)->getTimestamp();
                $expires = Carbon::createFromFormat(APIController::DATE_TIME_FORMAT,$token->expires_at)->getTimestamp();
                $expires_in = $expires - $now;
                $jwtToken = (new Builder())
                    ->setAudience($event->clientId)
                    ->setId($event->tokenId, true)
                    ->setIssuedAt($now)
                    ->setNotBefore($now)
                    ->setExpiration($expires)
                    ->setSubject($event->userId)
                    ->set('scopes', $token->scopes)
                    ->sign(new Sha256(), new Key($privateKey->getKeyPath(), $privateKey->getPassPhrase()))
                    ->getToken();

//                dump($jwtToken);
                $strResult['jwtToken'] = $jwtToken->__toString();
                $strResult['$expires_in'] = $expires_in;
//                dump($strResult);
                return $strResult;

            }

        }

        return $strResult;

    }


}
