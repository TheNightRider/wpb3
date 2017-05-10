<?php
/*
 * WPB3 Functions
 */
require_once 'inc/wpb-navwalker.php';
require_once 'inc/widget-categories.php';
require_once 'inc/widget-posts.php';
require_once 'inc/widget-tags.php';
require_once 'inc/widget-social.php';
require_once 'inc/widget-page.php';
require_once 'inc/widget-all_posts.php';
require_once 'inc/widget-featured.php';
require_once 'inc/portfolio.php';
require_once 'inc/features.php';
require_once 'inc/faq.php';
require_once 'inc/testimonials.php';
require_once 'inc/attachments.php';
require_once 'inc/team.php';
require_once 'inc/customize.php';
require_once 'inc/settings.php';
add_theme_support('post-thumbnails');
add_image_size('post-image', 750, 353, true);

// ispod 1200px
add_image_size('post-image-md', 617, 290);

// ispod 992px
add_image_size('post-image-sm', 720, 339);

// za 480 i ispod
add_image_size('post-image-xs', 709, 334);


if (!isset($content_width))
    $content_width = 600;

/* Connecting CSS files */

function wpb3_css_files() {
    if (!is_admin()) {
        wp_enqueue_style('wpb3-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css');
        wp_enqueue_style('wpb3-fontAwesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css');
        wp_enqueue_style('wpb3-lazyLoading', get_template_directory_uri() . '/assets/css/bttrlazyloading.min.css');
        wp_enqueue_style('wpb3-style', get_template_directory_uri() . '/assets/css/style.css');
    }
}

add_action('wp_enqueue_scripts', 'wpb3_css_files');

/* Connecting JavaScript files */

function wpb3_js_files() {
    if (!is_admin()) {
        wp_enqueue_script(
                'wpb3-bootstrap-js', get_stylesheet_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '', true
        );

        wp_enqueue_script(
                'wpb3-retina-js', get_stylesheet_directory_uri() . '/assets/js/retina-1.1.0.js', array('jquery'), '', true
        );

        wp_enqueue_script(
                'wpb3-hoverdir-js', get_stylesheet_directory_uri() . '/assets/js/jquery.hoverdir.js', array('jquery'), '', true
        );

        wp_enqueue_script(
                'wpb3-hoverx-js', get_stylesheet_directory_uri() . '/assets/js/jquery.hoverex.min.js', array('jquery'), '', true
        );

        wp_enqueue_script(
                'wpb3-prettyPhoto-js', get_stylesheet_directory_uri() . '/assets/js/jquery.prettyPhoto.js', array('jquery'), '', true
        );

        wp_enqueue_script(
                'wpb3-isotope-js', get_stylesheet_directory_uri() . '/assets/js/jquery.isotope.min.js', array('jquery'), '', true
        );

        wp_enqueue_script(
                'wpb3-lazyLoading-js', get_stylesheet_directory_uri() . '/assets/js/jquery.bttrlazyloading.min.js', array('jquery'), '', true
        );

        wp_enqueue_script(
                'wpb3-custom-js', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), '', true
        );
    }
}

add_action('wp_enqueue_scripts', 'wpb3_js_files');

register_nav_menu('header-menu', 'Header Menu');

/* Fixing spacing for admin bar */

function wpb3_admin_css() {
    if (is_user_logged_in() && is_admin_bar_showing()) {
        ?>
        <style type="text/css">
            .navbar-fixed-top {
                top:32px;
            }
        </style>
        <?php
    }
}

add_action('wp_head', 'wpb3_admin_css');

/* Registring sidebar */
register_sidebar(array(
    'name' => __('Primary widget', 'wpb3'),
    'id' => 'primary-widget-area',
    'description' => 'Here is primary widget',
    'class' => '',
    'before_widget' => '',
    'after_widget' => '<div class="spacing"></div>',
    'before_title' => '<h4>',
    'after_title' => '</h4><div class="hline"></div>'
));

/* Registring widgets for footer */
register_sidebar(array(
    'name' => __('Left footer'),
    'id' => 'footer-left',
    'description' => 'Here is left footer',
    'class' => '',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h4>',
    'after_title' => '</h4><div class="hline"></div>'
));

