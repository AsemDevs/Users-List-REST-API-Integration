<?php

namespace UserSpotlightPro\REST_API;

class ApiService
{
    public function init()
    {
        add_action('init', [$this, 'add_endpoint']);
        add_action('template_redirect', [$this, 'render_template']);
    }

    public function add_endpoint()
    {
        add_rewrite_rule('^user-list/?$', 'index.php?user_list_template=1', 'top');
        add_rewrite_tag('%user_list_template%', '([^&]+)');

        add_rewrite_rule('^user-details/([^/]+)/?$', 'index.php?user_details_template=1&user_id=$matches[1]', 'top');
        add_rewrite_tag('%user_details_template%', '([^&]+)');
        add_rewrite_tag('%user_id%', '([^&]+)');
    }

    public function fetch_users()
    {
        $response = wp_remote_get('https://jsonplaceholder.typicode.com/users');

        if (is_wp_error($response)) {
            return []; // To return an empty array in case of an error
        }

        $users = json_decode(wp_remote_retrieve_body($response), true);

        return $users;
    }
    private function fetch_user_details($user_id)
    {
        $api_url = 'https://jsonplaceholder.typicode.com/users/' . $user_id;
        $response = wp_remote_get($api_url);

        if (is_wp_error($response)) {
            return [];
        }

        $user_details = json_decode(wp_remote_retrieve_body($response), true);

        return $user_details;
    }

    public function render_template()
    {
        global $wp_query;
    
        if (isset($wp_query->query_vars['user_list_template']) && $wp_query->query_vars['user_list_template'] == 1) {
            // Fetch the user data from the API
            $user_data = $this->fetch_users();
    
            include plugin_dir_path(__FILE__) . '../templates/user-table-template.php';
            exit;
        } elseif (isset($wp_query->query_vars['user_details_template']) && $wp_query->query_vars['user_details_template'] == 1) {
            $user_id = $wp_query->query_vars['user_id'];
            // Fetch user details from the API
            $user_details = $this->fetch_user_details($user_id);
    
            // Include the user-details-template.php
            include plugin_dir_path(__FILE__) . '../templates/user-details-template.php';
            exit;
        }
    }
}