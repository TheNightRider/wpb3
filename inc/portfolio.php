<?php
/*
 * CPT: Portfolio
 */

/* Registriranje CPT: Portfolio */
function wpb3_portfolio() {
    $labels = array(
        'name' => _x( 'Portfolios', 'Post Type General Name', 'wpb3' ),
        'singular_name' => _x( 'Portfolio', 'Post Type Singular Name', 'wpb3' ),
        'menu_name' => __( 'Portfolio', 'wpb3' ),
        'parent_item_colon' => __( 'Parent Portfolio', 'wpb3' ),
        'all_items' => __( 'All Portfolios', 'wpb3' ),
        'view_items' => __( 'View Portfolio', 'wpb3' ),
        'add_new_item' => __( 'Add New Portfolio', 'wpb3' ),
        'add_new' => __( 'Add Portfolio', 'wpb3' ),
        'edit_item' => __( 'Edit Portfolio', 'wpb3' ),
        'update_item' => __( 'Update Portfolio', 'wpb3' ),
        'search_item' => __( 'Search Portfolio', 'wpb3' ),
        'not_found' => __( 'Not found', 'wpb3' ),
        'not_found_in_trash' => __( 'Not found in Trash', 'wpb3' )
    );
    
    $args = array(
        'label' => __( 'portfolio', 'wpb3' ),
        'description' => __( 'Portfolio Post Type', 'wpb3' ),
        'labels' => $labels,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail'),
        'taxonomies' => array( 'portfolio_category' ),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'rewrite' => array('slug' => 'portfolio', 'with_front' => false)
    );
    
    register_post_type('portfolio', $args);
}

/* Pozovi funkciju pri izvršavanju init dijela WordPressa */
add_action('init', 'wpb3_portfolio', 0);

/* Registracija kategorije - Custom Taxonomy */
function wpb3_portfolio_category(){
    
    $labels = array(
        'name' => _x('Portfolio Categories', 'Taxonomy General Name', 'wpb3'),
        'singular_name' => _x('Portfolio Category', 'Taxonomy Type Singular Name', 'wpb3'),
        'menu_name' => __('Portfolio Category', 'wpb3'),
        'parent_item_colon' => __('Parent Portfolio Category: ', 'wpb3'),
        'all_items' => __('All Portfolios Categories', 'wpb3'),
        'parent_item' => __('Parent Portfolio Category', 'wpb3'),
        'add_new_item' => __('Add New Portfolio Category', 'wpb3'),
        'new_item_name' => __('New Portfolio Category', 'wpb3'),
        'edit_item' => __('Edit Portfolio Category', 'wpb3'),
        'update_item' => __('Update Portfolio Category', 'wpb3'),
        'separate_items_with_commas' => __( 'Separate Portfolio Categories with commas', 'wpb3' ),
        'search_items' => __('Search Portfolio Categories', 'wpb3'),
        'add_or_remove_items' => __( 'Add or remove Portfolio Categories', 'wpb3' ),
        'choose_from_most_used' => __( 'Choose from the most used Portfolio Categories', 'wpb3' ),
        'not_found' => __('Not found', 'wpb3'),
    );
    
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );
    
    register_taxonomy('portfolio_category', array( 'portfolio' ), $args);
}

/* Hook into the 'init' */
add_action('init', 'wpb3_portfolio_category', 0);

/* Registrovanje Custom Tagova */
function wpb3_portfolio_tag() {
    
    $labels = array(
        'name' => _x('Portfolio Tags', 'Taxonomy General Name', 'wpb3'),
        'singular_name' => _x('Portfolio Tag', 'Taxonomy Type Singular Name', 'wpb3'),
        'menu_name' => __('Portfolio Tag', 'wpb3'),
        'parent_item_colon' => __('Parent Portfolio Tag: ', 'wpb3'),
        'all_items' => __('All Portfolios Tags', 'wpb3'),
        'parent_item' => __('Parent Portfolio Tag', 'wpb3'),
        'add_new_item' => __('Add New Portfolio Tag', 'wpb3'),
        'new_item_name' => __('New Portfolio Tag', 'wpb3'),
        'edit_item' => __('Edit Portfolio Tag', 'wpb3'),
        'update_item' => __('Update Portfolio Tag', 'wpb3'),
        'separate_items_with_commas' => __( 'Separate Portfolio Tags with commas', 'wpb3' ),
        'search_items' => __('Search Portfolio Tags', 'wpb3'),
        'add_or_remove_items' => __( 'Add or remove Portfolio Tags', 'wpb3' ),
        'choose_from_most_used' => __( 'Choose from the most used Portfolio Tags', 'wpb3' ),
        'not_found' => __('Not found', 'wpb3'),
    );
    
    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );
    
    register_taxonomy('portfolio_tag', array('portfolio'), $args);
}
/* Hook into the 'init' action */
add_action('init', 'wpb3_portfolio_tag', 0);

