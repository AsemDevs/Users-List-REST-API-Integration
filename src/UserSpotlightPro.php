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

    public function registerDeactivationHook(string $file): void
    {
        register_deactivation_hook($file, [$this, 'reset_plugin_options_on_deactivation']);
    }

    public function reset_plugin_options_on_deactivation(): void
    {
        delete_option('user_spotlight_pro_endpoint');
        delete_option('user_spotlight_pro_users_per_page');
    }
}
