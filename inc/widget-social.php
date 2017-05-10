<?php
/*
 * Social Links Widget
 * Theme: WPB3
 * @since 2.8.0
 */

class WPB3_Widget_Social_Links extends WP_Widget {
    function __construct() {
        $widget_ops = array(
            'classname' => 'widget_socialLinks',
            'description' => __('A list of social links for WPB3', 'wpb3')
        );
        parent::__construct('wpb3_socialLinks', __('WPB3 Social Links', 'wpb3'), $widget_ops);
    }
    
        function form($instance) {
        //Defaults
        $instance = wp_parse_args( 
                (array) $instance, 
                array (
                    'title' => '',
                    'dribbble' => '',
                    'facebook' => '',
                    'twitter' => '',
                    'instagram' => '',
                    'thumblr' => ''
                    ));
        $title = esc_attr($instance['title']);
        $dribbble = esc_attr($instance['dribbble']);
        $facebook = esc_attr($instance['facebook']);
        $twitter = esc_attr($instance['twitter']);
        $instagram = esc_attr($instance['instagram']);
        $thumblr = esc_attr($instance['thumblr']);
        ?>

<p>
    <label for="<?php echo $this->get_field_id('title'); ?>">
    <?php _e('Title: '); ?>
    </label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
           name="<?php echo $this->get_field_name('title'); ?>"
           type="text" value="<?php echo $title; ?>" />
</p>

<p>
    <strong>Social Links: </strong>
</p>

<p>
    <label for="<?php echo $this->get_field_id('dribbble'); ?>">
    <?php _e('Dribbble: '); ?>
    </label>
    <input class="widefat" id="<?php echo $this->get_field_id('dribbble'); ?>"
           name="<?php echo $this->get_field_name('dribbble'); ?>"
           type="text" value="<?php echo $dribbble; ?>" />
</p>

<p>
    <label for="<?php echo $this->get_field_id('facebook'); ?>">
    <?php _e('Facebook: '); ?>
    </label>
    <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>"
           name="<?php echo $this->get_field_name('facebook'); ?>"
           type="text" value="<?php echo $facebook; ?>" />
</p>

<p>
    <label for="<?php echo $this->get_field_id('twitter'); ?>">
    <?php _e('Twitter: '); ?>
    </label>
    <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>"
           name="<?php echo $this->get_field_name('twitter'); ?>"
           type="text" value="<?php echo $twitter; ?>" />
</p>

<p>
    <label for="<?php echo $this->get_field_id('instagram'); ?>">
    <?php _e('Instagram: '); ?>
    </label>
    <input class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>"
           name="<?php echo $this->get_field_name('instagram'); ?>"
           type="text" value="<?php echo $instagram; ?>" />
</p>

<p>
    <label for="<?php echo $this->get_field_id('thumblr'); ?>">
    <?php _e('Thumblr: '); ?>
    </label>
    <input class="widefat" id="<?php echo $this->get_field_id('thumblr'); ?>"
           name="<?php echo $this->get_field_name('thumblr'); ?>"
           type="text" value="<?php echo $thumblr; ?>" />
</p>
<?php
        }
        
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['dribbble'] = strip_tags($new_instance['dribbble']);
        $instance['facebook'] = strip_tags($new_instance['facebook']);
        $instance['twitter'] = strip_tags($new_instance['twitter']);
        $instance['instagram'] = strip_tags($new_instance['instagram']);
        $instance['thumblr'] = strip_tags($new_instance['thumblr']);
        return $instance;
    }
    
    function widget($args, $instance) {
        extract($args);
        
        $dribbble = empty($instance['dribbble']) ? '' : $instance['dribbble'];
        $facebook = empty($instance['facebook']) ? '' : $instance['facebook'];
        $twitter = empty($instance['twitter']) ? '' : $instance['twitter'];
        $instagram = empty($instance['instagram']) ? '' : $instance['instagram'];
        $thumblr = empty($instance['thumblr']) ? '' : $instance['thumblr'];
        
        /* Neki filter bejagi */
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Social Links') : $instance['title'], $instance, $this->id_base);
        if (!empty($title))
            echo $before_title . $title . $after_title;
        
        $html = '<p>';
        if ($dribbble != '')
            $html .= '<a href="' . $dribbble . '"><i class="fa fa-dribbble"></i></a>';
        if ($facebook != '')
            $html .= '<a href="' . $facebook . '"><i class="fa fa-facebook"></i></a>';
        if ($twitter != '')
            $html .= '<a href="' . $twitter . '"><i class="fa fa-twitter"></i></a>';
        if ($instagram != '')
            $html .= '<a href="' . $instagram . '"><i class="fa fa-instagram"></i></a>';
        if ($thumblr != '')
            $html .= '<a href="' . $thumblr . '"><i class="fa fa-tumblr"></i></a>';
        
        $html .= '</p>';
        echo $html;
        echo $after_widget;
    }
}

function wpb3_socialLinks_register() {
    register_widget('WPB3_Widget_Social_Links');
    do_action('widgets_init');
}

add_action('init', 'wpb3_socialLinks_register', 1);