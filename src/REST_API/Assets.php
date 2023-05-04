<?php

declare(strict_types=1);

namespace UserSpotlightPro\REST_API;

class Assets
{
    public function init()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueStyles']);
    }

    /**
     * Enqueues the required scripts.
     *
     * @return void
     */
    public function enqueueScripts()
    {
        $plugin_url = plugin_dir_url(dirname(__FILE__));
        wp_enqueue_script(
            'user-details',
            $plugin_url . 'assets/js/user-details.js',
            ['jquery'],
            '1.0.0',
            true
        );
        wp_enqueue_script(
            'bootstrap-js',
            $plugin_url . '../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js',
            ['jquery'],
            '5.0.2',
            true
        );
        wp_enqueue_script(
            'pagination',
            $plugin_url . 'assets/js/pagination.js',
            ['jquery'],
            '1.0.0',
            true
        );

        $custom_endpoint = get_option('user_spotlight_pro_endpoint', '/user-list') ?: '/user-list';
        $users_per_page = get_option('user_spotlight_pro_items_per_page', '5') ?: '5';

        wp_localize_script('pagination', 'UserSpotlightPro', [
            'customEndpoint' => $custom_endpoint,
            'usersPerPage' => $users_per_page,
        ]);
    }


    /**
     * Enqueues the required styles.
     *
     * @return void
     */
    public function enqueueStyles()
    {
        $plugin_url = plugin_dir_url(dirname(__FILE__));
        wp_enqueue_style(
            'bootstrap-css',
            $plugin_url . '../vendor/twbs/bootstrap/dist/css/bootstrap.min.css',
            [],
            '5.0.2'
        );
        wp_enqueue_style(
            'user-spotlight-pro-styles',
            $plugin_url . 'assets/css/styles.css',
            [],
            '1.0.0'
        );
    }
}
