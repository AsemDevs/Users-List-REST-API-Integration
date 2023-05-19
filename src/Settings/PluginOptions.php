<?php

declare(strict_types=1);

namespace UserSpotlightPro\Settings;

/**
 * Class PluginOptions
 * Handles the plugin settings page and related functionality.
 */
class PluginOptions
{
    /**
     * Initializes the plugin settings by registering necessary hooks.
     */
    public function init()
    {
        add_action('admin_menu', [$this, 'register_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action(
            'update_option_user_spotlight_pro_endpoint',
            [$this, 'flush_rules_on_endpoint_change'],
            10,
            2
        );
    }

    /**
     * Registers the plugin settings page.
     */
    public function register_settings_page()
    {
        add_options_page(
            'User Spotlight Pro',
            'User Spotlight Pro',
            'manage_options',
            'user-spotlight-pro',
            [$this, 'settings_page']
        );
    }
    public function flush_rules_on_endpoint_change($old_value, $value)
    {
        if ($old_value !== $value) {
            $userApi = new \UserSpotlightPro\REST_API\UserApi();
            $userApi->addEndpoint();
            flush_rewrite_rules();
        }
    }

    /**
     * Registers the plugin settings.
     */
    public function register_settings()
    {
        register_setting('user_spotlight_pro', 'user_spotlight_pro_endpoint');
        register_setting('user_spotlight_pro', 'user_spotlight_pro_users_per_page');
    }

    /**
     * Renders the plugin settings page.
     */
    public function settings_page()
    {
        if (isset($_POST['clear_cache'])) {
            $userApi = new \UserSpotlightPro\REST_API\UserApi();
            $userApi->clear_transients();
            echo '<div class="notice notice-success
             is-dismissible"><p>Cache cleared successfully.</p></div>';
        }
        ?>
        <div class="wrap">
            <h1>User Spotlight Pro Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('user_spotlight_pro');
                do_settings_sections('user_spotlight_pro');

                $endpoint = get_option('user_spotlight_pro_endpoint', '/user-list');
                $usersPerPage = get_option('user_spotlight_pro_users_per_page', 5);
                ?>
                <table class="form-table">
                    <caption>Plugin Options</caption>
                    <tr class="align-top">
                        <th scope="row">Custom Endpoint</th>
                        <td>
                            <input type="text" name="user_spotlight_pro_endpoint"
                            value="<?php echo esc_attr($endpoint); ?>" />
                        </td>
                    </tr>
                    <tr class="align-top">
                        <th scope="row">Users Per Page</th>
                        <td>
                            <input type="number" min="1" name="user_spotlight_pro_users_per_page"
                            value="<?php echo esc_attr($usersPerPage); ?>" />
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>

            <!-- Clear Cache Form -->
            <form method="post">
                <input type="submit" name="clear_cache"
                class="button button-secondary" value="Clear Cache">
            </form>
        </div>

        <?php
    }
}
