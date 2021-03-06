<?php 
/*
 * Template Name: No sidebar
 */

get_header(); ?>

<div class="container mtb">
    <div class="row">

        <! -- BLOG POSTS LIST -->
        <div class="col-md-12">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <! -- Blog Post 1 -->
            <?php
            if ( has_post_thumbnail() ) {
                echo '<p>';
                the_post_thumbnail('post-image', array('class' => 'img-responsive'));
                echo '</p>';
            }
            ?>
            <a href="<?php the_permalink(); ?>"><h3 class="ctitle"><?php the_title(); ?></h3></a>
            
        <?php the_content(); ?>

        <div class="spacing"></div>
            
        <?php endwhile; else: ?>
        <p><?php _e('No posts'); ?></p>
        <?php endif; ?>
        
        <div class="spacing"></div>
        <h6>SHARE:</h6>
        <p class="share">
            <a href="<?php the_permalink(); ?>" 
               title="<?php the_title(); ?>"
               onclick="share_facebook_post(this); return false;">
                <i class="fa fa-facebook"></i></a>
                <a href="<?php the_permalink; ?>" 
                   onclick="share_twitter_post(this); return false;"
                   title="<?php the_title(); ?>">
                    <i class="fa fa-twitter"></i></a>
            <a href="<?php the_permalink(); ?>" 
               onclick="share_google_post(this); return false;"><i class="fa fa-google-plus"></i></a>
               <a href="<?php the_permalink(); ?>" 
                  title="<?php the_title(); ?>"
                  onclick="share_tumblr_post(this); return false;"><i class="fa fa-tumblr"></i></a>		 		
        </p>
        </div><! --/col-lg-8 -->
        
    </div><! --/row -->
</div><! --/container -->

<?php get_footer(); ?>