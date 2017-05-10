<?php

function wpb3_settings_menu(){
    add_menu_page(
            'WPB3 Options',
            'WPB3 Options',
            'manage_options',
            'wpb3_settings_menu',
            'wpb3_settings_menu_display',
            ''
            );
}
add_action('admin_menu', 'wpb3_settings_menu');

function wpb3_settings_menu_display(){
    ?>
<div class="wrap">
    <h2>WPB3 Options</h2>
    <?php settings_errors(); ?>
    
    <form method="post" action="options.php">
        <?php settings_fields('wpb3_fields'); ?>
        <?php do_settings_sections('wpb3_settings_menu'); ?>
        <?php submit_button(); ?>
    </form>
</div>
<?php
}

function wpb3_sections_fields_settings(){
    add_settings_section(
            'wpb3_section',
            'WPB3 Options',
            'wpb3_html',
            'wpb3_settings_menu'
            );
    
    //Dodavanje polja za ovu sekciju
    add_settings_field(
            'wpb3_testimonial_clients',
            'Show Testimonial and Client Logos',
            'wpb3_testimonial_clients_html',
            'wpb3_settings_menu',
            'wpb3_section'
            );
    
    //Dodavanje setting pod čijim imenom će se spremati unesene vrijednosti
    register_setting(
            'wpb3_fields',
            'wpb3_field'
            );
    
    //Dodavanje elemenata preko AJAXA
    add_settings_field(
            'wpb3_featured_items',
            'Featured Portfolio Items',
            'wpb3_featured_items_html',
            'wpb3_settings_menu',
            'wpb3_section'
            );
    
    register_setting(
            'wpb3_fields',
            'wpb3_featured'
            );
    
}
add_action('admin_init', 'wpb3_sections_fields_settings');

function wpb3_html(){
    echo "WPB3 Section Description";
}

//Definiranje funkcije koja se poziva kao callback za html
function wpb3_testimonial_clients_html(){
    $option = get_option('wpb3_field'); ?>
<input type="checkbox" value="1" <?php checked("1", $option); ?> name="wpb3_field" />
<?php
}

//Za ajax
function wpb3_featured_items_html(){
    
    $args = array(
        'post_type' => 'portfolio',
        'post_status' => 'publish'
    );
    
    $projects = new WP_Query( $args );
    $featured = get_option( 'wpb3_featured' );
    ?>
<div id="item-list">
    <?php
    if (!empty($featured)) {
        foreach ($featured as $item) {
            ?>
    <select name="wpb3_featured[]">
        <?php
        while ( $projects->have_posts() ) : $projects->the_post(); 
        echo '<option value="' . get_the_ID() . '" ' . selected(get_the_ID(), $item, false) 
                . '>' . get_the_title() . '</option>';
        endwhile; ?>
    </select>
    <span class="removeItem button button-secondary">&laquo; Remove</span><br/>
    <?php
        }
        
    }
    ?>
</div>
<span class="addItem button button-primary">+</span>
<script type="text/javascript">
jQuery('.addItem').on('click', function(){
    
    jQuery.ajax({
        url: ajaxurl,
        data: {
            'action': 'get_items'
        },
        success: function(response){
            jQuery("#item-list").append(response);
        }
    });
});
</script>
<?php
}

//Funkcija čiji sadržaj je novi element select koji sadrži sve moguće odabire
add_action( 'wp_ajax_get_items', 'add_items' );
function add_items(){
    $args = array(
        'post_type' => 'portfolio',
        'post_status' => 'publish'
    );
    
    $projects = new WP_Query( $args );
    if ($projects->have_posts()) : ?>
<select name="wpb3_featured[]">
    <?php
    while ( $projects->have_posts() ) : $projects->the_post();
    echo '<option value="' . get_the_ID() . '">' . get_the_title() . '</option>';
    endwhile; ?>
</select>
<span class="removeItem button button-secondary">&laquo; Remove</span>
<br />
<script type="text/javascript">
jQuery('.removeItem').on('click',function(){
    var select = jQuery(this).prev("select");
    select.remove();
    jQuery(this).remove();
});
</script>
<?php
else : ?>
There are no posts.
<?php
endif;
die();
}