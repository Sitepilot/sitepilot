<?php

use Sitepilot\Plugin;

/**
 * Plugin Name: Sitepilot
 * Plugin URI: https://sitepilot.io
 * Author: Sitepilot
 * Author URI: https://sitepilot.io
 * Version: 2.0.0-dev
 * Description: Brings the powers of Sitepilot directly to your WordPress website.
 * Text Domain: sitepilot
 */

if (!defined('ABSPATH')) exit;

define('SITEPILOT_DIR', __DIR__);
define('SITEPILOT_FILE', __FILE__);
define('SITEPILOT_URL', untrailingslashit(plugin_dir_url(__FILE__)));

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

if (!function_exists('sitepilot')) {
    /**
     * Returns the Sitepilot plugin instance.
     *
     * @return Plugin
     */
    function sitepilot(): Plugin
    {
        return Plugin::make();
    }
}

sitepilot();
