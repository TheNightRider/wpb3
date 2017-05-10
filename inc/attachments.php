<?php

/*
 * Adding our cuostom fields to the $form_fields array
 * 
 * @param array $form_fields
 * @param object $post
 * @return array
 */

function wpb3_attachment_new_field($form_fields, $post) {
    $check_meta = get_post_meta($post->ID, '_wpb3_client_image', true);

    $form_fields['wpb3_client_image']['label'] = __('Client Image?');
    $form_fields['wpb3_client_image']['input'] = "html";
    $form_fields['wpb3_client_image']['html'] = "<input style='width:auto'
 type='radio' value='0' name='attachments[{$post->ID}][wpb3_client_image]'
 " . checked($check_meta, "0", false) . " " . checked($check_meta, "", false) . "
 id='attachments[{$post->ID}][wpb3_client_image]' /> No <br/>
 <input type='radio' style='width:auto' value='1' " . checked($check_meta, "1", false) . " name='attachments[{$post->ID}][wpb3_client_image]'
 id='attachments[{$post->ID}][wpb3_client_image]' /> Yes";
    return $form_fields;
}

//attach our function to the correct hook
add_filter('attachment_fields_to_edit', 'wpb3_attachment_new_field', null, 2);

function wpb3_attachment_fields_to_save($post, $attachment) {
    if (isset($attachment['wpb3_client_image'])) {
        update_post_meta($post['ID'], '_wpb3_client_image', $attachment['wpb3_client_image']);
    }
    return $post;
}

add_filter('attachment_fields_to_save', 'wpb3_attachment_fields_to_save', null, 2);
