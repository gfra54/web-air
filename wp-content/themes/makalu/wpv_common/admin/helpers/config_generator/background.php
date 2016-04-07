<?php	
	$fields = array(
		'color' => __('Color:', 'wpv'),
		'opacity' => __('Opacity:', 'wpv'),
		'image' => __('Image / pattern:', 'wpv'),
		'repeat' => __('Repeat:', 'wpv'),
		'attachment' => __('Attachment:', 'wpv'),
		'position' => __('Position:', 'wpv'),
		'size' => __('Size:', 'wpv'),
	);

	$sep = isset($sep) ? $sep : '-';

	$current = array();

	if(!isset($only)) {
		if(isset($show)) {
			$only = explode(',', $show);
		} else {
			$only = array();
		}
	} else {
		$only = explode(',', $only);
	}

	$show = array();

	global $post;
	foreach($fields as $field=>$fname) {
		if(isset($GLOBALS['wpv_in_metabox'])) {
			$current[$field] = get_post_meta($post->ID, "$id-$field", true);
		} else {
			$current[$field] = wpv_get_option("$id-$field");
		}
		$show[$field] = (in_array($field, $only) || sizeof($only) == 0)  ? '' : 'hidden';
	}

	$selects = array(
		'repeat' => array(
			'no-repeat' => __('No repeat', 'wpv'),
			'repeat-x' => __('Repeat horizontally', 'wpv'),
			'repeat-y' => __('Repeat vertically', 'wpv'),
			'repeat' => __('Repeat both', 'wpv'),
		),
		'attachment' => array(
			'scroll' => __('scroll', 'wpv'),
			'fixed' => __('fixed', 'wpv'),
		),
		'position' => array(
			'left center' => __('left center', 'wpv'),
			'left top' => __('left top', 'wpv'),
			'left bottom' => __('left bottom', 'wpv'),
			'center center' => __('center center', 'wpv'),
			'center top' => __('center top', 'wpv'),
			'center bottom' => __('center bottom', 'wpv'),
			'right center' => __('right center', 'wpv'),
			'right top' => __('right top', 'wpv'),
			'right bottom' => __('right bottom', 'wpv'),
		),
	);
?>

<div class="wpv-config-row background clearfix <?php echo $class ?>">

	<div class="rtitle">
		<h4><?php echo $name?></h4>

		<?php wpv_description($id, $desc) ?>
	</div>

	<div class="rcontent">
		<div class="bg-inner-row">
			<div class="bg-block color <?php echo $show['color'] ?>">
				<div class="single-desc"><?php _e('Color:', 'wpv') ?></div>
				<input name="<?php echo $id.$sep ?>color" id="<?php echo $id ?>-color" type="color" data-hex="true" value="<?php echo $current['color'] ?>" class="" />
			</div>

			<div class="bg-block opacity <?php echo $show['opacity'] ?> range-input-wrap clearfix">
				<div class="single-desc"><?php _e('Opacity:', 'wpv') ?></div>
				<span>
					<input name="<?php echo $id.$sep?>opacity" id="<?php echo $id?>-opacity" type="range" value="<?php echo $current['opacity']?>" min="0" max="1" step="0.05" class="wpv-range-input" />
				</span>	
			</div>
		</div>

		<div class="bg-inner-row">
			<div class="bg-block image <?php echo $show['image']; ?>">
				<div class="single-desc"><?php _e('Image / pattern:', 'wpv') ?></div>
				<?php $_id = $id;	$id .= $sep.'image'; // temporary change the id so that we can reuse the upload field ?>
				<div class="image <?php wpv_static($value) ?>">
					<?php include 'upload-basic.php'; ?>
				</div>
				<?php $id = $_id; unset($_id); ?>
			</div>

			<?php foreach($selects as $s=>$options): ?>
				<div class="bg-block <?php echo "$s {$show[$s]}"?>">
					<div class="single-desc"><?php echo $fields[$s] ?></div>
					<select name="<?php echo "$id$sep$s" ?>" class="<?php echo $s ?>">
						<?php foreach($options as $val=>$opt): ?>
							<option value="<?php echo $val?>" <?php selected($val, $current[$s]) ?>><?php echo $opt?></option>
						<?php endforeach ?>
					</select>
				</div>
			<?php endforeach ?>

			<div class="bg-block size <?php echo $show['size'] ?>">
				<div class="single-desc"><?php _e('Cover:', 'wpv') ?></div>
				<label class="toggle-radio">
					<input type="radio" name="<?php echo $id.$sep?>size" value="cover" <?php checked($current['size'], 'cover') ?>/>
					<span><?php _e('On', 'wpv') ?></span>
				</label>
				<label class="toggle-radio">
					<input type="radio" name="<?php echo $id.$sep?>size" value="auto" <?php checked($current['size'], 'auto') ?>/>
					<span><?php _e('Off', 'wpv') ?></span>
				</label>
			</div>
		</div>
	</div>
</div>