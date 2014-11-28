<?php
/*
 * Plugin Name: BigContact Contact Page
 * Plugin URI: http://bigemployee.com/projects/big-contact-wordpress-plugin/
 * Description: Create super cool contact pages for your site. Includes advanced business options. Big Contact Page makes it possible for you to quickly and easily create sophisticated custom contact pages. You can choose to make just a contact form or make it an appointment form. Display business hours, contact emails, phone numbers, or maps and directions on any page or section of the pages or posts on your site.
 * Author: Arian Khosravi, Norik Davtian
 * Author URI: http://bigemployee.com
 * Version: 1.5.8
 * License: GPL3
 * License URI: http://www.gnu.org/licenses/gpl.html
 */

require_once('include/functions.php');
require_once('models/form.php');
require_once('models/email.php');
require_once('models/phone.php');
require_once('models/settings.php');
require_once('models/formMapper.php');
require_once('models/emailMapper.php');
require_once('models/phoneMapper.php');
require_once('models/settingsMapper.php');
require_once('classes/metaBox.php');
require_once('classes/form.php');
require_once('classes/BigContactWidget.php');

class BigContact {

    function BigContact() {
        $bigDb = get_option('BigContact_DB_V');
        if ($bigDb != false && $bigDb < 5)
            $this->init_update($bigDb);
        define('BIGCONTACT_PATH', plugin_dir_path(__FILE__));
        define('BIGCONTACT_URL', plugins_url('/', __FILE__));
        add_action('init', array(&$this, 'init_BigContact_Scripts'));
        add_action('admin_menu', array(&$this, 'init_BigContact_menu'));
        add_action('widgets_init', array(&$this, 'init_BigContact_Widgets'));
        add_action('admin_enqueue_scripts', array(&$this, 'init_BigContact_admin_head'));
        add_action('load-post.php', array(&$this, 'init_BigContact_MetaBox'));
        add_action('load-post-new.php', array(&$this, 'init_BigContact_MetaBox'));
        add_shortcode('bigContact', array(&$this, 'init_bigContact_ShortCode'));
        add_action('wp_footer', array(&$this, 'print_BigContact_Frontend_Scripts'));
        add_action('wp_print_styles', array(&$this, 'print_BigContact_Frontend_Styles'));
        setcookie('bigcontact-email-flag', time(), time() + 3600, COOKIEPATH, COOKIE_DOMAIN, false);
    }

    function init_BigContact_menu() {
        global $bigContact_page, $bigContact_settings;
        add_menu_page('Big Contact', 'Big Contact', 'install_plugins', "big-contact", array(&$this, 'init_bigContact'), 'dashicons-email');
        $bigContact_page = add_submenu_page("big-contact", 'Big Contact', 'Form Options ', 'edit_theme_options', "big-contact", array(&$this, 'init_BigContact'));
        $bigContact_settings = add_submenu_page("big-contact", 'Big Contact', 'Settings', 'edit_theme_options', "big-contact-settings", array(&$this, 'init_BigContact_Settings'));
        add_action('admin_print_styles-' . $bigContact_page, array(&$this, 'print_BigContact_admin_styles'));
        add_action('admin_print_scripts-' . $bigContact_page, array(&$this, 'print_BigContact_admin_scripts'));
        add_action('load-' . $bigContact_page, array(&$this, 'init_BigContact_Help_Tab'));
        add_action('load-' . $bigContact_settings, array(&$this, 'init_BigContact_Help_Tab'));
    }

    function init_bigContact() {
        include_once 'view/BigContact.phtml';
    }

    function init_BigContact_Settings() {
        include_once 'view/BigContactSettings.phtml';
    }

