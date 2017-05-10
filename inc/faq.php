<?php
/*
 * CPT: FAQ
 */

//Register Custom Post Type
function wpb3_faq() {
    $labels = array(
        'name' => _x( 'FAQs', 'Post Type General Name', 'wpb3' ),
        'singular_name' => _x( 'FAQs', 'Post Type Singular Name', 'wpb3' ),
        'menu_name' => __( 'FAQs', 'wpb3' ),
        'parent_item_colon' => __( 'Parent FAQs', 'wpb3' ),
        'all_items' => __( 'All FAQs', 'wpb3' ),
        'view_items' => __( 'View FAQs', 'wpb3' ),
        'add_new_item' => __( 'Add New FAQs', 'wpb3' ),
        'add_new' => __( 'Add FAQs', 'wpb3' ),
        'edit_item' => __( 'Edit FAQs', 'wpb3' ),
        'update_item' => __( 'Update FAQs', 'wpb3' ),
        'search_item' => __( 'Search FAQs', 'wpb3' ),
        'not_found' => __( 'Not found', 'wpb3' ),
        'not_found_in_trash' => __( 'Not found in Trash', 'wpb3' )
    );
    
    $args = array(
        'label' => __( 'faq', 'wpb3' ),
        'description' => __( 'FAQ Post Type', 'wpb3' ),
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
        'rewrite' => array('slug' => 'faq', 'with_front' => false)
    );
    
    register_post_type('faq', $args);
}
//Hook into the 'init' action
add_action('init', 'wpb3_faq', 0);