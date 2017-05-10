<?php
/*
 * Featured Portfolio Widget
 * Theme: WPB3
 * Since: 2.8.0
 */

class WPB3_Widget_Featured_Portfolio extends WP_Widget {
    
    function __construct() {
        $widget_ops = array(
            'classname' => 'widget_featuredPortfolio',
            'description' => __( 'A list of featured portfolios for WPB3', 'wpb3' )
        );
        parent::__construct('wpb3_featuredPortfolio', __('WPB3 Featured Portfolio', 'wpb3'), $widget_ops);
    }
    
    function form($instance) {
        //Defaults
        $instance = wp_parse_args((array) $instance, array( 'title' => ''));
        $title = esc_attr($instance['title']);
        $picture = isset($instance['picture']) ? (bool) $instance['picture'] : false;
        ?>
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>">
        <?php _e('Title: '); ?>
        </label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
               name="<?php echo $this->get_field_name('title'); ?>" 
               type="text" value="<?php echo $title; ?>" />
    </p>
    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('picture'); ?>"
           name="<?php echo $this->get_field_name('picture'); ?>"
           <?php checked($picture); ?> />
    <label for="<?php echo $this->get_field_id('picture'); ?>">
    <?php _e('Show thumbnails'); ?>
    </label>
    <br/>
<?php }

function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['picture'] = !empty($new_instance['picture']) ? 1 : 0;
    
    return $instance;
}

function widget($args, $instance) {
    extract($args);
    $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);
    $featured = get_option( 'wpb3_featured' );
    if (!empty($featured)) {
        echo $before_widget;
    if (!empty($title))
        echo $before_title . $title . $after_title;
    
    $showThumbs = !empty($instance['picture']) ? true : false;
    $recentPosts = new WP_Query(
     array(
        'post__in' => $featured,
         'post_type' => 'portfolio'
    )
            );
    
    if ($recentPosts->have_posts()) : ?>
    <ul class="popular-posts">
        <?php while($recentPosts->have_posts()) : $recentPosts->the_post(); ?>
        <li>
            <?php if ( has_post_thumbnail() && $showThumbs) { ?>
            <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail(array(70,70)); ?>
            </a>
            <?php } ?>
            
            <p>
                <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
                </a>
            </p>
            <em>Posted on <?php echo get_the_date(); ?></em>
        </li>
        <?php endwhile; ?>
    </ul>
    <?php 
    endif;
    echo $after_widget;
    }
}

}

function wpb3_featuredPortfolio_register() {
    register_widget('WPB3_Widget_Featured_Portfolio');
    do_action('widgets_init');
}

add_action('init', 'wpb3_featuredPortfolio_register', 1);