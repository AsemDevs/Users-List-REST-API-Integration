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
        add_rewrite_rule('^user-list/?$', 'index.php?user_table_template=1', 'top');
        add_rewrite_tag('%user_table_template%', '([^&]+)');
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

    public function render_template()
    {
        global $wp_query;
    
        if (isset($wp_query->query_vars['user_table_template']) && $wp_query->query_vars['user_table_template'] == 1) {
            // Fetch the user data from the API
            $user_data = $this->fetch_users();

            include plugin_dir_path(__FILE__) . '../templates/user-table-template.php';
            exit;
        }
    }
}
