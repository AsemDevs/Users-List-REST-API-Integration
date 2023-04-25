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
    }
    
    public function render_template()
    {
        global $wp_query;
    
        if (isset($wp_query->query_vars['user_list_template']) && $wp_query->query_vars['user_list_template'] == 1) {
            // Include the user-table-template.php file to display the user table
            include plugin_dir_path(__FILE__) . '../Templates/user-table-template.php';
            exit;
        }
    }
    
    
    
}
