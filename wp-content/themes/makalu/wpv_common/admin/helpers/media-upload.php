<?php

/*
 * returns the action for the upload form
 */

function media_image_form_url($form_action_url, $type){
	return $form_action_url.'&media_image_upload=1';
}

/*
 * edit "edit" fields (sounds "nice", I should find some better explanation)
 */

function media_image_attachment_fields_to_edit($form_fields, $post){
	unset($form_fields['url'], $form_fields['align'], $form_fields['image-size']);
	$filename = basename( $post->guid );
	$attachment_id = $post->ID;
	if ( current_user_can( 'delete_post', $attachment_id ) ) {
		if ( !EMPTY_TRASH_DAYS ) {
			$delete = "<a href='" . wp_nonce_url( "post.php?action=delete&amp;post=$attachment_id", 'delete-attachment_' . $attachment_id ) . "' id='del[$attachment_id]' class='delete'>" . __('Delete Permanently', 'wpv') . '</a>';
		} elseif ( !MEDIA_TRASH ) {
			$delete = "<a href='#' class='del-link' onclick=\"document.getElementById('del_attachment_$attachment_id').style.display='block';return false;\">" . __('Delete', 'wpv') . "</a>
			 <div id='del_attachment_$attachment_id' class='del-attachment' style='display:none;'>" . sprintf( __('You are about to delete <strong>%s</strong>.', 'wpv'), $filename ) . "
			 <a href='" . wp_nonce_url( "post.php?action=delete&amp;post=$attachment_id", 'delete-attachment_' . $attachment_id ) . "' id='del[$attachment_id]' class='button'>" . __('Continue', 'wpv') . "</a>
			 <a href='#' class='button' onclick=\"this.parentNode.style.display='none';return false;\">" . __('Cancel', 'wpv') . "</a>
			 </div>";
		} else {
			$delete = "<a href='" . wp_nonce_url( "post.php?action=trash&amp;post=$attachment_id", 'trash-attachment_' . $attachment_id ) . "' id='del[$attachment_id]' class='delete'>" . __('Move to Trash', 'wpv') . "</a>
			<a href='" . wp_nonce_url( "post.php?action=untrash&amp;post=$attachment_id", 'untrash-attachment_' . $attachment_id ) . "' id='undo[$attachment_id]' class='undo hidden'>" . __('Undo', 'wpv') . "</a>";
		}
	} else {
		$delete = '';
	}
	
	$form_fields['buttons'] = array( 
		'tr' => "\t\t<tr><td></td><td><input type='button' class='button' onclick='wpv_media_add(".$post->ID.")' value='" . esc_attr__('Insert', 'wpv') . "' /> $delete</td></tr>\n"
	);
	return $form_fields;
}

/*
 * init function that adds the above filters
 */

function media_image_upload_init(){
	add_filter('flash_uploader', 'disable_flash_uploader');
	add_filter('media_upload_tabs', 'image_upload_tabs');
	add_filter('attachment_fields_to_edit', 'media_image_attachment_fields_to_edit', 10, 2);
	add_filter('media_upload_form_url', 'media_image_form_url', 10, 2);

	wp_enqueue_script('wpv-image-upload', WPV_ADMIN_ASSETS_URI . 'js/media-image-upload.js');
}

add_action('admin_init', 'media_image_upload_init');