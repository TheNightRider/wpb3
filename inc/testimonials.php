<?php
/*
 * CPT: Testimonials
 */

/* Registriranje CPT: Testimonials */
function wpb3_testimonial() {
    $labels = array(
        'name' => _x( 'Testimonials', 'Post Type General Name', 'wpb3' ),
        'singular_name' => _x( 'Testimonial', 'Post Type Singular Name', 'wpb3' ),
        'menu_name' => __( 'Testimonial', 'wpb3' ),
        'parent_item_colon' => __( 'Parent Testimonial', 'wpb3' ),
        'all_items' => __( 'All Testimonials', 'wpb3' ),
        'view_items' => __( 'View Testimonial', 'wpb3' ),
        'add_new_item' => __( 'Add New Testimonial', 'wpb3' ),
        'add_new' => __( 'Add Testimonial', 'wpb3' ),
        'edit_item' => __( 'Edit Testimonial', 'wpb3' ),
        'update_item' => __( 'Update Testimonial', 'wpb3' ),
        'search_item' => __( 'Search Testimonial', 'wpb3' ),
        'not_found' => __( 'Not found', 'wpb3' ),
        'not_found_in_trash' => __( 'Not found in Trash', 'wpb3' )
    );
    
    $args = array(
        'label' => __( 'testimonial', 'wpb3' ),
        'description' => __( 'Testimonial Post Type', 'wpb3' ),
        'labels' => $labels,
        'supports' => array( 'title', 'editor'),
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
        'rewrite' => array('slug' => 'testimonial', 'with_front' => false)
    );
    
    register_post_type('testimonial', $args);
}

/* Pozovi funkciju pri izvršavanju init dijela WordPressa */
add_action('init', 'wpb3_testimonial', 0);



/* Dodavanje meta box-a */
function wpb3_testimonial_metabox_html ( $post ){
    //Dodaj polje nonce za provjeru pri spremanju
    wp_nonce_field('wpb3_testimonial_metabox', 'wpb3_testimonial_metabox_nonce');
    //if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
    $klijentPosition = get_post_meta($post->ID, '_wpb3_testimonial_position', true);
    $klijentWeb = get_post_meta($post->ID, '_wpb3_testimonial_web', true);

    echo '<p><label for="wpb3_testimonial_position">';
    _e('Client Name', 'wpb3');
    echo ':</label>';
    echo ' <input type="text" '
    . 'id="wpb3_testimonial_position" '
    . 'name="wpb3_testimonial_position" '
    . 'value="' . esc_attr($klijentPosition) . '" '
    . 'size="25" /></p>';
    
    echo '<p><label for="wpb3_testimonial_web">';
        _e('Client Web', 'wpb3');
    echo ':</label>';
    echo ' <input type="text" '
    . 'id="wpb3_testimonial_web" '
    . 'name="wpb3_testimonial_web" '
    . 'value="' . esc_attr($klijentWeb) . '" '
    . 'size="25" /></p>';
}

function wpb3_testimonial_metabox_add(){
    add_meta_box(
            'testimonial-client', 
            __('Testimonial Client', 'wpb3'), 
            'wpb3_testimonial_metabox_html',
            'testimonial',
            'normal',
            'high'
            );
}
add_action('add_meta_boxes', 'wpb3_testimonial_metabox_add');

//Snimanje podataka
function wpb3_testimonial_metabox__save( $post_id ){
    /*
     * We need to verify this came from our screen and with proper authorization
     * because hte save_post action can be triggered at other times
     */
    
    //Check if our nonce is set
    if ( !isset( $_POST['wpb3_testimonial_metabox_nonce'])) 
        return;
    
    //Verify that our nonce is valid
    if ( !wp_verify_nonce($_POST['wpb3_testimonial_metabox_nonce'], 'wpb3_testimonial_metabox'))
            return;
    
    //If this is autosave, our form has not been submitted so we dont want to do anything
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return;
    
    //Check the user's permissions
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        
        if ( !current_user_can( 'edit_page', $post_id ) )
                return;
        else if ( !current_user_can( 'edit_post', $post_id ) )
                    return;
    }
    
    //Sada je sigurno snimiti podatke
    $klijentWeb = $_POST['wpb3_testimonial_web'];
    $klijentPosition = $_POST['wpb3_testimonial_position'];
    
    //Sanitaze user input
    $klijentWeb = sanitize_text_field( $klijentWeb );
    $klijentPosition = sanitize_text_field( $klijentPosition );
    
    //Update the meta field in the database
    update_post_meta($post_id, '_wpb3_testimonial_position', $klijentPosition);
    update_post_meta($post_id, '_wpb3_testimonial_web', $klijentWeb);
}

add_action('save_post', 'wpb3_testimonial_metabox__save');