register_sidebar(array(
    'name' => __('Middle footer'),
    'id' => 'footer-mid',
    'description' => 'Here is mid footer',
    'class' => '',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h4>',
    'after_title' => '</h4><div class="hline"></div>'
));

register_sidebar(array(
    'name' => __('Right footer'),
    'id' => 'footer-right',
    'description' => 'Here is right footer',
    'class' => '',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h4>',
    'after_title' => '</h4><div class="hline"></div>'
));

// za slike nesto
function wpb3_thumbnail_html($html, $post_id, $aid, $sizeThumb, $attr) {
    if ($sizeThumb == 'post-image') {
        $sizes = array(
            'post-image',
            'post-image-md',
            'post-image-sm',
            'post-image-xs'
        );

        $img = '<img class="bttrlazyloading" alt="' . get_the_title() . '" ';
        $sizeBttr = '';
        $width = '';
        $height = '';
        $aid = (!$aid ) ? get_post_thumbnail_id() : $aid;

        foreach ($sizes as $size) {
            $url = wp_get_attachment_image_src($aid, $size);
            switch ($size) {
                case 'post-image':
                    $sizeBttr = 'lg';
                    $width = '750';
                    $height = '353';
                    break;
                case 'post-image-md':
                    $sizeBttr = 'md';
                    $width = '617';
                    $height = '290';
                    break;
                case 'post-image-sm':
                    $sizeBttr = 'sm';
                    $width = '720';
                    $height = '339';
                    break;
                default:
                    $sizeBttr = 'xs';
                    $width = '709';
                    $height = '334';
                    break;
            }

            $img .= ' data-bttrlazyloading-' . $sizeBttr . '-src="' . $url[0] . '" ';
            $img .= ' data-bttrlazyloading-' . $sizeBttr . '-width="' . $width . '" ';
            $img .= ' data-bttrlazyloading-' . $sizeBttr . '-height="' . $height . '" ';
        }
        $img .= ' />';
        return $img;
    }
    return $html;
}

add_filter('post_thumbnail_html', 'wpb3_thumbnail_html', 10, 5);

/* For using media object in CSS */

function wpb3_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ('div' == $args['style']) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
    ?>

    <<?php echo $tag; ?>
    <?php comment_class(empty($args['has_children']) ? 'media well' : 'media well parent' ) ?>
    id="comment-<?php comment_ID(); ?>">

    <?php /* Prikaz avatara */
    if ($args['avatar_size'] != 0) {
        ?>
        <a href="<?php get_comment_author_link(); ?>"
           class="pull-left media-object">
        <?php echo get_avatar($comment, $args['avatar_size']); ?>
        </a>
    <?php }
    if ('div' != $args['style']) :
        ?>
        <div id="div-comment-<?php comment_ID() ?>" class="media-body">
    <?php endif; ?>
        <div class="comment-author vcard">
    <?php printf(__('<cite class="fn">%s</cite> <span class="says">says: </span>'), get_comment_author_link());
    ?>
        </div>

        <div class="comment-meta small commentmetadata">
            <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
                <span class="fa fa-calendar"></span>
    <?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()); ?>
            </a>
    <?php edit_comment_link('(Edit)', ' ', ''); ?>
        </div>
    <?php comment_text(); ?>

        <div class="reply">
    <?php
    comment_reply_link(array_merge($args, array(
        'before' => '<i class="fa fa-reply"></i>',
        'add_below' => $add_below,
        'depth' => $depth,
        'max_depth' => $args['max_depth']
    )));
    ?>
        </div>
        <br/>
            <?php if ('div' != $args['style']) : ?>
        </div>
    <?php
    endif;
}

/*
 * Za prikaz Custom Post Type kao npr http://localhost/portfolio
 */
add_action('init', 'portfolio_rewrite');

function portfolio_rewrite() {
    global $wp_rewrite;
    $wp_rewrite->add_permastruct('typename', 'typename/%year%/%postname%/', true, 1);
    add_rewrite_rule('typename/([0-9]{4})/(.+)/?$', 'index.php?typename=$matches[2]', 'top');
    $wp_rewrite->flush_rules();
}

