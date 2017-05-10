<?php
/*
 * Template Name: Contact Page
 */

get_header();
?>

<!-- *****************************************************************************************************************
         CONTACT WRAP
         ***************************************************************************************************************** -->

<div id="contactwrap"></div>

<!-- *****************************************************************************************************************
 CONTACT FORMS
 ***************************************************************************************************************** -->

<div class="container mtb">
    <div class="row">
        <div class="col-lg-8">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <h4><?php the_title(); ?></h4>
                    <div class="hline"></div>
                    <?php the_content(); ?>
                <?php endwhile;
            endif;
            ?>

        </div><! --/col-lg-8 -->

        <div class="col-lg-4">

            <?php
            if (is_active_sidebar('contact-sidebar'))
                dynamic_sidebar('contact-sidebar');
            ?>

        </div>
    </div><!--/row -->
</div><!--/container -->

<?php get_footer();
?>