    function init_BigContact_Help_Tab() {
        global $bigContact_page, $bigContact_settings;
        $screen = get_current_screen();
        if ($screen->id == $bigContact_page) {
            $screen->add_help_tab(array(
                'id' => 'bigContact_overview',
                'title' => __('Overview'),
                'content' =>
                '<p>' . __('Big Contact Page makes it possible for you to quickly and easily create sophisticated custom contact pages.') . '</p>' .
                '<p>' . __('You can use all or any combination of the sections below to create your contact page. The elements on your contact page can be placed in any particular position.') . '</p>' .
                '<p>' . __('You can choose to make just a contact form or make it an appointment form. Display business hours, contact emails, phone numbers, or maps and directions on any page or section of the pages or posts on your site.') . '</p>' .
                '<p>' . __('For more information and costomization options visit the <a href="http://bigemployee.com/projects/big-contact-wordpress-plugin/">plugins page</a>.') . '</p>',
            ));
            $screen->add_help_tab(array(
                'id' => 'bigContact_options',
                'title' => __('Customize'),
                'content' =>
                '<p>' . __('The goal of designing this plugin was to bring flexibilty and simplicity to the user. You can see a glimpse of how your contact page or components of your contact page will look like.') . '</p>' .
                '<p>' . __('To quickly customize the form double click on any label on this page, replace the text and tap enter to save.') . '</p>' .
                '<p>' . __('For more information and costomization options visit the <a href="http://bigemployee.com/projects/big-contact-wordpress-plugin/">plugins page</a>.') . '</p>',
            ));
            $screen->add_help_tab(array(
                'id' => 'bigContact_publish',
                'title' => __('Publish'),
                'content' => '<p>' . __('To publish the form or any part of it on a page/post use the shortcode generator box on the posts/pages settings page.') . '</p>',
            ));
        } elseif ($screen->id == $bigContact_settings) {
            $screen->add_help_tab(array(
                'id' => 'bigContact_settings',
                'title' => __('Overview'),
                'content' =>
                '<p>' . __('You can customize some of the functionality of the contact page by manipulating the fields on this page.') . '</p>' .
                '<p>' . __('Follow the hints next to each field to corectly configure the plugin.') . '</p>' .
                '<p>' . __('For more information and costomization options visit the <a href="http://bigemployee.com/projects/big-contact-wordpress-plugin/">plugins page</a>.') . '</p>',
            ));
        }
        $screen->set_help_sidebar(
                '<p>If you like our plugin, feel free donate some spare change so we can refill our coffee pot and continue working to bring you more awesome plugins and themes.</p>' .
                '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="9C2U8HWTHUHHN">
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>' .
                '<p>Please <a href="http://wordpress.org/extend/plugins/bigcontact/">rate us on WordPress</a></p>' .
                '<p>For more information visit <a href="http://www.bigemployee.com">www.bigemployee.com</a></p>'
        );
    }

    function init_BigContact_Scripts() {
        wp_register_style('bigContact-adimn-style', plugins_url('view/css/admin.css', __FILE__), false, '1.0', 'all');
        wp_register_style('bigContact-style', plugins_url('view/css/bigContact.css', __FILE__), false, '1.0', 'all');
        $bigSettingsMapper = new BigContact_Models_SettingsMapper();
        $bigSettings = $bigSettingsMapper->fetchAll();
        if (count($bigSettings) > 0) {
            $locale = 'en';
            $bigSettings = $bigSettings[0];
            if (null !== $bigSettings && !is_array($bigSettings)) {
                wp_register_style('jquery-ui-datepicker-style', $bigSettings->getJQueryUiPath(), false, '1.8.18', 'all');
                $locale = $bigSettings->getLocale();

                if ($locale && $locale != 'en') {
                    wp_register_script('jquery-ui-internationalization', plugins_url('languages/jquery.ui.datepicker-' . $locale . '.js', __FILE__), array('jquery', 'jquery-ui-datepicker', 'bigContact-timepicker'));
                }
            }
        }


        wp_register_script('jeditable', plugins_url('view/js/jquery.jeditable.mini.js', __FILE__), array('jquery'), '1.0', true);
        wp_register_script('bigContact-admin-script', plugins_url('view/js/bigContact-admin.js', __FILE__), array('jquery'), '1.0', true);
        wp_register_script('bigContact-shortcode-script', plugins_url('view/js/bigContact-shortCode.js', __FILE__), array('jquery'), '1.0', true);
        wp_register_script('bigContact-timepicker', plugins_url('view/js/jquery-ui-timepicker-addon.js', __FILE__), array('jquery', 'jquery-ui-datepicker'), '1.0', true);
        wp_register_script('bigContact-form-script', plugins_url('view/js/bigContactForm.js', __FILE__), array('jquery', 'jquery-ui-datepicker'), '1.0', true);
        wp_register_script('bigContact-widget-script', plugins_url('view/js/bigContactWidgets.js', __FILE__), array('jquery', 'jquery-ui-internationalization'), '1.0', true);
    }

