<?php get_header(); ?>

    <div class="container mt">
        <div class="row">

            <?php
            $slike = "";
            if (have_posts()) : while (have_posts()) : the_post();
            $slike = get_images_src('image-singleProject', false, get_the_ID());
            ?>

<?php if (!empty($slike) ) : ?>
            <div class="col-lg-10 col-lg-offset-1 centered">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <?php $brojSlika = count($slike);
                        for ($i = 0; $i < $brojSlika; $i++) { ?>
                        <li data-target="#carousel-example-generic" 
                            data-slide-to="<?php echo $i; ?>" 
<?php if ($i == 0) echo 'class="active"'; ?></li>
                        <?php } ?>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <?php $brojac = 0;
                        foreach ($slike as $slika) {
                        ?>
                        <div class="item <?php if($brojac == 0) echo 'active'; ?>">
                            <?php echo wpb3_generate_portfolio_pictures($slika[0]); ?>
                        </div>
<?php $brojac++;
} ?>
                    </div>
                    
                </div><! --/Carousel -->
            </div>
<?php endif; ?>

            <div class="col-lg-5 col-lg-offset-1">
                <div class="spacing"></div>
                <h4><?php the_title(); ?></h4>
                <?php the_content(); ?>
            </div>

            <div class="col-lg-4 col-lg-offset-1">
                <div class="spacing"></div>
                <h4>
                    Project Details
                    <div class="btn-group">
                        <?php
                        $userID = get_current_user_id();
                        $userVotes = get_post_meta(get_the_ID(), '_wpb3_uservote', true);
                        $voted = false;
                        
                        if (is_array($userVotes)){
                            $found = array_search($userID, $userVotes);
                            if ($found !== false)
                                $voted = true;
                        }
                        
                        $classBTN = "btn-success";
                        if ($voted)
                            $classBTN = "btn-danger";
                        
                        $disabled = "";
                        if ($userID == 0 ||$userID == "0")
                            $disabled = "disabled";
                        ?>
                        <span id="voteUp" onclick="vote(<?php the_ID();?>,<?php echo $userID; ?>);" 
                              class="btn <?php echo $classBTN . " " . $disabled; ?> "  >
                            <span class="glyphicon glyphicon-heart"></span>
                        </span>
                        <?php 
                        $votes = get_post_meta(get_the_ID(), '_wpb3_vote', true);
                        if ($votes == "" || $votes == null) $votes = 0; ?>
                        <span id="voteResult" class="btn btn-primary"><?php echo $votes; ?></span>
                    </div>
                </h4>
                <div class="hline"></div>
                <p><b>Date:</b> <?php the_date(); ?></p>
                <p><b>Author:</b> <?php the_author(); ?></p>
                
                <?php $categories = get_categories(array(
                    'taxonomy' => 'portfolio_category' )); 
                if (!empty($categories)) {
                ?>
                <p><b>Categories:</b> 
                <?php $prvaKategorija = true;
                foreach ($categories as $category) {
                    if ($prvaKategorija != true)
                        echo ', ';
                    echo $category->name;
                    $prvaKategorija = false;
                } ?>
                </p>
                <?php } //ispisujemo samo ako imamo kategorije
                $tags = get_categories(array(
                    'taxonomy' => 'portfolio_tag')); 
                if (!empty($tags)) {
                ?>
                <p><b>Tagged:</b> 
                <?php $prviTag = true;
                foreach ($tags as $tag){
                    if ($prviTag != true)
                        echo ', ';
                    echo $tag->name;
                    $prviTag = false;
                } ?>
                </p>
                <?php } //ispisujemo samo ako imamo tagove
                $clientName = get_post_meta(get_the_ID(), '_wpb3_client_name', true);
                if ( $clientName != "" ) { ?>
                <p><b>Client:</b> <?php echo $clientName; ?></p> <?php } ?>
                
                <?php $clientWeb = get_post_meta(get_the_ID(), '_wpb3_client_web', true);
                if ( $clientWeb != "" ) { ?>
                <p><b>Website:</b> 
                <?php 
                if (strpos($clientWeb, "http://") === false && strpos($clientWeb, "https://") === false)
                        $clientWeb = "http://" . $clientWeb;
                ?>
                    <a href="<?php echo $clientWeb; ?>"><?php echo $clientWeb; ?></a>
                </p>
                <?php } ?>
            </div>

        </div><! --/row -->
        <?php endwhile; endif; ?>
    </div><! --/container -->

    <!-- *****************************************************************************************************************
    PORTFOLIO SECTION
    ***************************************************************************************************************** -->
    <?php
    //definiramo polje i relaciju u SQLu
    $taxonomyProjekta = array('relation' => 'OR');
    //definiramo polje za kategorije
    $kategorije = array();
    
    foreach ($categories as $category) {
        //svaku kategoriju od trenutnog projekta šaljemo u polje $kategorije
        $kategorije[] = $category->slug;
    }
    
    //punimo polje za pretraživanje sa svim kategorijama koje treba pretražiti
    $taxonomyProjekta[] = array(
        'taxonomy' => 'portfolio_category',
        'field' => 'slug',
        'operator' => 'IN',
        'terms' => $kategorije
    );
    
    //definiramo polje za tagove
    $tagovi = array();
    foreach ($tags as $tag) {
        //svaki tag od trenutno projekta šaljemo u polje $tagovi
        $tagovi[] = $tag->slug;
    }
    
    //punimo polje za pretraživanje sa svim tagovima koje treba pretražiti
    $taxonomyProjekta[] = array(
        'taxonomy' => 'portfolio_tag',
        'filed' => 'slug',
        'operator' => 'IN',
        'terms' => $tagovi
    );
    
    //postavljamo sve kategorije i tagove u tax_query i ostali parametri
    $args = array(
        'posts_per_page' => 5,
        'post_type' => 'portfolio',
        'post_status' => 'publish',
        'orderby' => 'rand',
        'post__not_in' => array(get_the_ID()),
        'tax_query' => $taxonomyProjekta
    );
    
    $povezaniProjekti = new WP_Query($args); ?>
    <?php if ($povezaniProjekti->have_posts()) : ?>
    <div id="portfoliowrap">
        <div class="portfolio-centered">
            <h3>Related Works.</h3>
            <div class="recentitems portfolio">
                <?php while ($povezaniProjekti->have_posts()) : $povezaniProjekti->the_post() ?>
                <div class="portfolio-item graphic-design">
                    <div class="he-wrap tpl6">
                        <?php $image = "";
                        if (has_post_thumbnail()) : 
                        the_post_thumbnail('image-thumbProject');
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
                        endif; ?>
                        
                        <div class="he-view">
                            <div class="bg a0" data-animate="fadeIn">
                                <h3 class="a1" data-animate="fadeInDown"><?php the_title(); ?></h3>
                                <?php if ($image != "") { ?>
                                <a data-rel="prettyPhoto" 
                                   href="<?php echo $image[0]; ?>" 
                                   class="dmbutton a2" 
                                   data-animate="fadeInUp">
                                    <i class="fa fa-search"></i>
                                </a> <?php } ?>
                                <a href="<?php the_permalink(); ?>" 
                                   class="dmbutton a2" 
                                   data-animate="fadeInUp">
                                    <i class="fa fa-link"></i>
                                </a>
                            </div><!-- he bg -->
                        </div><!-- he view -->		
                    </div><!-- he wrap -->
                </div><!-- end col-12 -->
                <?php endwhile; ?>


            </div><!-- portfolio -->
        </div><!-- portfolio container -->
    </div><!--/Portfoliowrap -->
    <?php endif; ?>




<?php get_footer(); ?>