<?php

declare(strict_types=1);

namespace UserSpotlightPro;

use UserSpotlightPro\REST_API\ApiService;
use UserSpotlightPro\Settings\PluginOptions;


class UserSpotlightPro
{
    public function init()
    {
        $apiService = new ApiService();
        $apiService->init();

        $pluginOptions = new PluginOptions();
        $pluginOptions->init();
    }
}
