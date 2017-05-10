<?php
/*
 * Recent Posts Widget
 * Theme: WPB3
 * Since: 2.8.0
 */

class WPB3_Widget_All_Posts extends WP_Widget {
    
    function __construct() {
        $widget_ops = array(
            'classname' => 'widget_allPosts',
            'description' => __( 'A list of recent Posts for a post_type in WPB3', 'wpb3' )
        );
        parent::__construct('wpb3_allPosts', __('WPB3 Recent Posts by Post Type', 'wpb3'), $widget_ops);
    }
    
    function form($instance) {
        //Defaults
        $instance = wp_parse_args((array) $instance, array( 'title' => '' ));
        $title = esc_attr($instance['title']);
        $post_type = esc_attr( $instance['postType'] );
        $allPostTypes = get_post_types();
        ?>
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>">
        <?php _e('Title: '); ?>
        </label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
               name="<?php echo $this->get_field_name('title'); ?>" 
               type="text" value="<?php echo $title; ?>" />
    </p>
    <label for="<?php echo $this->get_field_id('postType'); ?>">
    <?php _e('Select Post Type'); ?>
    </label><br/>
    <select class="widefat" id="<?php echo $this->get_field_id('postType'); ?>"
            name="<?php echo $this->get_field_name('postType'); ?>">
        <option value="0">None</option>
        <?php
        foreach ( $allPostTypes as $postType ) {
            echo '<option value="' . $postType . '"' . checked($post_type, $postType, false) . '>' . $postType . '</option>';
        } ?>
    </select>
    
<?php }

function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['postType'] = $new_instance['postType'];
    
    return $instance;
}

function widget($args, $instance) {
    extract($args);
    $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);
    $post_type = $instance['postType'];
    echo $before_widget;
    
    if (!empty($title))
        echo $before_title . $title . $after_title;
    
    //$showThumbs = !empty($instance['picture']) ? true : false;
    $recentPosts = new WP_Query(
    apply_filters( 'wpb3_widget_all_posts_args', array(
        'posts_per_page' => 5,
        'no_found_rows' => true,
        'post_status' => 'publish',
        'post_type' => $post_type,
        'ignore_sticky_posts' => true
    ))
            );
    
    //echo $after_widget;
    
    if ($recentPosts->have_posts()) : while($recentPosts->have_posts()) : $recentPosts->the_post(); ?>
            <p>
                <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
                </a>
            </p>
        <?php endwhile; endif;
    echo $after_widget;
}

}

function wpb3_allPosts_register() {
    register_widget('WPB3_Widget_All_Posts');
    do_action('widgets_init');
}

add_action('init', 'wpb3_allPosts_register', 1);