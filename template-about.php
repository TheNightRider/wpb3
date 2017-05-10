<?php
/*
 * Template Name: About Page
 */
get_header();
?>

<!-- *****************************************************************************************************************
         AGENCY ABOUT
         ***************************************************************************************************************** -->
<?php if (have_posts()) : ?>
<div class="container mtb">
    <div class="row">
        
        <?php while (have_posts()) : the_post(); ?>
        <div class="col-lg-6">
            <?php if(has_post_thumbnail()) {
            the_post_thumbnail( array(555,416), array("class" => "img-responsive") ); 
            } ?>
        </div>

        <div class="col-lg-6">
            <h4><?php the_title(); ?></h4>
            <?php the_content(); ?>
        </div>
        <?php endwhile; ?>
        
    </div><! --/row -->
</div><! --/container -->
<?php endif; ?>

<!-- *****************************************************************************************************************
 TEEAM MEMBERS
 ***************************************************************************************************************** -->

<?php 
$args = array(
    //Type and Status Parameters
    'post_type' => 'team',
    
    //Pagination Parameters
    'posts_per_page' => -1
);

$allTeam = new WP_Query( $args );

if ( $allTeam->have_posts() ) : ?>

<div class="container mtb">
    <div class="row centered">
        <h3 class="mb">MEET OUR TEAM</h3>
        
        <?php while ( $allTeam->have_posts() ) : $allTeam->the_post();
        
        $position = get_post_meta(get_the_ID(), '_wpb3_team_position', true); ?>

        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="he-wrap tpl6">
                <?php if (has_post_thumbnail()) {
                    $twitter = get_post_meta(get_the_ID(), '_wpb3_team_twitter', true);
                    if ( $twitter != "" && $twitter != null && strpos($twitter, "@") === false )
                        $twitter = "@" . $twitter;
                    $email = get_post_meta(get_the_ID(), '_wpb3_team_email', true);
                    
                    the_post_thumbnail('thumbnail'); ?>
                <div class="he-view">
                    <div class="bg a0" data-animate="fadeIn">
                        <h3 class="a1" data-animate="fadeInDown">Contact Me:</h3>
                        <?php if( $email != "" && $email != null) : ?>
                        <a href="mailto:<?php echo $email; ?>" class="dmbutton a2" data-animate="fadeInUp"><i class="fa fa-envelope"></i></a>
                        <?php endif; ?>
                        <?php if( $twitter != "" && $twitter != null) : ?>
                        <a href="http://twitter.com/<?php echo $twitter; ?>" class="dmbutton a2" data-animate="fadeInUp"><i class="fa fa-twitter"></i></a>
                        <?php endif; ?>
                    </div><!-- he bg -->
                </div><!-- he view -->	
                 <?php } ?>
            </div><!-- he wrap -->
               
            <h4><?php the_title(); ?></h4>
            <h5 class="ctitle"><?php echo $position; ?></h5>
            <p><?php echo strip_tags(get_the_content()); ?></p>
            <div class="hline"></div>
        </div><! --/col-lg-3 -->

        	 	
        <?php endwhile; ?>
    </div><! --/row -->
</div><! --/container -->
<?php endif; ?>

<!-- *****************************************************************************************************************
 TESTIMONIALS AND CLIENTS
 ***************************************************************************************************************** -->
<?php wpb3_testimonials_and_clients(); ?>

<?php get_footer(); ?>