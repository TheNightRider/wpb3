<?php
/*
 * Contains methods for customizing the theme customization screen
 * 
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @since MyTheme 1.0
 */

class WPB3_Customize {
    /*
     * This hooks inot 'customize_register' (available as WP 3.4) and allow you to add new 
     * sections and controls to the Theme Customize screen
     * 
     * Note: To enable instant preview, we have actually write a bit of custom javascript. 
     * See live_preview() for more
     */
    
    public static function register ( $wp_customize ) {
        /*
         * We can also change built-in settings by modifying properties. 
         * For instance, let's make some stuff use live preview JS...
         */
        $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
        $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
        $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
        $wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
        
        //Dodavanje sekcije header i opciju za pozadinu navigacije
        $wp_customize->add_section( 'wpb3_header',
                array(
                    'title' => __('WPB3 Header', 'wpb3'),
                    'priority' => 35,
                    'capability' => 'edit_theme_options',
                    'description' => __('Allows you to customize header for WPB3', 'wpb3')
                ));
        
        //Opcija
        $wp_customize->add_setting( 'navbar_background',
                array(
                    'default' => '#384452',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage'
                ));
        
        //Kontrole koje će povezati opciju sa sekcijom
        $wp_customize->add_control( new WP_Customize_Color_Control(
                $wp_customize,
                'wpb3_navbar_background',
                array(
                    'label' => __('Navbar Color', 'wpb3'),
                    'section' => 'wpb3_header',
                    'settings' => 'navbar_background',
                    'priority' => 10
                )
                ));
        
        //Dodavanje opcije za boju poveznica
        $wp_customize->add_setting( 'navbar_color',
                array(
                    'default' => '#ffffff',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage'
                )
                );
        
        //Dodavanje kontrola za boju poveznice
        $wp_customize->add_control( new WP_Customize_Color_Control(
                $wp_customize,
                'wpb3_navbar_color',
                array(
                    'label' => __('Navbar Text Color', 'wpb3'),
                    'section' => 'wpb3_header',
                    'settings' => 'navbar_color',
                    'priority' => 10
                )
                ));
        
        //Dodavanje opcije za hover na poveznici
        $wp_customize->add_setting( 'navbar_color_hover',
                array(
                    'default' => '#00b3fe',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage'
                )
                );
        
        //Dodavanje kontrola za hover na poveznici
        $wp_customize->add_control( new WP_Customize_Color_Control(
                $wp_customize,
                'wpb3_navbar_color_hover',
                array(
                    'label' => __('Navbar Text Hover Color', 'wpb3'),
                    'section' => 'wpb3_header',
                    'settings' => 'navbar_color_hover',
                    'priority' => 10
                )
                ));
        
        //Dodavanje polja za dropdown
        $wp_customize->add_setting( 'navbar_dropdown_toggle_color',
                array(
                    'default' => '#e7e7e7',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage'
                )
                );
        
        //Dodavanje kontrola za dropdown
        $wp_customize->add_control( new WP_Customize_Color_Control(
                $wp_customize,
                'wpb3_navbar_dropdown_toggle_color',
                array(
                    'label' => __('Navbar Dropdown toggle Background Color', 'wpb3'),
                    'section' => 'wpb3_header',
                    'settings' => 'navbar_dropdown_toggle_color',
                    'priority' => 10
                )
                ));
        
        //Dodavanje opcije za mijenjanje pozadine padajućih menija
        $wp_customize->add_setting( 'navbar_dropdown_color',
                array(
                    'default' => '#384452',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage'
                )
                );
        
        //Dodavanje kontrola za pozadinu padajućih menija
        $wp_customize->add_control( new WP_Customize_Color_Control(
                $wp_customize,
                'wpb3_navbar_dropdown_color',
                array(
                    'label' => __('Navbar Dropdown Background Color', 'wpb3'),
                    'section' => 'wpb3_header',
                    'settings' => 'navbar_dropdown_color',
                    'priority' => 10
                )
                ));
        
        //Dodavanje opcije za mijenjanje pozadine aktivne poveznice u padajućem meniju
        $wp_customize->add_setting( 'navbar_dropdown_hover_color',
                array(
                    'default' => '#f5f5f5',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage'
                )
                );
        
        //Dodavanje kontrola za pozadinu aktivne poveznice u padajućem meniju
        $wp_customize->add_control( new WP_Customize_Color_Control(
                $wp_customize,
                'wpb3_navbar_dropdown_hover_color',
                array(
                    'label' => __('Navbar Dropdown Background Color on Hover', 'wpb3'),
                    'section' => 'wpb3_header',
                    'settings' => 'navbar_dropdown_hover_color',
                    'priority' => 10
                )
                ));
        
        //Dodavanje sekcija za footer i opciju za pozadinu footera
        $wp_customize->add_section( 'wpb3_footer',
                array(
                    'title' => __('WPB3 Footer', 'wpb3'),
                    'priority' => 35,
                    'capability' => 'edit_theme_options',
                    'description' => __('Allows you to customize footer for WPB3', 'wpb3')
                ));
        
        //Opcije za pozadinu footera
        $wp_customize->add_setting( 'footer_background',
                array(
                    'default' => '#384452',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage'
                )
                );
        
        //Kontrole za pozadinu footera
        $wp_customize->add_control( new WP_Customize_Color_Control(
                $wp_customize,
                'wpb3_footer_background',
                array(
                    'label' => __('Footer background Color', 'wpb3'),
                    'section' => 'wpb3_footer',
                    'settings' => 'footer_background',
                    'priority' => 10
                )
                ));
        
        //Opcija za boju teksta u footeru
        $wp_customize->add_setting( 'footer_color',
                array(
                    'default' => '#bfc9d3',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage'
                )
                );
        
        //Kontrole za boju teksta u footeru
        $wp_customize->add_control( new WP_Customize_Color_Control(
                $wp_customize,
                'wpb3_footer_color',
                array(
                    'label' => __('Footer Color', 'wpb3'),
                    'section' => 'wpb3_footer',
                    'settings' => 'footer_color',
                    'priority' => 10
                )
                ));
        
        //Dodavanje opcije za heading u footeru
        $wp_customize->add_setting( 'footer_heading',
                array(
                    'default' => 'white',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage'
                )
                );
        
        //Kontrole za heading footer
        $wp_customize->add_control( new WP_Customize_Color_Control(
                $wp_customize,
                'wpb3_footer_heading',
                array(
                    'label' => __('Footer Color for headings', 'wpb3'),
                    'section' => 'wpb3_footer',
                    'settings' => 'footer_heading',
                    'priority' => 10
                )
                ));
    }
    
