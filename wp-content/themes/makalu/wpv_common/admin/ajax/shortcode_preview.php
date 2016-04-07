<?php
	global $is_shortcode_preview;
	$is_shortcode_preview = true;

	require_once( '../../../../../../wp-load.php' );

	define('WPV_NO_PAGE_CONTENT', true);
?><!doctype html>
<html>
<head>
	<?php wp_head() ?>
	<?php $shortcode = stripslashes($_POST['data']); ?>
	<style>
		html, body {
			background: transparent;
		}
		body {
			<?php if(strpos($shortcode, '[tooltip') !== false):?>
				padding: 100px 10px 10px 150px;
			<?php else: ?>
				padding: 10px;
			<?php endif ?>
		}
	</style>
</head>
<body class="shortcode-preview">
	<div id="preview-content">
		<div>
			<?php echo apply_filters('the_content', do_shortcode($shortcode)) ?>
	<?php get_footer() ?>
</body>	
</html>
