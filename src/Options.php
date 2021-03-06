<?php
namespace giorgiosaud\slickwp;

class Options
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action('admin_menu', array( $this, 'addPluginPage'));
        add_action('admin_init', array( $this, 'pageInit' ));
    }

    /**
     * Add options page
     */
    public function addPluginPage()
    {
        add_menu_page(
            'Slick Settings', // Page Title
            'Slick Wp', // Menu Title
            'manage_options', //Capability
            'slick_wp_plugin', // Menu Slug
            array( $this, 'createAdminPage' ), // callable function,
            '',//Icon URL
            null //Position
        );
        add_submenu_page(
            'slick_wp_plugin', //Parent Slug
            'Slick Wp Settings', // Page Title
            'Slick Wp Main Settings', // Menu Title
            'manage_options', //capability
            'slick_wp_plugin', // menu slug
            array( $this, 'createAdminPage' ) // Callable
        );
        add_submenu_page(
            'slick_wp_plugin', //Parent Slug
            'Slick Wp Webhook Settings',// Page Title
            'Slick Wp Webhook Setup', // Menu Title
            'manage_options',//capability
            'slick_wp_plugin_webhook',// menu slug
            array( $this, 'createWebhookAdminPage' ) // Callable
        );
    }
    /**
     * Options page callback
     */
    public function createWebhookAdminPage()
    {
        // Set class property
        $this->options = get_option('slick_wp_plugin_webhook');
        ?>
        <div class="wrap">
            <h1>My Webhook Settings</h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields('slick_wp_plugin_webhhok_settings');
                do_settings_sections('slick_wp_plugin_webhook');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function pageInit()
    {
        register_setting(
            'slick_wp_plugin_webhhok_settings', // Option group
            'slick_wp_plugin_webhook', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'slick_wp_plugin_webhook_settings', // ID
            'Giorgio Plugin My Webhook Settings', // Title
            array( $this, 'printSectionInfo' ), // Callback
            'slick_wp_plugin_webhook' // Page
        );
        add_settings_field(
            'secret', //ID
            'Secret', //Title
            array( $this, 'webhookCallback' ), // callback
            'slick_wp_plugin_webhook', //Page
            'slick_wp_plugin_webhook_settings' //Section
        );
        register_setting(
            'slick_wp_plugin_general_settings', // Option group
            'slick_wp_plugin_general', // Option name
            array( $this, 'sanitize_general_settings' ) // Sanitize
        );
        add_settings_section(
            'slick_wp_plugin_general_settings', // ID
            'Slick Settings', // Title
            array( $this, 'printSectionSlick' ), // Callback
            'slick_wp_plugin_general' // Page
        );
        add_settings_field(
            'custom_posts', //ID
            __('Select Custom Post To Use','slick_wp_plugin'), //Title
            array( $this, 'askForPosts' ), // callback
            'slick_wp_plugin_general', //Page
            'slick_wp_plugin_general_settings' //Section
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize($input)
    {
        $new_input = array();
        // if( isset( $input['id_number'] ) )
        //  $new_input['id_number'] = absint( $input['id_number'] );

        if (isset($input['secret'])) {
            $new_input['secret'] = sanitize_text_field($input['secret']);
        }

        return $new_input;
    }



    public function webhookCallback()
    {
        printf(
            '<input type="text" id="secret" name="slick_wp_plugin_webhook[secret]" value="%s" />',
            isset($this->options['secret']) ? esc_attr($this->options['secret']) : ''
        );
    }


    public function sanitize_general_settings($input){
        $new_input = array();
        if (isset($input['custom_posts'])) {
            $new_input['custom_posts']=array();
            foreach ($input['custom_posts'] as $custom_post) {
                $sanitized=sanitize_text_field($custom_post);
                array_push($new_input['custom_posts'], $sanitized);
            }
        }
        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function printSectionInfo()
    {
        _e('Enter your Webhook Settings below:', 'slick_wp_plugin');
    }
    /** 
     * Print the Section text
     */
    public function printSectionSlick()
    {
        _e('Enter your Slick Settings below:', 'slick_wp_plugin');
    }

    
    public function askForPosts(){
        $args = array(
            'public'   => true
        );
        $output = 'objects'; // names or objects, note names is the default
        $operator = 'and'; // 'and' or 'or'

        $post_types = get_post_types( $args, $output, $operator ); 

        echo '<select name="slick_wp_plugin_general[custom_posts][]" multiple="multiple">';
        foreach ( $post_types as $post_type ) {
            $selected=(in_array($post_type->name,$this->options['custom_posts']))?'selected':'';
            printf('<option value="%s" %s>%s</option>',$post_type->name,$selected,$post_type->name);
        }
        echo '</select>';
        foreach ($this->options['custom_posts'] as $custom_post) {
        printf(
            '<div> %s </div>',
            $custom_post
        );    
        }
        

    }
    /**
     * Options page callback
     */
    public function createAdminPage()
    {
        // Set class property
        $this->options = get_option('slick_wp_plugin_general');
        ?>
        <div class="wrap">
            <h1>My Settings</h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields('slick_wp_plugin_general_settings');
                do_settings_sections('slick_wp_plugin_general');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}
