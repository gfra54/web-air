<?php
/*
 * general templating - save/load/delete
 */

global $post;
?>

<div class="wpv-config-row templates">
	<div class="save-template">
		<input type="text" value="" id="wpv-templates-name" />
		<input type="button" class="button-primary" value="<?php printf(__('Save', 'wpv'), $post->post_type);?>" id="wpv-templates-save" />
		<div class="description"><?php _e('If you use the same name as a previously saved template it will overwrite the latter.', 'wpv')?></div>
	</div>
	
	<div class="manage-template">
		<select id="wpv-available-templates">
			<option value=""><?php _e('Loading...', 'wpv')?></option>
		</select>
		
		<input type="button" class="button-primary" value="<?php _e('Load', 'wpv') ?>" id="wpv-templates-load" />
		<input type="button" class="button" value="<?php _e('Delete', 'wpv') ?>" id="wpv-templates-delete" />
	</div>
</div>
