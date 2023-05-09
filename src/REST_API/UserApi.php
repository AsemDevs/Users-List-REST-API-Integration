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
        add_action('wp_ajax_get_user_details', [$this, 'handle_ajax_request']);
        add_action('wp_ajax_nopriv_get_user_details', [$this, 'handle_ajax_request']);
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
        $custom_endpoint = get_option('user_spotlight_pro_endpoint', '/user-list');
        $custom_endpoint = trim($custom_endpoint, '/');
        $custom_endpoint_regex = "^{$custom_endpoint}$";

        add_rewrite_rule($custom_endpoint_regex, 'index.php?user_list_template=1', 'top');
        add_rewrite_tag('%user_list_template%', '([^&]+)');
    }

    /**
     * Adds user details endpoint and rewrite tags.
     *
     * @return void
     */
    private function addUserDetailsEndpoint()
    {
        add_rewrite_rule('^user-details/?$', 'index.php?user_details_template_file=1', 'top');
        add_rewrite_tag('%user_details_template_file%', '([^&]+)');

        add_rewrite_rule(
            '^user-details/([^/]+)/?$',
            'index.php?user_details_template=1&user_id=$matches[1]',
            'top'
        );
        add_rewrite_tag('%user_details_template%', '([^&]+)');
        add_rewrite_tag('%user_id%', '([^&]+)');
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
        } elseif (
            isset($wp_query->query_vars['user_details_template_file'])
            && $wp_query->query_vars['user_details_template_file'] == 1
        ) {
            include plugin_dir_path(__FILE__) . '../templates/user-details-template.php';
            exit;
        }
    }
    /**
     * Handle AJAX request for fetching user details.
     * It checks for a valid user ID in the POST data, fetches the user details,
     * and sends a JSON response.
     */
    public function handle_ajax_request()
    {
        if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
            $user_id = intval($_POST['user_id']);
            $user_details = $this->fetchUserDetails($user_id);

            if (!empty($user_details)) {
                wp_send_json_success($user_details);
            } else {
                wp_send_json_error(['message' => 'User details not found.']);
            }
        } else {
            wp_send_json_error(['message' => 'Invalid user ID.']);
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
        $users_per_page = intval(get_option('user_spotlight_pro_users_per_page', '10'));

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

        $user_details = $this->fetchUserDetails($user_id);
        extract($user_details);

        include plugin_dir_path(__DIR__) . '/templates/user-details-template.php';
        exit;
    }
}