    function init_BigContact_admin_head($hook) {
        if ('post.php' == $hook || 'post-new.php' == $hook) {
            wp_enqueue_script('jquery');
            wp_enqueue_script('bigContact-shortcode-script');
        }
    }

    function print_BigContact_admin_styles() {
        wp_enqueue_style('jquery-ui-datepicker-style');
        wp_enqueue_style('bigContact-adimn-style');
    }

    function print_BigContact_admin_scripts() {
        $locale = 'en';
        $bigSettingsMapper = new BigContact_Models_SettingsMapper();
        $bigSettings = $bigSettingsMapper->fetchAll();
        if (count($bigSettings) > 0) {
            $bigSettings = $bigSettings[0];
        }
        if (null !== $bigSettings && !is_array($bigSettings))
            $locale = $bigSettings->getLocale();
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('jquery-ui-slider');
        wp_enqueue_script('bigContact-timepicker');
        if ($locale && $locale != 'en') {
            wp_enqueue_script('jquery-ui-internationalization');
        }
        wp_enqueue_script('jeditable');
        wp_enqueue_script('bigContact-admin-script');
    }

    function print_BigContact_Frontend_Styles() {
        wp_enqueue_script('jquery');
        wp_enqueue_style('jquery-ui-datepicker-style');
        wp_enqueue_style('bigContact-style');
    }

    function print_BigContact_Frontend_Scripts() {
        global $print_BigContact_Frontend_Scripts;
        $locale = 'en';
        $bigSettingsMapper = new BigContact_Models_SettingsMapper();
        $bigSettings = $bigSettingsMapper->fetchAll();
        if (count($bigSettings) > 0) {
            $bigSettings = $bigSettings[0];
        }
        if (null !== $bigSettings && !is_array($bigSettings))
            $locale = $bigSettings->getLocale();
        if ($locale && $locale != 'en') {
            wp_enqueue_script('jquery-ui-internationalization');
        }
        wp_enqueue_script('bigContact-widget-script');

        if (!$print_BigContact_Frontend_Scripts)
            return;

        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('jquery-ui-slider');
        wp_enqueue_script('bigContact-timepicker');
        wp_enqueue_script('bigContact-form-script');
        ?>
        <?php if ($trackingCallback = $bigSettings->getTrackingCallback()): ?>
            <script>
                var bigContact_conversion_tracking_callback = function() {
            <?php echo html_entity_decode($trackingCallback) ?>
                }
            </script>
        <?php endif; ?>
        <?php if ($trackingScript = $bigSettings->getTracking()): ?>
            <?php echo html_entity_decode($trackingScript) ?>
        <?php endif; ?>
        <?php
    }

    function init_BigContact_Widgets() {
        register_widget("BigContactWidget");
    }

    function init_bigContact_ShortCode($atts, $content = NULL) {
        global $print_BigContact_Frontend_Scripts;
        $print_BigContact_Frontend_Scripts = true;
        extract(shortcode_atts(array(
            'form' => '',
            'subject' => '',
            'appointment' => '',
            'phones' => '',
            'emails' => '',
            'hours' => '',
            'map' => ''), $atts));
        $bigContactForm = new BigContact_Classes_Form($form, $appointment, $phones, $emails, $hours, $map, false, $subject);
        return $bigContactForm->generateForm();
    }

