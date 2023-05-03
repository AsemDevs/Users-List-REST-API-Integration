<?php

/**
 * ApiService class for handling REST API related functionality.
 *
 * @category Class
 * @package  UserSpotlightPro\REST_API
 * @author   Asem Abdou <asemabdou1@gmail.com>
 * @license  MIT License <https://opensource.org/licenses/MIT>
 * @link     https://github.com/AsemDevs/Users-List-REST-API-Integration
 */

declare(strict_types=1);

namespace UserSpotlightPro\REST_API;

class ApiService
{
    public function init()
    {
        $userApi = new UserApi();
        $assets = new Assets();

        $userApi->init();
        $assets->init();
    }
}
