<?php
/**
 * multiple color inputs
 */
?>
<div class="wpv-config-row color-row clearfix">
	<div class="rtitle">
		<h4><?php echo $name?></h4>
		
		<?php wpv_description('', $desc) ?>
	</div>
	
	<div class="rcontent clearfix">
		<?php foreach($inputs as $id=>$iname): ?>
			<div class="single-color">
				<div class="single-desc"><?php echo $iname ?></div>
				<div>
					<input name="<?php echo $id ?>" id="<?php echo $id ?>" type="color" data-hex="true" value="<?php echo wpv_get_option($id, $default) ?>" class="<?php wpv_static($value)?>" />
				</div>
			</div>
		<?php endforeach ?>
	</div>
</div>