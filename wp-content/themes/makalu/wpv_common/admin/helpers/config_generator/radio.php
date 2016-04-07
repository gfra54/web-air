<?php
/**
 * radio
 */

	if (isset($target)) {
		if (isset($options))
			$options = $options + Config_Generator::get_select_target_config($target);
		else
			$options = Config_Generator::get_select_target_config($target);
	}

	$checked = wpv_get_option($id, $default);
?>

<div class="wpv-config-row radio clearfix <?php echo $class?>">
	
	<div class="rtitle">
		<h4><label for="<?php echo $id?>"><?php echo $name?></label></h4>
		
		<?php wpv_description($id, $desc) ?>
	</div>
	
	<div class="rcontent">
		<?php foreach($options as $key => $option): ?>
			<label class="toggle-radio">
				<input type="radio" name="<?php echo $id?>" value="<?php echo $key ?>" <?php checked($checked, $key) ?>/>
				<span><?php echo $option ?></span>
			</label>
		<?php endforeach ?>
	</div>
</div>
