<?php

class WPB3_Widget_Popular_Tags extends WP_Widget {
    
    function __construct() {
        $widget_ops = array(
            'classname' => 'widget_popularTags',
            'description' => __('A list of popular Tags for WPB3', 'wpb3')
        );
        
        parent::__construct('wpb3_popularTags', __('WPB3 Popular Tags', 'wpb3'), $widget_ops);
    }
    
    function form($instance) {
        //Defaults
        $instance = wp_parse_args( (array) $instance, array ('title' => ''));
        $title = esc_attr($instance['title']); ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
            <?php _e('Title: '); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>"
                   type="text" value="<?php echo $title; ?>" />
        </p> <?php
    }
    
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
    
    function widget($args, $instance) {
        extract($args);
        
        if ( !empty($instance['title'])) 
            $title = $instance['title'];
        else
            $title = _('Popular Tags', 'wpb3');
        
        $title = apply_filters(
                'widget_title',
                $title, $instance,
                $this->id_base
                );
        
        echo $before_widget;
        if ( !empty($title) )
            echo $before_title . $title . $after_title;
        
        $tags = get_tags(array(
            'orderby' => 'count',
            'order' => 'DESC',
            'number' => 14
        ));
        
        $html = "";
        if (!empty($tags)){
            $html = "<p>";
            foreach ( $tags as $tag ) {
                $tag_link = get_tag_link($tag->term_id);
                $html .= "<a href=\"$tag_link\" title=\"$tag->name Tag\"";
                $html .= " role=\"button\" class=\"$tag->slug btn btn-theme\">";
                $html .= "$tag->name</a>";
            }
            $html .= "</p>";
        }
        echo $html;
        echo $after_widget;
    }
}

function wpb3_popularTags_register() {
    register_widget('WPB3_Widget_Popular_Tags');
    do_action('widgets_init');
}

add_action('init', 'wpb3_popularTags_register', 1);