/*
 * Funkcija koju je napisao Philipg Newcomer, nešto za slike :)
 */

function wpb3_get_id_from_image_url($attachment_url = '') {
    global $wpdb;
    $attachment_id = false;

    //ako nema url, return
    if ('' == $attachment_url)
        return;

    //Uzmi (get) upload foldere
    $upload_dir_paths = wp_upload_dir();

    //Provjera da li upload folder postoji u attachment URL
    if (false !== strpos($attachment_url, $upload_dir_paths['baseurl'])) {
        //ako je URL od auto-generisanog thumbnail-a, traži URL originalne slike
        $attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);


        //briši upload path folder iz attachment URL
        $attachment_url = str_replace($upload_dir_paths['baseurl'] . '/', '', $attachment_url);
        //echo $attachment_url;
        //echo $upload_dir_paths['url'];
        //Pokreni custom database query za dobijanje attachment ID iz modifikovanog attachment URL
        $attachment_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
    }

    return $attachment_id;
}

function wpb3_generate_portfolio_pictures($image_url) {
    $attID = wpb3_get_id_from_image_url($image_url);
    $img = '<img class="bttrlazyloading img-responsive" alt="' . get_the_title() . '" ';

    if (!$attID)
        return;
    if (empty($attID))
        return;

    $sizeBttr = "";
    $width = "";
    $height = "";

    $sizes = array('image-singleProject', 'post-image-sm', 'post-image-xs');

    foreach ($sizes as $size) {
        $url = wp_get_attachment_image_src($attID, $size);
        switch ($size) {
            case 'image-singleProject':
                $sizeBttr = 'lg';
                $width = '945';
                $height = '443';
                $img .= ' data-bttrlazyloading-md-src="' . $url[0] . '" ';
                $img .= ' data-bttrlazyloading-md-width="' . $width . '" ';
                $img .= ' data-bttrlazyloading-md-height="' . $height . '" ';
                break;
            case 'post-image-sm':
                $sizeBttr = 'sm';
                $width = '720';
                $height = '339';
                break;
            default:
                $sizeBttr = 'xs';
                $width = '709';
                $height = '334';
                break;
        }
        $img .= ' data-bttrlazyloading-' . $sizeBttr . '-src="' . $url[0] . '" ';
        $img .= ' data-bttrlazyloading-' . $sizeBttr . '-width="' . $width . '" ';
        $img .= ' data-bttrlazyloading-' . $sizeBttr . '-height="' . $height . '" ';
    }

    $img .= ' />';
    return $img;
}

//registracija novih widgeta
register_sidebar(array(
    'name' => __('Middle Left'),
    'id' => 'middle-left',
    'description' => '',
    'class' => '',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h4>',
    'after_title' => '</h4><div class="hline"></div>'
));

register_sidebar(array(
    'name' => __('Middle Mid'),
    'id' => 'middle-mid',
    'description' => '',
    'class' => '',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h4>',
    'after_title' => '</h4><div class="hline"></div>'
));

register_sidebar(array(
    'name' => __('Middle Right'),
    'id' => 'middle-right',
    'description' => '',
    'class' => '',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h4>',
    'after_title' => '</h4><div class="hline"></div>'
));

//Ispis testimonialsa
function wpb3_single_testimonial($testimonial) {
    ?>
    <p><?php echo strip_tags($testimonial->post_content); ?></p>
    <h4><br/><?php echo $testimonial->post_title; ?></h4>
    <?php
    $post_id = $testimonial->ID;
    $clientPosition = get_post_meta($post_id, '_wpb3_testimonial_position', true);
    $clientWeb = get_post_meta($post_id, '_wpb3_testimonial_web', true);
    $client = "";

    $client .= $clientPosition;

    if ($clientPosition != "" && $clientWeb != "")
        $client .= " - ";
    $client .= $clientWeb;
    ?>
    <p><?php echo $client; ?></p>
    <?php
}

