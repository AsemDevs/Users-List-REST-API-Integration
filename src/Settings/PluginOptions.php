<?php

declare(strict_types=1);

namespace UserSpotlightPro\Settings;

class PluginOptions
{
    public function init()
    {
        add_action('admin_menu', [$this, 'register_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

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

    public function register_settings()
    {
        register_setting('user_spotlight_pro', 'user_spotlight_pro_endpoint');
    }

    public function settings_page()
    {
?>
        <div class="wrap">
            <h1>User Spotlight Pro Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('user_spotlight_pro');
                do_settings_sections('user_spotlight_pro');

                $endpoint = get_option('user_spotlight_pro_endpoint', '/user-list');
                ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Custom Endpoint</th>
                        <td>
                            <input type="text" name="user_spotlight_pro_endpoint" value="<?php echo esc_attr($endpoint); ?>" />
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
<?php
    }
}
