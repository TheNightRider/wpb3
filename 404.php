<?php get_header(); ?>

<div class="container mtb">
    <div class="row">

        <! -- BLOG POSTS LIST -->
        <div class="col-md-8">
            <p><?php _e('Nothing found, 404 error.. sorry', 'wpb3'); ?></p>
            <?php get_search_form(); ?>
        </div><! --/col-lg-8 -->


        <! -- SIDEBAR -->
        <div class="col-md-4">
            <?php get_sidebar(); ?>
        </div>
        
    </div><! --/row -->
</div><! --/container -->

<?php get_footer(); ?>