function wpb3_testimonials_and_clients(){
    
    $showThem = get_option( 'wpb3_field' );
    if($showThem == "1") {
    
/*
 * The WordPress Query Class
 * @link http://codex.wordpress.org/Function_Reference/WP_Query
 */

$args = array(
    
    'post_type' => 'testimonial',
    'posts_per_page' => -1,
);

$allTestimonials = get_posts($args);

if (!empty($allTestimonials)) {
    ?>

    <div id="twrap">
        <div class="container centered">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <i class="fa fa-comment-o"></i>
                    <?php
                    if (count($allTestimonials) == 1)
                        wpb3_single_testimonial($allTestimonials[0]);

                    else {
                        ?>
                        <div id="carousel-testimonials" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                $first = true;
                                foreach ($allTestimonials as $testimonial) {
                                    ?>
                                    <div class="item <?php if ($first) echo active; ?>">
                                        <?php wpb3_single_testimonial($testimonial); ?>
                                    </div>
                                    <?php
                                    $first = false;
                                }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div><! --/row -->
        </div><! --/container -->
    </div><! --/twrap -->
<?php }

/*
 * The WordPress Query Class
 * @link http://codex.wordpress.org/Function_Reference/WP_Query
 */

$klijentiSlikeArgs = array(
    //Type and Status Parameters
    'post_type' => 'attachment',
    'posts_per_page' => -1,
    'post_status' => 'inherit',
    
    //custom field parameters
    'meta_key' => '_wpb3_client_image',
    'meta_value' => "1",
    'meta_compare' => '='
);

$klijentiSlike = new WP_Query( $klijentiSlikeArgs );

if ( $klijentiSlike->have_posts() ) { ?>

<div id="cwrap">
    <div class="container">
        <div class="row centered">
            <h3>OUR CLIENTS</h3>
            <?php while ( $klijentiSlike->have_posts() ) : $klijentiSlike->the_post(); ?>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <img src="<?php echo get_the_guid(); ?>" class="img-responsive">
            </div>
            <?php endwhile; ?>
            
        </div><! --/row -->
    </div><! --/container -->
</div><! --/cwrap -->
<?php }
    }
}

//Registracija widgeta za sidebar u contact page
register_sidebar(array(
    'name' => __('Contact - Sidebar'),
    'id' => 'contact-sidebar',
    'description' => 'Here is sidebar for Contact page',
    'class' => '',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h4>',
    'after_title' => '</h4><div class="hline"></div>'
));

//Za ajax vote
add_action( 'wp_ajax_vote_up', 'wpb3_vote_up');
add_action( 'wp_ajax_vote_down', 'wpb3_vote_down');

function wpb3_vote_up(){
    $post_id = $_GET['post_id'];
    $user_id = $_GET['user_id'];
    
    $votes = get_post_meta($post_id, '_wpb3_vote', true);
    $userVotes = get_post_meta($post_id, '_wpb3_uservote', true);
    
    if ($userVotes == null || $userVotes == "") $userVotes = array();
    $found = array_search($user_id, $userVotes);
    if (is_array($userVotes) && $found === false) $userVotes[] = $user_id;
    
update_post_meta($post_id, '_wpb3_uservote', $userVotes);

if ($votes == "" || $votes == null) $votes = 0;
$votes++;

update_post_meta($post_id, '_wpb3_vote', $votes);

echo $votes;
die();
}

function wpb3_vote_down(){
    $post_id = $_GET['post_id'];
    $user_id = $_GET['user_id'];
    
    $votes = get_post_meta($post_id, '_wpb3_vote', true);
    $userVotes = get_post_meta($post_id, '_wpb3_uservote', true);
    
    if (is_array($userVotes)){
        $key = array_search($user_id, $userVotes);
        if ($key !== false) unset($userVotes[$key]);
    }
    
update_post_meta($post_id, '_wpb3_uservote', $userVotes);

if ($votes == "" || $votes == null) $votes = 0;
if ($votes > 0) $votes--;

update_post_meta($post_id, '_wpb3_vote', $votes);

echo $votes;
die();
}
?>