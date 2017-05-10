<?php
/*
 * Template Name: Portfolio Home
 */
get_header();

$args = array(
    'post_type' => 'portfolio',
    'post_status' => 'publish'
);

$projects = new WP_Query( $args ); ?>

<?php
//if ( $projects->have_posts() ) : while ( $projects->have_posts() ) : $projects->the_post(); ?>
<?php if (have_posts()) : the_post(); ?>
<div class="container mtb">
    <div class="row">
        <!-- BLOG POSTS LIST -->
        <div class="col-lg-8 col-lg-offset-2 centered">
            <h2><?php echo strip_tags(get_the_content()); ?></h2>
            <br />
            <div class="hline"></div>
            
        </div><!-- /col-lg-8 -->
        <?php $taxonomies = get_terms(array('portfolio_category', 'portfolio_tag')); ?>
        <nav class="portfolio-filter centered col-lg-8 col-lg-offset-2">
            <ul class="nav nav-pills">
                <li class="active"><a data-filter="*">All </a></li>
                <?php 
                foreach ($taxonomies as $taxonomy) {
                    echo '<li><a data-filter=".' . $taxonomy->slug . '">' . $taxonomy->name . '</a></li>';
                } ?>
                
            </ul>
        </nav>
        
    </div><!-- /row -->
</div><!-- /container mtb -->
<?php endif; ?>
<?php //endwhile; endif; ?>

<?php //ispis projekta
if ( $projects->have_posts() ) : ?>
<div id="portfoliowrap">
    <div class="portfolio-centered">
        <div class="recentitems portfolio">
            <?php while ( $projects->have_posts() ) : $projects->the_post(); ?>
            <?php 
            $categories = wp_get_object_terms(get_the_ID(), 'portfolio_category');
            $tags = wp_get_object_terms(get_the_ID(), 'portfolio_tag');
            
            $kategorije = "";
            foreach($categories as $category) {
                $kategorije .= " " . $category->slug . " ";
            } ?>
            
            <div class="portfolio-item <?php echo $kategorije; ?>">
                <div class="he-wrap tpl6">
                    <?php $image = "";
                    if ( has_post_thumbnail() ) :
                    the_post_thumbnail('image-thumbProject');
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
                    endif; ?>
                    <div class="he-view">
                        <div class="bg a0" data-animate="fadeIn">
                            <h3 class="a1" data-animate="fadeInDown"><?php the_title(); ?></h3>
                            <?php if($image != "") { ?>
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
            <?php endwhile;; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php get_footer(); ?>