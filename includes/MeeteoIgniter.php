<?php

namespace Meeteo\WPApi;
defined('ABSPATH') || exit;

/**
 * Ignite Main Class
 */
final class MeeteoIgniter
{
    private static $_instance = null;

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private $plugin_version = '1.0.0';

    public function __construct()
    {
        $this->load_dependencies();
        $this->init_api();
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts_backend'));
        add_action('init', array($this, 'load_plugin_textdomain'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    /**
     * Initialize the hooks
     *
     */
    protected function init_api()
    {
        meeto_api()->meeteo_app_id = get_option('meeteo_app_id');
    }

    /**
     * Enqueuing Scripts and Styles for Front end
     */
    function enqueue_scripts()
    {
        wp_enqueue_style('meeteo-widget-external-css', "https://app.meeteo.io/assets/widget/external.css");
        wp_enqueue_script('meeteo-widget-external-js', 'https://app.meeteo.io/assets/widget/external.js');
        wp_enqueue_style('meeteo-widget-css', MEETEO_PLUGIN_FRONT_ASSETS_URL . '/css/meeteo-style.css');
        $meeteo_enable_popup_widget = get_option('meeteo_enable_popup_widget');
        if ($meeteo_enable_popup_widget == 'on') {
            add_action('wp_head', [$this,'meeteo_add_meta_tags']);
            wp_enqueue_script('meeteo-widget-script', MEETEO_PLUGIN_FRONT_ASSETS_URL . '/js/meeteo-enable-popup-widget.js');
        }
    }

    function meeteo_add_meta_tags()
    {
        echo '<meta name="meeteo-company-domain" content="' . get_option('meeteo_company_domain') . '" />' . "\n";
        echo '<meta name="meeteo-appid" content="' . get_option('meeteo_app_id') . '" />' . "\n";
    }

    /**
     * Include required core files used in admin and on the frontend.
     */
    protected function load_dependencies()
    {
        //Include the API Class
        require_once MEETEO_PLUGIN_INCLUDES_PATH . '/api/class-meeteo-api.php';
        //Admin Classes
        require_once MEETEO_PLUGIN_INCLUDES_PATH . '/admin/class-meeteo-admin-settings.php';
        require_once MEETEO_PLUGIN_INCLUDES_PATH . '/shortcodes/embed.php';
        //Shortcode
        require_once MEETEO_PLUGIN_INCLUDES_PATH . '/Shortcodes.php';
    }

    /**
     * Enqueuing Scripts and Styles for Admin
     */
    public function enqueue_scripts_backend()
    {
        //Load CSS
        wp_enqueue_style('meeteo-admin-css', MEETEO_PLUGIN_ADMIN_ASSETS_URL . '/css/style-admin.css');

        //Load Scripts
        wp_enqueue_script('meeteo-simple-datatable-script', MEETEO_PLUGIN_ADMIN_ASSETS_URL . '/js/simple-datatables-latest.js', array(), $this->plugin_version, true);
        wp_enqueue_script('meeteo-slim-select-script', MEETEO_PLUGIN_ADMIN_ASSETS_URL . '/js/slimselect.min.js', array(), $this->plugin_version, true);
        wp_enqueue_script('meeteo-slim-vanilla-tabs', MEETEO_PLUGIN_ADMIN_ASSETS_URL . '/js/vanilla-tabs-master/vanilla.tabs.js', array(), $this->plugin_version, true);
        wp_enqueue_script('meeteo-script', MEETEO_PLUGIN_ADMIN_ASSETS_URL . '/js/main.js', array(), $this->plugin_version, true);
    }

    /**
     * language configurations
     */
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain('wpmeeteo', false, MEETEO_PLUGIN_LANGUAGE_PATH);
    }

    /**
     * Activate the plugin
     */
    public static function activate()
    {
        //Flush Permalinks
        flush_rewrite_rules();
    }

    /**
     * Deactivating the plugin
     */
    public static function deactivate()
    {
        flush_rewrite_rules();
    }
}