    /*
     * This will output the custom WordPress settings to the live theme's WP head
     * Used by hook: 'wp_head'
     * @see add_action('wp_head',$func)
     * @since MyTheme 1.0
     */
    public static function header_output() { ?>
        <!--Customizer CSS-->
        <style type="text/css">
            <?php self::generate_css('.navbar-default', 'background-color', 'navbar_background'); ?>
            <?php self::generate_css('.navbar-default .navbar-nav > li > a', 'color', 'navbar_color'); ?>
            <?php self::generate_css('.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus, .navbar-default .navbar-nav > li > a:hover', 'color', 'navbar_color'); ?>
            <?php self::generate_css('.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus', 'background-color', 'navbar_dropdown_toggle_color'); ?>
            <?php self::generate_css('.dropdown-menu', 'background-color', 'navbar_dropdown_color'); ?>
            <?php self::generate_css('.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus', 'background-color', 'navbar_dropdown_hover_color'); ?>
            <?php self::generate_css('#footerwrap', 'background-color', 'footer_background'); ?>
            <?php self::generate_css('#footerwrap p, #footerwrap i', 'color', 'footer_color'); ?>
            <?php self::generate_css('#footerwrap h4', 'color', 'footer_heading'); ?>
            <?php self::generate_css('.hline-w', 'border-color', 'footer_heading'); ?>
        </style>
        <!--/Customizer CSS-->
        <?php
    }
    
    /*
     * This outputs the javascript needed to automate the live settings preview. 
     * Also keep in mind that this function isn't necessary unless your settings 
     * are using 'transport'=>'postMessage' instead of the default 'transport' => 'refresh'
     * 
     * Used by hook: 'customize_preview_init'
     */
    public static function live_preview() {
        wp_enqueue_script(
                'wpb3-themecustomizer',
                get_template_directory_uri() . '/assets/js/theme-customizer.js',
                array( 'jquery', 'customize-preview' ),
                '',
                true
                );
    }
    
    /*
     * This will generate a line of CSS for use in header output. 
     * If the setting ($mod_name) has no defined value, the CSS will not be output.
     */
    public static function generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo =true){
        $return = '';
        $mod = get_theme_mod($mod_name);
        if ( !empty($mod) ) {
            $return = sprintf(
                    '%s { %s:%s; }',
                    $selector,
                    $style,
                    $prefix . $mod . $postfix
                    );
            if ($echo)
                echo $return;
        }
        return $return;
    }
}

add_action( 'customize_register', array( 'WPB3_Customize', 'register' ));

add_action( 'wp_head', array( 'WPB3_Customize', 'header_output' ));

add_action( 'customize_preview_init', array( 'WPB3_Customize', 'live_preview' ));