    function init_BigContact_MetaBox() {
        $screen = get_current_screen();
        $screen->add_help_tab(array(
            'id' => 'bigContact_settings',
            'title' => __('Big Contact Page'),
            'content' =>
            '<p>' . __('Simply check all the fields in the Big Contacts meta box you would like to include on the page and click insert into page.') . '</p>' .
            '<p>' . __('If Big Contacts meta box is not available on this page you can enable it from the Screen Options drawer.') . '</p>' .
            '<p>' . __('For more information and costomization options visit the <a href="http://bigemployee.com/projects/big-contact-wordpress-plugin/">plugins page</a>.') . '</p>',
        ));
        return new BigContacts_Classes_MetaBox();
    }

    static function installBigContact() {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        global $wpdb;

        $contacts = $wpdb->prefix . 'big_contacts';
        $contacts_emails = $wpdb->prefix . 'big_contacts_emails';
        $contacts_phones = $wpdb->prefix . 'big_contacts_phones';
        $contacts_settings = $wpdb->prefix . 'big_contacts_settings';

//        -------------------------------------------------------
//        --Table `big_contact`
//        -------------------------------------------------------
        $query = "DROP TABLE IF EXISTS `$contacts`;

CREATE TABLE IF NOT EXISTS `$contacts` (
`id` INT NOT NULL AUTO_INCREMENT,
`form_title` VARCHAR(255) NULL,
`tel_title` VARCHAR(255) NULL,
`email_title` VARCHAR(255) NULL,
`hours_title` VARCHAR(255) NULL,
`map_title` VARCHAR(255) NULL,
`name_label` VARCHAR(255) NULL,
`email_label` VARCHAR(255) NULL,
`phone_label` VARCHAR(255) NULL,
`extra_label` VARCHAR(255) NULL,
`message_label` VARCHAR(255) NULL,
`appointment_text` VARCHAR(255) NULL,
`send_mail` VARCHAR(255) NULL,
`mon_from` VARCHAR(255) NULL,
`tue_from` VARCHAR(255) NULL,
`wed_from` VARCHAR(255) NULL,
`thu_from` VARCHAR(255) NULL,
`fri_from` VARCHAR(255) NULL,
`sat_from` VARCHAR(255) NULL,
`sun_from` VARCHAR(255) NULL,
`map_description` TEXT NULL,
`map_object` TEXT NULL,
`address` VARCHAR(255) NULL,
PRIMARY KEY (`id`) )";
        dbDelta($query);

//        -------------------------------------------------------
//        --Table `big_contact_emails`
//        -------------------------------------------------------
        $query = "DROP TABLE IF EXISTS `$contacts_emails`;

CREATE TABLE IF NOT EXISTS `$contacts_emails` (
`id` INT NOT NULL AUTO_INCREMENT,
`label` VARCHAR(255) NULL,
`address` VARCHAR(255) NULL,
PRIMARY KEY (`id`) )";
        dbDelta($query);

//        -------------------------------------------------------
//        --Table `big_contact_phones`
//        -------------------------------------------------------
        $query = "DROP TABLE IF EXISTS `$contacts_phones`;

CREATE TABLE IF NOT EXISTS `$contacts_phones` (
`id` INT NOT NULL AUTO_INCREMENT,
`label` VARCHAR(255) NULL,
`number` VARCHAR(255) NULL,
PRIMARY KEY (`id`) )";
        dbDelta($query);

//        -------------------------------------------------------
//        --Table `big_contact_phones`
//        -------------------------------------------------------
        $query = "DROP TABLE IF EXISTS `$contacts_settings`;

CREATE TABLE IF NOT EXISTS `$contacts_settings` (
`id` INT NOT NULL AUTO_INCREMENT,
`bcc` VARCHAR(255) NULL,
`emailTo` VARCHAR(255) NULL,
`appointTo` VARCHAR(255) NULL,
`emailSubject` VARCHAR(255) NULL,
`emailMessage` VARCHAR(255) NULL,
`appointSubject` VARCHAR(255) NULL,
`appointMessage` VARCHAR(255) NULL,
`response` VARCHAR(255) NULL,
`replyEmail` VARCHAR(255) NULL,
`replySubject` VARCHAR(255) NULL,
`replyMessage` TEXT NULL,
`gapiKey` VARCHAR(255) NULL,
`jQueryUiPath` VARCHAR(255) NULL,
`calendarType` VARCHAR(255) NOT NULL DEFAULT 'date',
`dateFormat` VARCHAR(255) NOT NULL DEFAULT 'DD-MM dd, yy',
`timeFormat` VARCHAR(255) NOT NULL DEFAULT 'hh:mm tt',
`ampm` VARCHAR(255) NOT NULL DEFAULT 'true',
`showMinute` VARCHAR(255) NOT NULL DEFAULT 'true',
`locale`  VARCHAR(255) NOT NULL DEFAULT 'en',
`trackingCallback` VARCHAR(255) NULL,
`tracking` TEXT NULL,
PRIMARY KEY (`id`) )";
        dbDelta($query);

        update_option("BigContact_DB_V", 5);
    }

