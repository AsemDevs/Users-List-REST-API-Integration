<?php

namespace UserSpotlightPro;

use UserSpotlightPro\REST_API\ApiService;

class UserSpotlightPro
{
    public function init()
    {
        $apiService = new ApiService();
        $apiService->init();
    }
    
}
