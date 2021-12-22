<?php

namespace Sitepilot;

class Dashboard extends Module
{
    /**
     * Initialize the dashboard module.
     *
     * @return void
     */
    public function init(): void
    {
        /* Actions */
        add_action('admin_menu', [$this, 'action_admin_menu']);
    }

    /**
     * Register admin menu.
     *
     * @return void
     */
    public function action_admin_menu(): void
    {
        add_menu_page(
            sitepilot()->branding()->get_name(),
            sitepilot()->branding()->get_name(),
            'publish_posts',
            'sitepilot-menu',
            '',
            false,
            2
        );

        $page_hook_suffix = add_submenu_page(
            'sitepilot-menu',
            sitepilot()->branding()->get_name(),
            __('Dashboard', 'sitepilot'),
            'publish_posts',
            'sitepilot-menu',
            [$this, 'render_dashboard_page']
        );

        add_action("admin_print_scripts-{$page_hook_suffix}", [$this, 'action_enqueue_assets']);
    }

    /**
     * Enqueue dashboard page assets.
     *
     * @return void
     */
    function action_enqueue_assets(): void
    {
        /* Styles */
        wp_enqueue_style('sp-dashboard');

        /* Scripts */
        wp_enqueue_script('sp-dashboard');

        /* Data */
        global $wp_version;

        $last_update = sitepilot()->model()->get_last_update_date();

        wp_localize_script(
            'sp-dashboard',
            'sitepilot',
            array(
                'version' => sitepilot()->model()->get_version(),
                'plugin_url' => SITEPILOT_URL,
                'branding_name' => sitepilot()->branding()->get_name(),
                'support_email' => sitepilot()->branding()->get_support_email(),
                'support_url' => sitepilot()->branding()->get_support_url(),
                'server_name' => gethostname(),
                'php_version' => phpversion(),
                'wp_version' => $wp_version,
                'last_update_date' => $last_update ? date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $last_update) : '-',
                'powered_by' => strip_tags(sitepilot()->branding()->get_powered_by_text()),
                'support_enabled' => true,
                'cache_status' => sitepilot()->cache()->is_page_cache_enabled() ? __('On', 'sitepilot') : __('Off', 'sitepilot')
            )
        );
    }

    /**
     * Render dashboard page.
     *
     * @return void
     */
    function render_dashboard_page()
    {
        echo '<div class="sp-dashboard sitepilot" id="sitepilot-dashboard"></div>';
    }
}
