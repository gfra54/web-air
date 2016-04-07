<?php
/**
 * icons selector
 */

	$checked = wpv_get_option($id, $default);
?>

<div class="wpv-config-row icons clearfix <?php echo $class?>">
	
	<div class="rtitle">
		<h4><label for="<?php echo $id?>"><?php echo $name?></label></h4>
		
		<?php wpv_description($id, $desc) ?>
	</div>
	
	<div class="rcontent">
		<input type="search" placeholder="<?php esc_attr_e('Filter icons', 'wpv') ?>" class="icons-filter"/>
		<div class="icons-wrapper spinner">
			<input type="radio" name="<?php echo $id?>" id="<?php echo $id ?>-initial" value="<?php echo esc_attr($checked) ?>" checked="checked"/>
		</div>
	</div>
</div>
