<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;

use App\Http\Controllers\API\APIController;

use Illuminate\Support\Facades\Log;

class CacheAPIController extends APIController
{
     const SYSTEM_CACHE_TIMEOUT = 60 * 60;

    // order tag name

    /**
     * @param array $strTags
     * @param null $strKey
     * @return bool
     */
    public static function clearCache(array $arrayTags = [], $strKey = null)
    {
        $bResult = false;

        $cache = null;
        $strTags = json_encode($arrayTags);
        if (count($arrayTags)>0) {

            $cache = \Cache::tags($arrayTags);
            if (is_null($cache)) {
                Log::info("not found cache tag:{$strTags}");
                return $bResult;
            }
            if (!is_null($strKey)) {
                $bResult = $cache->forget($strKey);
//                dd("cache clear tag:{$strTags} with key:{$strKey}");
                Log::info("cache clear tag:{$strTags} with key:{$strKey}");

            } else {
                $bResult = $cache->flush();
//                dd("cache clear tag:{$strTags}");
                Log::info("cache clear tag:{$strTags}");
            }


        } else if ($strKey) {
            $bResult = \Cache::forget($strKey);
//            dd("cache clear tag:{$strKey}");
            Log::info("cache clear key:{$strKey}");
        }

        return $bResult;
    }



}