/* Dodavanje meta box-a */
function wpb3_portfolio_metabox_html (){
    global $post;
    //Dodaj polje nonce za provjeru pri spremanju
    wp_nonce_field('wpb3_portfolio_metabox', 'wpb3_portfolio_metabox_nonce');
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
    $klijentIme = get_post_meta($post->ID, 'wpb3_client_name', true);
    $klijentWeb = get_post_meta($post->ID, 'wpb3_client_web', true);

    echo '<p><label for="wpb3_client_name">';
    _e('Client Name', 'wpb3');
    echo ':</label>';
    echo ' <input type="text" '
    . 'id="wpb3_client_name" '
    . 'name="wpb3_client_name" '
    . 'value="' . esc_attr($klijentIme) . '" '
    . 'size="25" /></p>';
    
    echo '<p><label for="wpb3_client_web">';
        _e('Client Web', 'wpb3');
    echo ':</label>';
    echo ' <input type="text" '
    . 'id="wpb3_client_web" '
    . 'name="wpb3_client_web" '
    . 'value="' . esc_attr($klijentWeb) . '" '
    . 'size="25" /></p>';
}

function wpb3_portfolio_metabox_add(){
    add_meta_box(
            'portfolio-client', 
            __('Project Client', 'wpb3'), 
            'wpb3_portfolio_metabox_html',
            'portfolio',
            'normal',
            'high'
            );
}
add_action('add_meta_boxes', 'wpb3_portfolio_metabox_add');

//Snimanje podataka
function wpb3_portfolio_metabox__save( ){
    global $post;
    /*
     * We need to verify this came from our screen and with proper authorization
     * because hte save_post action can be triggered at other times
     */
    
    //Check if our nonce is set
    if ( !isset( $_POST['wpb3_portfolio_metabox_nonce'])) 
        return $post_id;
    
    //Verify that our nonce is valid
    if ( !wp_verify_nonce($_POST['wpb3_portfolio_metabox_nonce'], 'wpb3_portfolio_metabox'))
            return $post_id;
    
    //If this is autosave, our form has not been submitted so we dont want to do anything
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;
    
    //Check the user's permissions
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        
        if ( !current_user_can( 'edit_page', $post_id ) )
                return $post_id;
        else if ( !current_user_can( 'edit_post', $post_id ) )
                    return $post_id;
    }
    
    //Sada je sigurno snimiti podatke
    $klijentWeb = $_POST['wpb3_client_web'];
    $klijentIme = $_POST['wpb3_client_name'];
    
    //Sanitaze user input
    $klijentWeb = sanitize_text_field( $klijentWeb );
    $klijentIme = sanitize_text_field( $klijentIme );
    
    //Update the meta field in the database
    update_post_meta($post->ID, 'wpb3_client_name', $klijentIme);
    update_post_meta($post->ID, 'wpb3_client_web', $klijentWeb);
}

add_action('save_post', 'wpb3_portfolio_metabox__save');

/*
 * Plugin za dodavanje više slika Multi Image Metabox
 * Ograničavanje da se prikazuje samo na Custom Type: Portfolio
 */

add_filter('images_cpt', 'my_image_cpt');
function my_image_cpt(){
    $cpts = array('portfolio');
    return $cpts;
}

/*
 * Prema SOLID template potrebne su nove dimenzije slika
 */

add_image_size('image-singleProject', 945, 443, true);
add_image_size('image-thumbProject', 380, 285, true);
