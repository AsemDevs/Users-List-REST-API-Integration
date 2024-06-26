<?php

declare(strict_types=1);

namespace UserSpotlightPro\REST_API;

/**
 * Class Assets
 * Handles the enqueuing of required scripts and styles for the plugin.
 */
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
        $plugin_url = plugin_dir_url(__DIR__);
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

        wp_localize_script(
            'user-details',
            'ajax_object',
            ['ajaxurl' => admin_url('admin-ajax.php')]
        );
    }

    /**
     * Enqueues the required styles.
     *
     * @return void
     */
    public function enqueueStyles()
    {
        $plugin_url = plugin_dir_url(__DIR__);
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
