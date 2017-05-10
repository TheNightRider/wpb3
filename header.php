<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title><?php wp_title(); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
        <?php wp_head(); ?>
    </head>
    <body>
            <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#header-menu">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <a class="navbar-brand" href="<?php echo home_url(); ?>"><?php echo bloginfo('name'); ?></a>
        </div>
          <?php wp_nav_menu(array(
              'menu' => 'header-menu',
              'theme_location' => 'header-menu',
              'depth' => 2,
              'container' => 'div',
              'container_class' => 'navbar-collapse collapse navbar-right',
              'container_id' => 'header-menu',
              'menu_class' => 'nav navbar-nav',
              'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
              'walker' => new wp_bootstrap_navwalker()
          )); ?>
      </div>
    </div>
            	<!-- *****************************************************************************************************************
	 BLUE WRAP
	 ***************************************************************************************************************** -->
	<?php if (!is_home() && !is_front_page()) : ?>
                
        <div id="blue">
	    <div class="container">
			<div class="row">
                            <h3><?php wp_title(); ?></h3>
			</div><!-- /row -->
	    </div> <!-- /container -->
	</div><!-- /blue -->
        <?php endif; ?>