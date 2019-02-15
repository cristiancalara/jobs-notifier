<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;

class APIController extends Controller
{
    /**
     * @return \App\User|null
     */
    protected function user()
    {
        return auth()->guard('api')->user();
    }

    /**
     * @return APIResponse
     */
    public function response()
    {
        return new APIResponse();
    }
}