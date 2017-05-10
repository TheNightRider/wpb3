<?php
/*
 * Template Name: Home page
 */

get_header();
?>

<div id="headerwrap">
    <div class="container">
        <div class="row">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="col-lg-8 col-lg-offset-2">
                        <?php the_content(); ?>
                    </div>
                    <div class="col-lg-8 col-lg-offset-2 himg">
                        <?php
                        if (has_post_thumbnail()) :
                            the_post_thumbnail();
                        endif;
                        ?>
                    </div>
                    <?php
                endwhile;
            endif;
            ?>
        </div>
    </div>
</div>

<?php
/*
 * The WordPress Query Class
 * @link http://codex.wordpress.org/Function_Reference/WP_Query
 */

$args = array(
    //Choose ^ 'any' or from below, since 'any' cannot be in array
    'post_type' => array('feature'),
    'post_status' => array('publish'),
    //Order or Orderby Parameters
    'order' => 'ASC',
    'orderby' => 'meta_value_num',
    //Pagination Parameters
    'posts_per_page' => -1,
    //Custom Field Paramteters
    'meta_key' => '_wpb3_feature_order',
    'meta_query' => array(
        array(
            'key' => '_wpb3_feature_show',
            'value' => 'Yes',
            'type' => 'CHAR',
            'compare' => '='
        )
    )
);

$services = new WP_Query($args);

if ($services->have_posts()) :
    ?>

    <!-- *****************************************************************************************************************
             SERVICE LOGOS
    ***************************************************************************************************************** -->
    <div id="service">
        <div class="container">
            <div class="row centered">
                <?php
                while ($services->have_posts()) : $services->the_post();
                    $featureIcon = get_post_meta(get_the_ID(), '_wpb3_feature_icon', true);
                    ?>

                    <div class="col-md-4">
                        <?php if ($featureIcon != null && $featureIcon != "") : ?>
                            <i class="fa <?php echo $featureIcon; ?>"></i>
                        <?php endif; ?>
                        <h4><?php the_title(); ?></h4>
                        <?php the_content(''); ?>
                        <p><br/><a href="<?php the_permalink(); ?>" class="btn btn-theme">
                                <?php _e('More Info', 'wpb3'); ?>
                            </a></p>
                    </div>

                <?php endwhile; ?>
            </div>
        </div><! --/container -->
    </div><! --/service -->
<?php endif; ?>
<!-- *****************************************************************************************************************
        Ispis projekta
***************************************************************************************************************** -->

<?php
//ispis projekta
$projectsArgs = array(
    'post_type' => 'portfolio',
    'post_status' => 'publish',
    'posts_per_page' => 10
);
$projects = new WP_Query($projectsArgs);

if ($projects->have_posts()) :
    ?>
    <div id="portfoliowrap">
        <h3>LATEST WORK</h3>
        <div class="portfolio-centered">
            <div class="recentitems portfolio">
                <?php while ($projects->have_posts()) : $projects->the_post(); ?>

                    <div class="portfolio-item">
                        <div class="he-wrap tpl6">
                            <?php
                            $image = "";
                            if (has_post_thumbnail()) :
                                the_post_thumbnail('image-thumbProject');
                                $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
                            endif;
                            ?>
                            <div class="he-view">
                                <div class="bg a0" data-animate="fadeIn">
                                    <h3 class="a1" data-animate="fadeInDown"><?php the_title(); ?></h3>
                                    <?php if ($image != "") { ?>
                                        <a data-rel="prettyPhoto"
                                           href="<?php echo $image[0]; ?>"
                                           class="dmbutton a2" data-animate="fadeInUp">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    <?php } ?>
                                    <a href="<?php the_permalink(); ?>"
                                       class="dmbutton a2" data-animate="fadeInUp">
                                        <i class="fa fa-link"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
                ;
                ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- *****************************************************************************************************************
         MIDDLE CONTENT
***************************************************************************************************************** -->

<div class="container mtb">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-1">
            <?php
            if (is_active_sidebar('middle-left'))
                dynamic_sidebar('middle-left');
            ?>
        </div>

        <div class="col-lg-3">
            <?php
            if (is_active_sidebar('middle-mid'))
                dynamic_sidebar('middle-mid');
            ?>
        </div>

        <div class="col-lg-3">
            <?php
            if (is_active_sidebar('middle-right'))
                dynamic_sidebar('middle-right');
            ?>
        </div>

    </div><! --/row -->
</div><! --/container -->

<!-- *****************************************************************************************************************
    TESTIMONIALS AND OUR CLIENTS
***************************************************************************************************************** -->


<?php wpb3_testimonials_and_clients(); ?>



<?php get_footer(); ?>