    static function BigContact_addData() {
        global $wpdb;
        $contacts = $wpdb->prefix . 'big_contacts';
        $contacts_emails = $wpdb->prefix . 'big_contacts_emails';
        $contacts_phones = $wpdb->prefix . 'big_contacts_phones';
        $contacts_settings = $wpdb->prefix . 'big_contacts_settings';

        $wpdb->query('TRUNCATE ' . $contacts);
        $wpdb->query('TRUNCATE ' . $contacts_emails);
        $wpdb->query('TRUNCATE ' . $contacts_phones);
        $preload_data = array(
            'form_title' => 'Contact Us / Send Us an Email',
            'tel_title' => 'Contact Us / Phone Us',
            'email_title' => 'Contact Us / E-Mail',
            'hours_title' => 'Contact Us / Office Hours',
            'map_title' => 'Contact Us / Map & Directions',
            'name_label' => 'Your Full Name',
            'email_label' => 'Email Address',
            'phone_label' => 'Phone Number',
            'extra_label' => 'How did you hear about us?',
            'message_label' => 'Enter Your Message',
            'appointment_text' => 'I would like an appointment for:',
            'send_mail' => 'Send E-mail',
            'mon_from' => '8:00 AM-6:00 PM',
            'tue_from' => '8:00 AM-6:00 PM',
            'wed_from' => '8:00 AM-6:00 PM',
            'thu_from' => '8:00 AM-6:00 PM',
            'fri_from' => '8:00 AM-6:00 PM',
            'sat_from' => '8:00 AM-6:00 PM',
            'sun_from' => 'Closed',
            'map_description' => 'We are located just seconds away from the beautiful Santa Monica beach. Parking is available inside the building.',
            'address' => '200 Santa Monica Pier Santa Monica, CA 90401'
        );

        $wpdb->insert($contacts, $preload_data);
        $preload_data = array(
            'label' => 'Office:',
            'Number' => '123-2556-7890'
        );
        $wpdb->insert($contacts_phones, $preload_data);
        $preload_data = array(
            'label' => 'Toll-Free:',
            'Number' => '888-888-8888'
        );
        $wpdb->insert($contacts_phones, $preload_data);
        $preload_data = array(
            'label' => 'John Smith:',
            'address' => 'example@domain.com'
        );
        $wpdb->insert($contacts_emails, $preload_data);
        $preload_data = array(
            'label' => 'Sales:',
            'address' => 'example@domain.com'
        );
        $wpdb->insert($contacts_emails, $preload_data);
        $preload_data = array(
            'label' => 'Customer Service:',
            'address' => 'example@domain.com'
        );
        $wpdb->insert($contacts_emails, $preload_data);

        $preload_data = array(
            'bcc' => null,
            'emailTo' => null,
            'appointTo' => null,
            'emailSubject' => null,
            'emailMessage' => null,
            'appointSubject' => null,
            'appointMessage' => null,
            'response' => null,
            'replyEmail' => null,
            'replySubject' => null,
            'replyMessage' => "Hi [name],\n\nSomeone will get back to you for your appointment request on [date].\n--\nSincerely,\nthe company team",
            'gapiKey' => null,
            'jQueryUiPath' => plugins_url('view/css/redmond/jquery-ui-1.8.18.custom.css', __FILE__),
            'calendarType' => 'date',
            'dateFormat' => 'DD-MM dd, yy',
            'timeFormat' => 'hh:mm tt',
            'ampm' => true,
            'showMinute' => true,
            'locale' => 'en',
            'trackingCallback' => null,
            'tracking' => null,
        );
        $wpdb->insert($contacts_settings, $preload_data);
    }

