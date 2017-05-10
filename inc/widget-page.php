<?php
/*
 * One Page Widget
 * Theme: WPB3
 * @since 2.8.0
 */

class WPB3_Widget_One_Page extends WP_Widget {
    function __construct() {
        $widget_ops = array(
            'classname' => 'widget_onePage',
            'description' => __( 'List a Page in WPB3', 'wpb3' )
        );
        parent::__construct('wpb3_onePage', __('WPB3 One Page', 'wpb3'), $widget_ops);
    }
    
    function widget($args, $instance) {
        extract($args);
        $currentPage = new WP_Query( 'page_id=' . $instance["page"] );
        
        //The Loop
        if ( $currentPage->have_posts() ) {
            echo $before_widget;
            
            while ($currentPage->have_posts()) : $currentPage->the_post();
            echo $before_title;
            echo the_title();
            echo $after_title;
            echo "<br/>";
            
            //Fetch post content
            $content = get_post_field( 'post_content', get_the_ID() );
            
            //Get content parts
            $content_parts = get_extended( $content );
            
            //Output part <!--more--> tag
            echo $content_parts['main'];
            
            if ($content_parts['extended'] != "" ){
                echo '<p><br><a class="btn btn-theme" href="' . get_the_permalink() . '">More Info</a></p>';
            }
            
            endwhile;
            echo $after_widget;
        }
        wp_reset_postdata();
    }
    
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['page'] = !empty($new_instance['page']) ? $new_instance['page'] : 0;
        
        return $instance;
    }
    
    function form($instance) {
        //Defaults 
        $instance = wp_parse_args( (array) $instance, array( 'page' => 0) );
        $currentPage = esc_attr( $instance['page'] );
        $getAllPages = get_posts(array(
            'posts_per_page' => -1,
            'post_type' => 'page'
            )); ?>
<p>
    <label for="<?php echo $this->get_field_id('page'); ?>">
        <?php _e('Page: '); ?>
        </label>
        <select class="widefat" id="<?php echo $this->get_field_id('page'); ?>" 
               name="<?php echo $this->get_field_name('page'); ?>">
            <option value="0" <?php checked(0, $currentPage); ?>>None</option>
            <?php foreach ($getAllPages as $page) {
                echo '<option value="' . $page->ID . '" ' 
                        . checked($page->ID, $currentPage, false) . ' >' . $page->post_title . '</option>'; 
            } ?>
        </select>
</p>
<?php
    }
}

function wpb3_onePage_register() {
    register_widget('WPB3_Widget_One_Page');
    do_action('widgets_init');
}

add_action('init', 'wpb3_onePage_register', 1);