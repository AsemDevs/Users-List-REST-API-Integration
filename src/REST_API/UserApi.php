<?php

declare(strict_types=1);

namespace UserSpotlightPro\REST_API;

/**
 * Class UserApi
 * Handles the interaction with the REST API to fetch user data and manage custom endpoints.
 */

class UserApi
{
    public function init()
    {
        add_action('init', [$this, 'addEndpoint']);
        add_action('template_redirect', [$this, 'renderTemplate']);
        add_action('rest_api_init', [$this, 'registerRestRoute']);  // Add this line

    }

    /**
     * Adds custom rewrite rules and tags for the endpoints.
     *
     * @return void
     */

    public function addEndpoint()
    {
        $this->addUserListEndpoint();
    }

    /**
     * Adds user list endpoint and rewrite tag.
     *
     * @return void
     */
    private function addUserListEndpoint()
    {
        $custom_endpoint = get_option('user_spotlight_pro_endpoint', '/user-list');
        $custom_endpoint = trim($custom_endpoint, '/');
        $custom_endpoint_regex = "^{$custom_endpoint}$";

        add_rewrite_rule($custom_endpoint_regex, 'index.php?user_list_template=1', 'top');
        add_rewrite_tag('%user_list_template%', '([^&]+)');
    }

        /**
     * Registers a custom REST route for fetching user details.
     *
     * @return void
     */
    public function registerRestRoute()
    {
        register_rest_route('user_spotlight_pro/v1', '/user/(?P<id>\d+)', [
            'methods'  => 'GET',
            'callback' => [$this, 'fetchUserDetailsEndpoint'],
        ]);
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
    
            // Store the user ID in a separate option
            $userIds = get_option('user_spotlight_pro_user_ids', []);
            if (is_array($userIds)) {
                $userIds[] = $user_id;
                update_option('user_spotlight_pro_user_ids', $userIds);
            } else {
                // Handle error or do something else when $userIds is not an array
            }
        }
    
        return $user_details;
    }
    
    /**
     * Fetches user details and returns it as a REST response.
     *
     * @param WP_REST_Request $request The request.
     * @return WP_REST_Response The response.
     */
    public function fetchUserDetailsEndpoint(\WP_REST_Request $request)
    {
        $user_id = $request->get_param('id');
        $user_details = $this->fetchUserDetails($user_id);

        if (empty($user_details)) {
            return new \WP_Error('no_user', 'Invalid user ID.', ['status' => 404]);
        }

        $response = new \WP_REST_Response($user_details);
        $response->set_status(200);

        return $response;
    }
    
   /**
     * Clear the transient data for users and user details.
     *
     * The function deletes the transient that stores the users fetched from the API
     */
    public function clear_transients() {
        // Clear the users transient
        delete_transient('user_spotlight_pro_users');
    
        // Clear the user details transients
        $users = $this->fetchUsers();
    
        foreach ($users as $user) {
            $user_id = $user['id'];
            delete_transient('user_spotlight_pro_user_details_' . $user_id);
        }
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
     * Get a paginated list of users.
     *
     * @param int $page The current page number.
     * @param int $users_per_page The number of users to display per page.
     * @return array The user array for the specified page.
     */
    public function getUsersByPage($page, $users_per_page)
    {
        $users = $this->fetchUsers();
        $start = ($page - 1) * $users_per_page;
        $end = min($start + $users_per_page, count($users));

        return array_slice($users, $start, $end - $start);
    }

    /**
     * Renders the user list template.
     *
     * @return void
     */
    public function renderUserList()
    {
        global $wp_query;

        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $users_per_page = intval(get_option('user_spotlight_pro_users_per_page', '5'));

        $user_data = $this->getUsersByPage($current_page, $users_per_page);

        $total_users = count($this->fetchUsers());
        $total_pages = ceil($total_users / $users_per_page);

        $template_vars = compact(
            'user_data',
            'current_page',
            'total_users',
            'total_pages',
            'users_per_page'
        );
        extract($template_vars);
        include plugin_dir_path(__DIR__) . '/templates/user-table-template.php';
        exit;
    }

    /**
     * Renders the user details template.
     *
     * @return void
     */
    private function renderUserDetails()
    {
        global $wp_query;
        $user_id = $wp_query->query_vars['user_id'];

        // Fetch the user details from the API
        $user_details = $this->fetchUserDetails($user_id);

        // Extract user_details array to variables
        extract($user_details);

        // Check if the 'json' query variable is set and render the JSON output
        if (isset($wp_query->query_vars['json']) && $wp_query->query_vars['json'] == 1) {
            header('Content-Type: application/json');
            echo json_encode($user_details);
        } else {
            // Otherwise, render the HTML template
            include plugin_dir_path(__DIR__) . '/templates/user-details-template.php';
        }
        exit;
    }
}