    static function uninstallBigContact() {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $contacts = $wpdb->prefix . 'big_contacts';
        $contacts_emails = $wpdb->prefix . 'big_contacts_emails';
        $contacts_phones = $wpdb->prefix . 'big_contacts_phones';
        $contacts_settings = $wpdb->prefix . 'big_contacts_settings';

        $wpdb->query("DROP TABLE " . $contacts);
        $wpdb->query("DROP TABLE " . $contacts_emails);
        $wpdb->query("DROP TABLE " . $contacts_phones);
        $wpdb->query("DROP TABLE " . $contacts_settings);

        delete_option("BigContact_DB_V");
    }

    function init_update($version) {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $contacts = $wpdb->prefix . 'big_contacts';
        $contacts_emails = $wpdb->prefix . 'big_contacts_emails';
        $contacts_phones = $wpdb->prefix . 'big_contacts_phones';
        $contacts_settings = $wpdb->prefix . 'big_contacts_settings';

        if ($version < 2) {
            $query = "alter table $contacts_settings
                add column calendarType VARCHAR(255) default 'date',
                add column dateFormat VARCHAR(255) default 'DD-MM dd, yy',
                add column timeFormat VARCHAR(255) default 'hh:mm tt',
                add column ampm VARCHAR(255) default 'true',
                add column showMinute VARCHAR(255) default 'true'";
            $wpdb->query($query);
            delete_site_option('BigContact_DB_V');
            update_option('BigContact_DB_V', 2);
        }

        if ($version < 3) {
            $query = "alter table $contacts_settings
                add column locale VARCHAR(255) default 'us'";
            $wpdb->query($query);
            update_option('BigContact_DB_V', 3);
        }

        if ($version < 4) {
            $query = "alter table $contacts_settings "
                    . "add column `trackingCallback` VARCHAR(255) NULL, "
                    . "add column `tracking` TEXT NULL; ";
            $wpdb->query($query);
            update_option('BigContact_DB_V', 4);
        }
        if ($version < 5) {
            $query = "alter table $contacts_settings "
                    . "add column `bcc` VARCHAR(255) NULL;";
            $wpdb->query($query);
            update_option('BigContact_DB_V', 5);
        }
    }

}

register_activation_hook(__FILE__, array('bigContact', 'installBigContact'));
register_activation_hook(__FILE__, array('bigContact', 'BigContact_addData'));
register_deactivation_hook(__FILE__, array('bigContact', 'uninstallBigContact'));

//add_action('activated_plugin','save_error');
//function save_error(){
// file_put_contents(ABSPATH. 'wp-content/uploads/error_activation.html', ob_get_contents());
//}

$mybackuper = new BigContact(); //instance of the plugin class