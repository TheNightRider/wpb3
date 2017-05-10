<?php
/*
 * CPT: Features
 */

//Registrovanje Custom Post Type
function wpb3_features() {
    $labels = array(
        'name' => _x( 'Features', 'Post Type General Name', 'wpb3' ),
        'singular_name' => _x( 'Feature', 'Post Type Singular Name', 'wpb3' ),
        'menu_name' => __( 'Feature', 'wpb3' ),
        'parent_item_colon' => __( 'Parent Feature', 'wpb3' ),
        'all_items' => __( 'All Features', 'wpb3' ),
        'view_items' => __( 'View Feature', 'wpb3' ),
        'add_new_item' => __( 'Add New Feature', 'wpb3' ),
        'add_new' => __( 'Add Feature', 'wpb3' ),
        'edit_item' => __( 'Edit Feature', 'wpb3' ),
        'update_item' => __( 'Update Feature', 'wpb3' ),
        'search_item' => __( 'Search Feature', 'wpb3' ),
        'not_found' => __( 'Not found', 'wpb3' ),
        'not_found_in_trash' => __( 'Not found in Trash', 'wpb3' )
    );
    
    $args = array(
        'label' => __( 'feature', 'wpb3' ),
        'description' => __( 'Feature Post Type', 'wpb3' ),
        'labels' => $labels,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail'),
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
        'rewrite' => array('slug' => 'feature', 'with_front' => false)
    );
    
    register_post_type('feature', $args);
}

//Hook into the 'init' action
add_action('init', 'wpb3_features', 0);

function wpb3_feature_metabox_html($post) {
    //Dodaj polje nonce za provjeru pri spremanju
    wp_nonce_field('wpb3_feature_metabox', 'wpb3_feature_metabox_nonce');
    //if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
    $featureOrder = get_post_meta($post->ID, '_wpb3_feature_order', true);
    $featureShow = get_post_meta($post->ID, '_wpb3_feature_show', true);
    $featureIcon = get_post_meta($post->ID, '_wpb3_feature_icon', true);

    echo '<p><label for="wpb3_feature_icon">';
    _e('Feature Icon', 'wpb3');
    echo ':</label>';
    echo ' <input type="text" '
    . 'id="wpb3_feature_icon" '
    . 'name="wpb3_feature_icon" '
    . 'value="' . esc_attr($featureIcon) . '" '
    . 'size="25" /></p>';
    
    echo '<p><label for="wpb3_feature_order">';
        _e('Order on Web', 'wpb3');
    echo ':</label>';
    echo ' <input type="text" '
    . 'id="wpb3_feature_order" '
    . 'name="wpb3_feature_order" '
    . 'value="' . esc_attr($featureOrder) . '" '
    . 'size="25" /></p>';
    
    echo '<p><label for="wpb3_feature_show">';
        _e('Show on Web', 'wpb3');
    echo ':</label>';
    echo ' <input type="radio" '
    . 'id="wpb3_feature_show" '
    . 'name="wpb3_feature_show" '
    . 'value="No" ' . checked("No",$featureShow,false) . '/>No';
    echo ' <input type="radio" '
    . 'id="wpb3_feature_show" '
    . 'name="wpb3_feature_show" '
    . 'value="Yes" ' . checked("Yes",$featureShow,false) . ' '
    . checked('',$featureShow,false) . '/>Yes</p>';
}

function wpb3_feature_metabox_add() {
    add_meta_box(
            'feature',
            __( 'Additional Feature options', 'wpb3'),
            wpb3_feature_metabox_html,
            'feature',
            'normal',
            'high'
            );
}
add_action('add_meta_boxes', 'wpb3_feature_metabox_add');

//Snimanje Feaure Custom Post Type
function wpb3_feature_metabox__save( $post_id ){
    //global $post;
    /*
     * We need to verify this came from our screen and with proper authorization
     * because hte save_post action can be triggered at other times
     */
    
    //Check if our nonce is set
    if ( !isset( $_POST['wpb3_feature_metabox_nonce'])) 
        return;
    
    //Verify that our nonce is valid
    if ( !wp_verify_nonce($_POST['wpb3_feature_metabox_nonce'], 'wpb3_feature_metabox'))
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
    $featureOrder = $_POST['wpb3_feature_order'];
    $featureShow = $_POST['wpb3_feature_show'];
    $featureIcon = $_POST['wpb3_feature_icon'];
    
    //Sanitaze user input
    $featureOrder = sanitize_text_field( $featureOrder );
    $featureShow = sanitize_text_field( $featureShow );
    $featureIcon = sanitize_text_field( $featureIcon );
    
    //Update the meta field in the database
    update_post_meta($post_id, '_wpb3_feature_order', $featureOrder);
    update_post_meta($post_id, '_wpb3_feature_show', $featureShow);
    update_post_meta($post_id, '_wpb3_feature_icon', $featureIcon);
}

add_action('save_post', 'wpb3_feature_metabox__save');