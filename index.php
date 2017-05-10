<?php get_header(); ?>

<div class="container mtb">
    <div class="row">

        <! -- BLOG POSTS LIST -->
        <div class="col-md-8">
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
            <p><csmall><?php echo get_the_date(); ?></csmall> | <csmall2>By: <?php the_author(); ?> - <?php comments_number(); ?></csmall2></p>
        <?php the_content('Read More'); ?>
        <?php if (!is_singular()) echo '<div class="hline"></div>'; ?>

        <div class="spacing"></div>
            
        <?php endwhile; else: ?>
        <p><?php _e('No posts'); ?></p>
        <?php endif; ?>
        </div><! --/col-lg-8 -->


        <! -- SIDEBAR -->
        <div class="col-md-4">
            <?php get_sidebar(); ?>
        </div>
        
    </div><! --/row -->
</div><! --/container -->

<?php get_footer(); ?>