<?php
/*
 * CPT: Team
 */

/* Registriranje CPT: Portfolio */
function wpb3_team() {
    $labels = array(
        'name' => _x( 'Teams', 'Post Type General Name', 'wpb3' ),
        'singular_name' => _x( 'Team', 'Post Type Singular Name', 'wpb3' ),
        'menu_name' => __( 'Team', 'wpb3' ),
        'parent_item_colon' => __( 'Parent Team', 'wpb3' ),
        'all_items' => __( 'All Teams', 'wpb3' ),
        'view_items' => __( 'View Team', 'wpb3' ),
        'add_new_item' => __( 'Add New Team', 'wpb3' ),
        'add_new' => __( 'Add Team', 'wpb3' ),
        'edit_item' => __( 'Edit Team', 'wpb3' ),
        'update_item' => __( 'Update Team', 'wpb3' ),
        'search_item' => __( 'Search Team', 'wpb3' ),
        'not_found' => __( 'Not found', 'wpb3' ),
        'not_found_in_trash' => __( 'Not found in Trash', 'wpb3' )
    );
    
    $args = array(
        'label' => __( 'team', 'wpb3' ),
        'description' => __( 'Team Post Type', 'wpb3' ),
        'labels' => $labels,
        'supports' => array( 'title', 'editor', 'thumbnail'),
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
        'rewrite' => array('slug' => 'team', 'with_front' => false)
    );
    
    register_post_type('team', $args);
}

/* Pozovi funkciju pri izvršavanju init dijela WordPressa */
add_action('init', 'wpb3_team', 0);

function wpb3_team_metabox_html ( $post ){
    //Dodaj polje nonce za provjeru pri spremanju
    wp_nonce_field('wpb3_team_metabox', 'wpb3_team_metabox_nonce');
    //if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
    $teamPosition = get_post_meta($post->ID, '_wpb3_team_position', true);
    $teamEmail = get_post_meta($post->ID, '_wpb3_team_email', true);
    $teamTwitter = get_post_meta($post->ID, '_wpb3_team_twitter', true);

    echo '<p><label for="wpb3_team_position">';
    _e('Client Position', 'wpb3');
    echo ':</label>';
    echo ' <input type="text" '
    . 'id="wpb3_team_position" '
    . 'name="wpb3_team_position" '
    . 'value="' . esc_attr($teamPosition) . '" '
    . 'size="25" /></p>';
    
    echo '<p><label for="wpb3_team_email">';
        _e('Client Email', 'wpb3');
    echo ':</label>';
    echo ' <input type="text" '
    . 'id="wpb3_team_email" '
    . 'name="wpb3_team_email" '
    . 'value="' . esc_attr($teamEmail) . '" '
    . 'size="25" /></p>';
    
    echo '<p><label for="wpb3_team_twitter">';
        _e('Client Twitter', 'wpb3');
    echo ':</label>';
    echo ' <input type="text" '
    . 'id="wpb3_team_twitter" '
    . 'name="wpb3_team_twitter" '
    . 'value="' . esc_attr($teamTwitter) . '" '
    . 'size="25" /></p>';
}

function wpb3_team_metabox_add(){
    add_meta_box(
            'team-client', 
            __('Team member info', 'wpb3'), 
            'wpb3_team_metabox_html',
            'team',
            'normal',
            'high'
            );
}
add_action('add_meta_boxes', 'wpb3_team_metabox_add');

function wpb3_team_metabox__save( $post_id ){
    /*
     * We need to verify this came from our screen and with proper authorization
     * because hte save_post action can be triggered at other times
     */
    
    //Check if our nonce is set
    if ( !isset( $_POST['wpb3_team_metabox_nonce'])) 
        return;
    
    //Verify that our nonce is valid
    if ( !wp_verify_nonce($_POST['wpb3_team_metabox_nonce'], 'wpb3_team_metabox'))
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
    $teamPosition = $_POST['wpb3_team_position'];
    $teamEmail = $_POST['wpb3_team_email'];
    $teamTwitter = $_POST['wpb3_team_twitter'];
    
    //Sanitaze user input
    $teamPosition = sanitize_text_field( $teamPosition );
    $teamEmail = sanitize_text_field( $teamEmail );
    $teamTwitter = sanitize_text_field( $teamTwitter );
    
    //Update the meta field in the database
    update_post_meta($post_id, '_wpb3_team_position', $teamPosition);
    if (filter_var($teamEmail, FILTER_VALIDATE_EMAIL)) 
        update_post_meta($post_id, '_wpb3_team_email', $teamEmail);
    else
        add_filter ('redirect_post_location', 'wpb3_errorEmail', 99);
        
    update_post_meta($post_id, '_wpb3_team_twitter', $teamTwitter);
}

add_action('save_post', 'wpb3_team_metabox__save');

//Prikaz poruke za grešku prilikom unosa
add_filter('post_updated_messages', 'wpb3_new_message');
function wpb3_new_message( $messages ){
    $messages['post'][99] = 'Member Email is not correct';
    return $messages;
}

function wpb3_errorEmail( $location ){
    remove_filter('redirect_post_location', __FUNCTION__, 99);
    $location = add_query_arg('message', 99, $location);
    return $location;
}