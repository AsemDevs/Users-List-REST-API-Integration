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
        $this->addUserListEndpoint();
        $this->addUserDetailsEndpoint();
    }

    /**
     * Adds user list endpoint and rewrite tag.
     *
     * @return void
     */
    private function addUserListEndpoint()
    {
        add_rewrite_rule('^user-list/?$', 'index.php?user_list_template=1', 'top');
        add_rewrite_tag('%user_list_template%', '([^&]+)');
    }

    /**
     * Adds user details endpoint and rewrite tags.
     *
     * @return void
     */
    private function addUserDetailsEndpoint()
    {
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
        $transient_key = 'user_spotlight_pro_users';
        $users = get_transient($transient_key);

        if ($users === false) {
            $response = wp_remote_get('https://jsonplaceholder.typicode.com/users');

            if (is_wp_error($response)) {
                return [];
            }

            $users = json_decode(wp_remote_retrieve_body($response), true);
            set_transient($transient_key, $users, HOUR_IN_SECONDS);
        }

        return $users;
    }


    /**
     * Fetches user details from the external API.
     *
     * @param  int $user_id The ID of the user to fetch details for.
     * @return array An array of user details.
     */
    public function fetchUserDetails($user_id)
    {
        $transient_key = 'user_spotlight_pro_user_details_' . $user_id;
        $user_details = get_transient($transient_key);

        if ($user_details === false) {
            $api_url = 'https://jsonplaceholder.typicode.com/users/' . $user_id;
            $response = wp_remote_get($api_url);

            if (is_wp_error($response)) {
                return [];
            }

            $user_details = json_decode(wp_remote_retrieve_body($response), true);
            set_transient($transient_key, $user_details, HOUR_IN_SECONDS);
        }

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
            $this->renderUserList();
        } elseif (
            isset($wp_query->query_vars['user_details_template'])
            && $wp_query->query_vars['user_details_template'] == 1
        ) {
            $this->renderUserDetails();
        }
    }

    /**
     * Renders the user list template.
     *
     * @return void
     */
    public function renderUserList()
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
    public function renderUserDetails()
    {
        global $wp_query;
        $user_id = $wp_query->query_vars['user_id'];

        // Fetch the user details from the API
        $user_details = $this->fetchUserDetails($user_id);

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
