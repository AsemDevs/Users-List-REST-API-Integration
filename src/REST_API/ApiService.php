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
    /**
     * Initializes the ApiService by setting up the required hooks.
     *
     * @return void
     */
    public function init()
    {
        // TODO: Consider separating the different hooks into different methods for better code organization

        add_action('init', [$this, 'addEndpoint']);
        add_action('template_redirect', [$this, 'renderTemplate']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
    }

    /**
     * Enqueues the required scripts.
     *
     * @return void
     */
    public function enqueueScripts()
    {
        wp_enqueue_script(
            'user-details',
            plugin_dir_url(__FILE__) . '../assets/js/user-details.js',
            ['jquery'],
            '1.0.0',
            true
        );
    }

    /**
     * Adds custom rewrite rules and tags for the endpoints.
     *
     * @return void
     */
    public function addEndpoint()
    {
        add_rewrite_rule('^user-list/?$', 'index.php?user_list_template=1', 'top');
        add_rewrite_tag('%user_list_template%', '([^&]+)');

        add_rewrite_rule(
            '^user-details/([^/]+)/?$',
            'index.php?user_details_template=1&user_id=$matches[1]',
            'top'
        );
        add_rewrite_tag('%user_details_template%', '([^&]+)');
        add_rewrite_tag('%user_id%', '([^&]+)');
        add_rewrite_tag('%json%', '([^&]+)');
    }

    /**
     * Fetches users from the external API.
     *
     * @return array An array of user data.
     */
    public function fetchUsers()
    {
        // TODO: Add error handling to provide more specific error messages
        // and handle different types of HTTP errors
        $response = wp_remote_get('https://jsonplaceholder.typicode.com/users');

        if (is_wp_error($response)) {
            return []; // To return an empty array in case of an error
        }

        $users = json_decode(wp_remote_retrieve_body($response), true);

        return $users;
    }

    /**
     * Fetches user details from the external API.
     *
     * @param  int $user_id The ID of the user to fetch details for.
     * @return array An array of user details.
     */
    private function _fetchUserDetails($user_id)
    {
        // TODO: Add error handling to provide more specific error messages
        // and handle different types of HTTP errors
        $api_url = 'https://jsonplaceholder.typicode.com/users/' . $user_id;
        $response = wp_remote_get($api_url);

        if (is_wp_error($response)) {
            return [];
        }

        $user_details = json_decode(wp_remote_retrieve_body($response), true);

        return $user_details;
    }

    /**
     * Renders the appropriate template based on the query variables.
     *
     * @return void
     */
    public function renderTemplate()
    {
        global $wp_query;

        if (
            isset($wp_query->query_vars['user_list_template'])
            && $wp_query->query_vars['user_list_template'] == 1
        ) {
            $this->_renderUserList();
        } elseif (
            isset($wp_query->query_vars['user_details_template'])
            && $wp_query->query_vars['user_details_template'] == 1
        ) {
            $this->_renderUserDetails();
        }
    }

    /**
     * Renders the user list template.
     *
     * @return void
     */
    private function _renderUserList()
    {
        // Fetch the user data from the API
        $user_data = $this->fetchUsers();

        include plugin_dir_path(__FILE__) . '../templates/user-table-template.php';
        exit;
    }

    /**
     * Renders the user details template.
     *
     * @return void
     */
    private function _renderUserDetails()
    {
        global $wp_query;
        $user_id = $wp_query->query_vars['user_id'];

        // Fetch the user details from the API
        $user_details = $this->_fetchUserDetails($user_id);

        // Check if the 'json' query variable is set and render the JSON output
        if (isset($wp_query->query_vars['json']) && $wp_query->query_vars['json'] == 1) {
            header('Content-Type: application/json');
            echo json_encode($user_details);
        } else {
            // Otherwise, render the HTML template
            include plugin_dir_path(__FILE__) . '../templates/user-details-template.php';
        }
        exit;
    }
}
