<?php

declare(strict_types=1);

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
