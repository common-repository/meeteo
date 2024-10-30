<?php

/**
 * Registering the menus
 */
class Meeteo_Admin_Views
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'meeteo_register_menus'));
    }

    /**
     * Register Menus
     */
    public function meeteo_register_menus()
    {
        add_menu_page('meeteo',
            'Meeteo',
            'manage_options',
            'meeteo_webinars',
            array($this, 'get_upcoming_webinars'),
//            'dashicons-media-interactive',
            MEETEO_PLUGIN_ADMIN_ASSETS_URL.'/img/wp-menu-icon.png',
            59
        );
        if (get_option('meeteo_app_id')) {
            //Submenus from here.
            add_submenu_page('meeteo_webinars',
                'Upcoming Webinars',
                'Upcoming Webinars',
                'manage_options',
                'meeteo_webinars',
                array($this, 'get_upcoming_webinars'));

            add_submenu_page('meeteo_webinars',
                'Services',
                'Services',
                'manage_options',
                'meeteo_services',
                array($this, 'get_services'));

        }

        add_submenu_page('meeteo_webinars',
            'Settings',
            'Settings',
            'manage_options',
            'meeteo_setting',
            array($this, 'display_settings'));

    }

    /**
     * list the webinars
     */
    public static function get_upcoming_webinars()
    {
        $webinars = [];
        $webinars_result = meeto_api()->listWebinar();
        if ($webinars_result) {
            $webinars_data = json_decode($webinars_result);
            if (($webinars_data->success)) {
                $webinars = $webinars_data->data->data;
            } else {
//            self::set_message('error', $webinars_data->message);
            }
        }
        require_once MEETEO_PLUGIN_VIEWS_PATH . '/webinars/view-webinars-list.php';
    }


    /**
     * list the webinars
     */
    public static function get_services()
    {
        $services = [];
        $services_result = meeto_api()->listService();
        if ($services_result) {
            $services_data = json_decode($services_result);
            
            if (($services_data->success)) {
                $services = $services_data->data->data;
            } else {
//            self::set_message('error', $services_data->message);
            }
        }
        require_once MEETEO_PLUGIN_VIEWS_PATH . '/services/view-services-list.php';
    }


    /**
     * Settings page
     */
    public function display_settings()
    {
        if (isset($_POST['save_meeteo_settings'])) {
            check_admin_referer('_meeteo_settings_nonce_validation', '_meeteo_settings_nonce');
            $meeteo_app_id = sanitize_text_field(filter_input(INPUT_POST, 'meeteo_app_id'));
            $meeteo_enable_popup_widget = sanitize_text_field(filter_input(INPUT_POST, 'meeteo_enable_popup_widget'));
            $meeteo_company_domain = sanitize_text_field(filter_input(INPUT_POST, 'meeteo_company_domain'));
            update_option('meeteo_app_id', $meeteo_app_id);
            update_option('meeteo_enable_popup_widget', $meeteo_enable_popup_widget);
            update_option('meeteo_company_domain', $meeteo_company_domain);
            ?>
            <div id="message" class="notice notice-success is-dismissible">
                <p>Successfully Updated. Please refresh this page</p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
            <?php
        }
        $meeteo_app_id = get_option('meeteo_app_id');
        $meeteo_enable_popup_widget = get_option('meeteo_enable_popup_widget');
        $meeteo_company_domain = get_option('meeteo_company_domain');
        do_action('admin_enqueue_scripts');
        ?>
        <div class="meeteo-card">
            <div class="meeteo-card-toolbar">
                <img src="<?php echo MEETEO_PLUGIN_ADMIN_ASSETS_URL . '/img/logo.svg' ?>" alt="logo" />

                <h2>Meeteo Setting</h2>
            </div>

            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <?php wp_nonce_field('_meeteo_settings_nonce_validation', '_meeteo_settings_nonce'); ?>
                <div class="form-group-wrap-inline">
                    <div class="form-group">
                        <label for="">Meeteo App ID</label>
                        <input type="text" name="meeteo_app_id" value="<?php echo $meeteo_app_id; ?>" />
                    </div>
                </div>
                <br>
                <div class="form-group-wrap-inline">
                    <div class="form-group">
                        <label for="">Meeteo Company Domain URL (Eg: companyname.meeteo.io)</label>
                        <input type="text" name="meeteo_company_domain" value="<?php echo $meeteo_company_domain; ?>" />
                    </div>
                </div>

                <div class="custom-row enable-pop">
                    <h4 class="custom-col" style="width:200px;margin:0;">
                        Enable Popup Widget 
                    </h4>
                    <div class="custom-col">
                        <label for="popWidget" class="me-checkbox">
                            <input type="checkbox" id="popWidget" name="meeteo_enable_popup_widget" <?php ! empty( $meeteo_enable_popup_widget ) ? checked( $meeteo_enable_popup_widget, 'on' ) : false; ?>>
                            Adds floating button on every page which opens Meeteo on popup with content from company domain URL.
                        </label>
                    </div>
                </div>

                <input type='submit' name="save_meeteo_settings" value='Save' class='btn-default' style="align-self:flex-end; margin-bottom: 20px">
            </form>

            <h3>Get Your App ID</h3>
            <ol>
                <li>Login to your Meeteo Application and go to workspace profile.</li>
                <li>There you can find the app_id for your account. Copy the app_id and paste in the text field above.</li>
                <li>Click 'Save changes' after you are done.</li>
            </ol>

            <ul class="default-tab tabs">
                <li data-title="Shortcode">
                    <div class="custom-row">
                        <div class="custom-col">
                            <h3>Shortcode Usage</h3>
                            <ol>
                                <li>
                                    List of Upcoming webinars<br/>
                                    <code>
                                        [meeteo_upcoming_webinars max=Number of services to list]
                                    </code>
                                </li>
                                <li>
                                    List of services<br/>
                                    <code>
                                        [meeteo_services max=Number of services to list]
                                    </code>
                                </li>
                                <li>
                                    Webinar detail by id<br/>
                                    <code>
                                        [meeteo_webinar webinar_id=ID of the webinar]
                                    </code>
                                </li>
                                <li>
                                    Embed meeteo widget to website<br/>
                                    <code>
                                    [meeteo_embed type=embed_type url="meeteo_url"]
                                    </code>
                                </li>
                            </ol>
                        </div>

                        <div class="custom-col" style="width:25%; margin-left:auto; padding-left:30px; border-left:1px solid #DDD;">
                            <h3>Available Embed type options:</h3>
                            <ul class="bullet-list">
                                <li><strong>inline</strong> - Loads your Meeteo page directly in your website in an iframe.
                                    <br><br> You can set width and height of iframe using options "iframe_width" and "iframe_height".
                                <br><br> Eg: [meeteo_embed type=embed_type url="meeteo_url" iframe_width=100% iframe_height=600px]
                                </li>
                                <li><strong>inline_link</strong> - Add link on site to launch Meeteo. Opens widget link in new window.</li>
                                <li><strong>popup_text</strong> - Add link on site to launch Meeteo. Opens widget on popup.</li>
<!--                                <li><strong>popup_widget</strong> - Adds floating button on the right side which opens Meeteo on popup.</li>-->
                            </ul>
                        </div>
                    </div>
                </li>

                <li data-title="Popup Widget">
                    <h3>Popup Widget</h3>
                    <p>
                        A Popup Widget adds floating button on every page which opens Meeteo on popup.
                        <br>
                        In order to add pop widget to your website, you can simply check the checkbox labelled "Enable Popup Widget
                        " in above form <br>or you can follow the steps below:
                    </p>
                    <br>
                    <ol>
                        <li>
                            Login to your Meeteo application and go to Widget menu.
                        </li>
                        <li>
                            Select "popup widget" option and click "Continue" button.
                            <img src="<?php echo MEETEO_PLUGIN_ADMIN_ASSETS_URL . '/img/widget-page.png' ?>" alt="meeteo widget page"
                            height="400px" style="display:block; margin:20px 0 40px; max-width:100%">
                        </li>
                        <li>
                            Copy the script from "Ready to embed" block.
                            <img src="<?php echo MEETEO_PLUGIN_ADMIN_ASSETS_URL . '/img/widget-script.png' ?>" alt="meeteo widget page"
                            height="400px" style="display:block; margin:20px 0 40px;">
                        </li>
                        <li>
                            Paste it in the footer.php (just above closing body tag `&lt;/body&gt;`)
                        </li>
                    </ol>
                </li>
            </ul>
        </div>
        <?php
    }
}

new Meeteo_Admin_Views();
